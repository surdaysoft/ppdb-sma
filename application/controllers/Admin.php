<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * The MIT License
 *
 * Copyright 2015 s4if.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

/**
 * Description of Admin
 *
 * @author s4if
 */
class Admin extends MY_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('Model_registrant','reg');
        $this->load->model('Model_parent','parent');
        $this->load->model('Model_admin','admin');
    }
    
    public function index(){
        $this->beranda();
    }
    
    public function beranda(){
        $this->blockNonAdmin();
        $registrant_data = $this->reg->getArrayData();
        $data = [
            'title' => 'Beranda',
            'username' => $this->session->admin->getUsername(),
            'admin' => $this->session->admin,
            'nav_pos' => 'homeAdmin',
            'data_registrant' => $registrant_data,
            'female_count' => $this->reg->getCount(['gender' => 'P']),
            'male_count' => $this->reg->getCount(['gender' => 'L'])
        ];
        $this->CustomView('admin/home', $data);
    }
    
    public function uncomplete_ajax($unpaid = 'paid'){
        $this->blockNonAdmin();
        $data = [];
        if($unpaid == 'paid'){
            $registrant_data = $this->reg->getIncompleteData();
        } else {
            $registrant_data = $this->reg->getUnpaidData();
        }
        foreach ($registrant_data as $registrant){
            if(!$registrant['completed']) {
                $row = [];
                $row[] = $registrant['id'];
                $row[] = $registrant['name'];
                $row[] = ($registrant['gender'] == 'L') ? 'Ikhwan' : 'Akhwat';
                $row[] = $registrant['cp'];
                $row[] = $registrant['status'];
                $row[] = $registrant['previousSchool'];
                $data [] = $row;
            }
        }
        echo json_encode(['data' => $data]);
    }
    
    public function password(){
        $this->blockNonAdmin();
        $data = [
            'title' => 'Password',
            'username' => $this->session->admin->getUsername(),
            'admin' => $this->session->admin,
            'registrant' => $this->session->registrant,
            'nav_pos' => 'homeAdmin'
        ];
        $this->CustomView('admin/password', $data);
    }
    
    public function change_password($username){
        $this->blockNonAdmin();
        $admin = $this->admin->getData($username);
        $data = $this->input->post(null, true);
        if($data['new_password'] == $data['confirm_password']){
            if(password_verify($data['stored_password'], $admin->getPassword())){
                $this->do_change_password(['password' => $data['new_password'], 'username' => $username]);
            } else {
                $this->session->set_flashdata("errors", [0 => "Maaf, Password lama anda salah <br />"
                    . "Silahkan di periksa kembali."]);
                redirect('admin/password');
            }
        } else {
            $this->session->set_flashdata("errors", [0 => "Maaf, Password baru dan konfirmasi password tidak sama, <br />"
                . "Silahkan di periksa kembali."]);
            redirect('admin/password');
        }        
    }
    
    private function do_change_password($data){
        $this->blockNonAdmin();
        $res = $this->admin->updateData($data);
        if($res){
            $this->session->set_userdata('admin', $this->admin->getData($this->session->admin->getUsername()));
            $this->session->set_flashdata("notices", [0 => "Passsword sudah berhasil diubah."]);
            redirect('admin/password');
        } else {
            $this->session->set_flashdata("errors", [0 => "Maaf, Terjadi Kesalahan"]);
            redirect('admin/password');
        }
    }
    
    public function lihat($gender = null){
        $this->blockNonAdmin();
        $jk = '';
        if(!is_null($gender)){
            $jk = ($gender == 'L')?'Ikhwan':'Akhwat';
        }
        $this->CustomView('admin/data_registrant', [
            'title' => 'Lihat Pendaftar '.$jk,
            'username' => $this->session->admin->getUsername(),
            'admin' => $this->session->admin,
            'nav_pos' => 'registrantAdmin',
            'gender' => $gender,
        ]);
    }
    
    public function lihat_ajax($gender = null){
        $this->blockNonAdmin();
        $registrant_data = (is_null($gender))?$this->reg->getArrayData():$this->reg->getArrayData($gender);
        $data = [];
        foreach ($registrant_data as $registrant){
            $row = [];
            $row[] = $registrant['id'];
            $row[] = $registrant['username'];
            $row[] = $registrant['kode'];
            $row[] = $registrant['name'];
            $row[] = ($registrant['gender'] == 'L') ? 'Ikhwan' : 'Akhwat';
            $row[] = $registrant['previousSchool'];
            $row[] = ucfirst($registrant['program']);
            $row[] = $registrant['cp'];
            $row[] = $registrant['status'];
            $row[] = $this->load->view('admin/fragment/data_registrant', ['registrant' => $registrant], true);
            $data [] = $row;
        }
        echo json_encode(['data' => $data]);
    }
    
    public function registrant($id){
        $this->blockNonAdmin();
        $reg_data = $this->reg->getData(null, $id);
        $data = [
            'title' => 'Profil Pendaftar',
            'username' => $this->session->admin->getUsername(),
            'id' => $id,
            'admin' => $this->session->admin,
            'registrant_data' => $reg_data,
            'registrant_edit' => $this->load->view('admin/edit_detail_registrant',[
                'id' => $id,
                'registrant_detail' => $this->reg->getRegistrantData($reg_data),
                'arr_parent' => $this->parent->getData($id, ['father', 'mother', 'guardian']),
                'parents' => ['father', 'mother', 'guardian']
            ]),
            'img_link' => $this->getImgLink($id),
            'status' => $this->reg->cek_status($reg_data),
            'nav_pos' => 'registrantAdmin'
        ];
        $this->CustomView('admin/profile_registrant', $data);
    }
    
    private function getImgLink($id){
        $this->load->helper('file');
        $img_link = '';
        $file = read_file('./data/foto/'.$id.'.png');
        $datetime = new DateTime('now');
        if($file == false){
            $img_link = base_url().'assets/images/default.png';
        }  else {
            $img_link = base_url().'pendaftar/getFoto/'.$id.'/'.hash('md2', $datetime->format('Y-m-d H:i:s'));
        }
        return $img_link;
    }
    
    public function do_password_registrant($id){
        $this->blockNonAdmin();
        $data = $this->input->post(null, true);
        $data['id'] = $id;
        $res = $this->reg->updateData($data);
        if($res){
             
            $this->session->set_flashdata("notices", [0 => "Data Sudah berhasil disimpan"]);
            redirect('admin/registrant/'.$id);
        } else {
            $this->session->set_flashdata("errors", [0 => "Maaf, Terjadi Kesalahan"]);
            redirect('admin/registrant/'.$id);
        }
    }
    
    public function do_edit_profil($id){
        $this->blockNonAdmin();
        $data = $this->input->post(null, true);
        $data['id'] = $id;
        $res = $this->reg->updateData($data);
        if($res){
             
            $this->session->set_flashdata("notices", [0 => "Data Sudah berhasil disimpan"]);
            redirect('admin/registrant/'.$id);
        } else {
            $this->session->set_flashdata("errors", [0 => "Maaf, Terjadi Kesalahan"]);
            redirect('admin/registrant/'.$id);
        }
    }
    
    public function do_edit_detail($id){
        $this->blockNonAdmin();
        $data = $this->input->post(null, true);
        $res = $this->reg->updateDetail($id, $data);
        if($res){
             
            $this->session->set_flashdata("notices", [0 => "Data Sudah berhasil disimpan"]);
            redirect('admin/registrant/'.$id);
        } else {
            $this->session->set_flashdata("errors", [0 => "Maaf, Terjadi Kesalahan"]);
            redirect('admin/registrant/'.$id);
        }
    }
    
    public function do_edit_parent($id, $type){
        $this->blockNonAdmin();
        $data = $this->input->post(null, true);
        $res = $this->parent->updateData($id, $data, $type);
        if($res){
            $this->session->set_flashdata("notices", [0 => "Data Sudah berhasil disimpan"]);
            redirect('admin/registrant/'.$id);
        } else {
            $this->session->set_flashdata("errors", [0 => "Maaf, Terjadi Kesalahan"]);
            redirect('admin/registrant/'.$id);
        }
    }
    
    public function upload_foto($id) {
        $this->blockNonAdmin();
        $fileUrl = $_FILES['file']["tmp_name"];
        $res = $this->reg->uploadFoto($fileUrl, $id);
        if ($res) {
            $this->session->set_flashdata("notices", [0 => "Upload Foto Berhasil!"]);
            redirect('admin/registrant/'.$id);
        } else {
            $this->session->set_flashdata("errors", [0 => "Upload Foto Gagal!"]);
            redirect('admin/registrant/'.$id);
        }
    }
    
    public function hapus_registrant($id){
        $this->blockNonAdmin();
        $res = $this->reg->deleteData(['id' => $id]);
        if($res){
            $this->session->set_flashdata("notices", [0 => "Data Sudah berhasil dihapus"]);
            redirect('admin/lihat');
        } else {
            $this->session->set_flashdata("errors", [0 => "Maaf, Terjadi Kesalahan"]);
            redirect('admin/lihat');
        }
    }
    
    public function pembayaran($id  = null){
        if(is_null($id)){
            $this->lihat_pembayaran();
        } else {
            $this->lihat_kwitansi($id);
        }
    }
    
    private function lihat_pembayaran (){
        $this->blockNonAdmin();
        $data = $this->admin->getReceipt();
        $this->CustomView('admin/data_pembayaran', [
            'title' => 'Lihat Resi Pembayaran',
            'username' => $this->session->admin->getUsername(),
            'admin' => $this->session->admin,
            'nav_pos' => 'paymentAdmin',
            'data_pembayaran' => $data
        ]);
    }
    
    private function lihat_kwitansi($id){
        $this->blockNonAdmin();
        $resi = $this->admin->getReceipt($id);
        $id_registrant = $resi->getRegistrant()->getId();
        $data = [
            'title' => 'Konfirmasi Pembayaran',
            'username' => $this->session->admin->getUsername(),
            'admin' => $this->session->admin,
            'resi' => $resi,
            'img_receipt' => $this->getImgReceipt($id_registrant),
            'nav_pos' => 'paymentAdmin'
        ];
        $this->CustomView('admin/verifikasi_pembayaran', $data);
    }
    
    private function getImgReceipt($id){
        $this->load->helper('file');
        $img_link = '';
        $file = read_file('./data/receipt/'.$id.'.png');
        $datetime = new DateTime('now');
        if($file == false){
            $img_link = null;
        }  else {
            $img_link = base_url().'pendaftar/getReceipt/'.$id.'/'.hash('md2', $datetime->format('Y-m-d H:i:s'));
        }
        return $img_link;
    }
    
    public function verifikasi($id, $isValid){
        $this->blockNonAdmin();
        $verified = ($isValid == 'valid')?'valid':'tidak valid';
        $verification_date = new DateTime('now');
        $res = $this->admin->updatePayment(['id' => $id, 'verified' => $verified, 'verification_date' => $verification_date->format('d-m-Y') ]);
        if($res){
            $this->session->set_flashdata("notices", [0 => "Data Sudah berhasil disimpan"]);
            redirect('admin/pembayaran/'.$id);
        } else {
            $this->session->set_flashdata("errors", [0 => "Maaf, Terjadi Kesalahan"]);
            redirect('admin/pembayaran/'.$id);
        }
    }
    
    public function export_data($gender = 'L', $programme = 'tahfidz')
    {
        $this->blockNonAdmin();
        $strGender = ('L' == strtoupper($gender))?'Ikhwan':'Akhwat';
        $boolProgramme = ('tahfidz' == strtolower($programme));
        $date = new DateTime('now');
        $this->reg->export('Backup Data PPDB '.  ucfirst(strtolower($strGender)).' '.  ucfirst(strtolower($programme)).' '.$date->format('d-m-Y'),
            $gender, $boolProgramme);
    }
    
    public function export_data_uncomplete()
    {
        $this->blockNonAdmin();
        $date = new DateTime('now');
        $this->reg->export_Uncomplete('Data Belum Lengkap '.$date->format('d-m-Y'));
    }
    
    public function export_data_unpaid()
    {
        $this->blockNonAdmin();
        $date = new DateTime('now');
        $this->reg->export_Uncomplete('Data Belum Membayar '.$date->format('d-m-Y'), false, true);
    }
    
    public function print_kartu_incomplete($unpaid = "false"){
        $registrant_data = [];
        if ($unpaid == "true"){
            $registrant_data = $this->reg->getUnpaidData();
        } else {
            $registrant_data = $this->reg->getIncompleteData();
        }
        $pdf = new mikehaertl\wkhtmlto\Pdf();
        $pdf->setOptions($this->pdfOption());
        foreach ($registrant_data as $registrant){
            $reg_data = $this->load->view('registrant/print', ['registrant' => $registrant['object']], true);
            $pdf->addPage($reg_data);
        }
        $suffix = ($unpaid == "true")?"belum membayar":"belum lengkap";
        $res = $pdf->send('Kartu pendaftar yang '.$suffix.' .pdf');
        if (!$res) { echo $pdf->getError(); }
    }
}
