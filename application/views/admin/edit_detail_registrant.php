<!-- Edit Detail -->
<div class="modal fade" id="editDetail" tabindex="-1" role="dialog" aria-labelledby="editProfil" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title text-center" id="tambahModal">Edit Pendaftar</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal wrapper" role="form" method="post" action="<?=base_url();?>/admin/do_edit_detail/<?=$id?>">
        <div class="form-group">
            <div class="col-sm-offset-4 col-sm-7">
                <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-floppy-save">&nbsp;Simpan</button>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label">Tanggal Lahir :</label>
            <div class="col-sm-7">
                <input class="form-control datepicker" type="text" required="true"
                       data-date-format="dd-mm-yyyy" name="birth_date" value="<?php echo (is_null($registrant_detail->getBirthDate()))?'':$registrant_detail->getBirthDate()->format('d-m-Y');?>">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label">Tempat Lahir :</label>
            <div class="col-sm-7">
                <input type="text" required="true" name="birth_place" class="form-control" placeholder="Tempat Lahir" value="<?=$registrant_detail->getBirthPlace();?>">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label">Alamat :</label>
            <div class="col-sm-7">
                <textarea class="form-control col-sm-10" required="true" rows="3" name="address"><?=$registrant_detail->getAddress();?></textarea>
            </div>
        </div>
        <!-- TODO: Family Condition pake radio -->
        <div class="form-group">
            <label class="col-sm-4 control-label">Keluarga Pendaftar :</label>
            <div class="col-sm-7">
                <div class="radio">
                    <label>
                        <input type="radio" name="family_condition" value="lengkap" 
                            <?php if(!empty($registrant_detail->getFamilyCondition())):?>
                                <?php if($registrant_detail->getFamilyCondition() ==='lengkap'):?>
                                checked="true"
                                <?php endif;?>
                            <?php endif;?>>
                        Lengkap
                    </label>
                </div>
                <div class="radio">
                    <label>
                        <input type="radio" name="family_condition" value="yatim" 
                            <?php if(!empty($registrant_detail->getFamilyCondition())):?>
                                <?php if($registrant_detail->getFamilyCondition() ==='yatim'):?>
                                checked="true"
                                <?php endif;?>
                            <?php endif;?>>
                        Yatim
                    </label>
                </div>
                <div class="radio">
                    <label>
                        <input type="radio" name="family_condition" value="piatu" 
                            <?php if(!empty($registrant_detail->getFamilyCondition())):?>
                                <?php if($registrant_detail->getFamilyCondition() ==='piatu'):?>
                                checked="true"
                                <?php endif;?>
                            <?php endif;?>>
                        Piatu
                    </label>
                </div>
                <div class="radio">
                    <label>
                        <input type="radio" name="family_condition" value="yatim piatu" 
                            <?php if(!empty($registrant_detail->getFamilyCondition())):?>
                                <?php if($registrant_detail->getFamilyCondition() ==='yatim piatu'):?>
                                checked="true"
                                <?php endif;?>
                            <?php endif;?>>
                        Yatim Piatu
                    </label>
                </div>
            </div>
        </div>
        <!-- TODO: Nationality pake radio -->
        <div class="form-group">
            <label class="col-sm-4 control-label ">Kewarganegaraan :</label>
            <div class="col-sm-7">
                <select class="form-control" name="nationality">
                    <option value="WNI"  
                        <?php if(!empty($registrant_detail->getNationality())):?>
                            <?php if($registrant_detail->getNationality()=='WNI'): ?>
                                    selected="true"
                            <?php endif;?>
                        <?php endif;?>>
                        WNI
                    </option>
                    <option value="WNA"  
                        <?php if(!empty($registrant_detail->getNationality())):?>
                            <?php if($registrant_detail->getNationality()=='WNA'): ?>
                                    selected="true"
                            <?php endif;?>
                        <?php endif;?>>
                        WNA
                    </option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label">Agama :</label>
            <div class="col-sm-7">
                <input type="text" required="true" name="religion" id="religion" tabindex="1" class="form-control" placeholder="Agama" value="<?=$registrant_detail->getReligion();?>">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label">Tinggi :</label>
            <div class="col-sm-7">
                <input type="number" required="true" name="height" id="birth_date" tabindex="1" class="form-control" placeholder="Tinggi Badan" value="<?=$registrant_detail->getHeight();?>">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label">Berat :</label>
            <div class="col-sm-7">
                <input type="number" required="true" name="weight" id="birth_date" tabindex="1" class="form-control" placeholder="Berat Badan" value="<?=$registrant_detail->getWeight();?>">
            </div>
        </div>
        <!-- TODO: Riwayat Penyakit -->
        <?php if($registrant_detail->getHospitalSheets()->isEmpty()):?>
        <div class="form-group">
            <label class="col-sm-4 control-label">Riwayat Penyakit :</label>
            <div class="col-sm-4">
                <input type="text" name="hospital_sheets[]" class="form-control" placeholder="Riwayat Penyakit" value="">
            </div>
            <div class="col-sm-4">
                <a class="add_btn_hs btn btn-primary"><span class="glyphicon glyphicon-plus"></span></a>
            </div>
        </div>
        <?php else :
            $count = 0;
            foreach ($registrant_detail->getHospitalSheets() as $h_s):
                ?>
        <div class="form-group">
            <?php if($count == 0): $count++;?>
            <label class="col-sm-4 control-label">Riwayat Penyakit :</label>
            <div class="col-sm-4">
                <input type="text" name="hospital_sheets[]" class="form-control" placeholder="Riwayat Penyakit" value="<?php echo $h_s->getHospitalSheet();?>">
            </div>
            <div class="col-sm-4">
                <a class="add_btn_hs btn btn-primary"><span class="glyphicon glyphicon-plus"></span></a>
            </div>
            <?php else : ?>
            <div class="col-sm-offset-4 col-sm-4">
                <input type="text" required="true" name="hospital_sheets[]" class="form-control" placeholder="Riwayat Penyakit" value="<?php echo $h_s->getHospitalSheet();?>">
            </div>
            <div class="col-sm-4">
                <a class="remove_btn_hs btn btn-warning"><span class="glyphicon glyphicon-remove"></span></a>
            </div>
            <?php endif; ?>
        </div>
        <?php endforeach;?>
        <?php endif;?>
        <!-- TODO: Kelainan Jasmani -->
        <?php if($registrant_detail->getPhysicalAbnormalities()->isEmpty()):?>
        <div class="form-group insert_hs">
            <label class="col-sm-4 control-label">Kelainan Jasmani :</label>
            <div class="col-sm-4">
                <input type="text" name="physical_abnormalities[]" class="form-control" placeholder="Kelainan Jasmani" value="">
            </div>
            <div class="col-sm-4">
                <a class="add_btn_pa btn btn-primary"><span class="glyphicon glyphicon-plus"></span></a>
            </div>
        </div>
        <?php else :
            $count = 0;
            foreach ($registrant_detail->getPhysicalAbnormalities() as $p_a):
                ?>
        <div class="form-group insert_hs">
            <?php if($count == 0): $count++;?>
            <label class="col-sm-4 control-label">Kelainan Jasmani :</label>
            <div class="col-sm-4">
                <input type="text" name="physical_abnormalities[]" class="form-control" placeholder="Kelainan Jasmani" value="<?php echo $p_a->getPhysicalAbnormality();?>">
            </div>
            <div class="col-sm-4">
                <a class="add_btn_pa btn btn-primary"><span class="glyphicon glyphicon-plus"></span></a>
            </div>
            <?php else : ?>
            <div class="col-sm-offset-4 col-sm-4">
                <input type="text" required="true" name="physical_abnormalities[]" class="form-control" placeholder="Kelainan Jasmani" value="<?php echo $p_a->getPhysicalAbnormality();?>">
            </div>
            <div class="col-sm-4">
                <a class="remove_btn_pa btn btn-warning"><span class="glyphicon glyphicon-remove"></span></a>
            </div>
            <?php endif; ?>
        </div>
        <?php endforeach;?>
        <?php endif;?>
        <div class="form-group insert_pa">
            <label class="col-sm-4 control-label">Tinggal Bersama :</label>
            <div class="col-sm-7">
                <div class="radio">
                    <label>
                        <input type="radio" name="stay_with" value="orang tua" 
                            <?php if(!empty($registrant_detail->getStayWith())):?>
                                <?php if($registrant_detail->getStayWith() ==='orang tua'):?>
                                checked="true"
                                <?php endif;?>
                            <?php endif;?>>
                        Orang Tua
                    </label>
                </div>
                <div class="radio">
                    <label>
                        <input type="radio" name="stay_with" value="kakek nenek" 
                            <?php if(!empty($registrant_detail->getStayWith())):?>
                                <?php if($registrant_detail->getStayWith() ==='kakek nenek'):?>
                                checked="true"
                                <?php endif;?>
                            <?php endif;?>>
                        Kakek Nenek
                    </label>
                </div>
                <div class="radio">
                    <label>
                        <input type="radio" name="stay_with" value="kerabat" 
                            <?php if(!empty($registrant_detail->getStayWith())):?>
                                <?php if($registrant_detail->getStayWith() ==='kerabat'):?>
                                checked="true"
                                <?php endif;?>
                            <?php endif;?>>
                        Kerabat
                    </label>
                </div>
                <div class="radio">
                    <label>
                        <input type="radio" name="stay_with" value="lainnya" 
                            <?php if(!empty($registrant_detail->getStayWith())):?>
                                <?php if($registrant_detail->getStayWith() ==='yatim piatu'):?>
                                checked="true"
                                <?php endif;?>
                            <?php endif;?>>
                        Lainnya
                    </label>
                </div>
            </div>
        </div>
        <!-- TODO: Prestasi -->
        <?php if($registrant_detail->getAchievements()->isEmpty()):?>
        <div class="form-group">
            <label class="col-sm-4 control-label"> Prestasi yang Diraih :</label>
            <div class="col-sm-4">
                <input type="text" name="achievements[]" class="form-control" placeholder="Prestasi" value="">
            </div>
            <div class="col-sm-4">
                <a class="add_btn_acv btn btn-primary"><span class="glyphicon glyphicon-plus"></span></a>
            </div>
        </div>
        <?php else :
            $count = 0;
            foreach ($registrant_detail->getAchievements() as $acv):
                ?>
        <div class="form-group">
            <?php if($count == 0): $count++;?>
            <label class="col-sm-4 control-label">Prestasi yang Diraih :</label>
            <div class="col-sm-4">
                <input type="text" name="achievements[]" class="form-control" placeholder="Prestasi" value="<?php echo $acv->getAchievement();?>">
            </div>
            <div class="col-sm-4">
                <a class="add_btn_acv btn btn-primary"><span class="glyphicon glyphicon-plus"></span></a>
            </div>
            <?php else : ?>
            <div class="col-sm-offset-4 col-sm-4">
                <input type="text" required="true" name="achievements[]" class="form-control" placeholder="Prestasi" value="<?php echo $acv->getAchievement();?>">
            </div>
            <div class="col-sm-4">
                <a class="remove_btn_acv btn btn-warning"><span class="glyphicon glyphicon-remove"></span></a>
            </div>
            <?php endif; ?>
        </div>
        <?php endforeach;?>
        <?php endif;?>
        <!-- TODO: Hobi -->
        <?php if($registrant_detail->getHobbies()->isEmpty()): //Keep If & Else div sinkron!!!?>
        <div class="form-group insert_acv">
            <label class="col-sm-4 control-label">Hobi :</label>
            <div class="col-sm-4">
                <input type="text" name="hobbies[]" class="form-control" placeholder="Masukkan Hobi" value="">
            </div>
            <div class="col-sm-4">
                <a class="add_btn_hby btn btn-primary"><span class="glyphicon glyphicon-plus"></span></a>
            </div>
        </div>
        <?php else : // ini else-nya 
            $count = 0;
            foreach ($registrant_detail->getHobbies() as $hobby):
                ?>
        <div class="form-group insert_acv">
            <?php if($count == 0): $count++;?>
            <label class="col-sm-4 control-label">Hobi :</label>
            <div class="col-sm-4">
                <input type="text" name="hobbies[]" class="form-control" placeholder="Masukkan Hobi" value="<?php echo $hobby->getHobby();?>">
            </div>
            <div class="col-sm-4">
                <a class="add_btn_hby btn btn-primary"><span class="glyphicon glyphicon-plus"></span></a>
            </div>
            <?php else : ?>
            <div class="col-sm-offset-4 col-sm-4">
                <input type="text" name="hobbies[]" class="form-control" placeholder="Masukkan Hobi" value="<?php echo $hobby->getHobby();?>">
            </div>
            <div class="col-sm-4">
                <a class="remove_btn_hby btn btn-warning"><span class="glyphicon glyphicon-remove"></span></a>
            </div>
            <?php endif; ?>
        </div>
        <?php endforeach;?>
        <?php endif;?>
        <div class="form-group insert_hby">
            <div class="col-sm-offset-4 col-sm-7">
                <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-floppy-save">&nbsp;Simpan</button>
            </div>
        </div>
    </form>
            </div>
        </div>
    </div>
</div>
<!-- =========================================================================== -->

<!-- Edit Detail -->
<?php foreach ($parents as $parent) :
    $parent_data = (empty($arr_parent[$parent]))?new ParentEntity():$arr_parent[$parent];
    ?>
<div class="modal fade" id="edit<?=  ucfirst($parent);?>" tabindex="-1" role="dialog" aria-labelledby="editProfil" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title text-center" id="tambahModal">Edit <?=$parent?></h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal wrapper" role="form" method="post" action="<?=base_url();?>admin/do_edit_parent/<?=$id?>/<?=$parent?>">
                    <div class="form-group">
                        <div class="col-sm-offset-4 col-sm-7">
                            <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-floppy-save">&nbsp;Simpan</button>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Status :</label>
                        <div class="col-sm-7">
                            <div class="radio">
                                <label>
                                    <input type="radio" name="status" value="masih hidup" 
                                        <?php if(!empty($parent_data->getStatus())):?>
                                            <?php if($parent_data->getStatus() ==='masih hidup'):?>
                                            checked="true"
                                            <?php endif;?>
                                        <?php endif;?>>
                                    Masih Hidup
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="status" value="almarhum" 
                                        <?php if(!empty($parent_data->getStatus())):?>
                                            <?php if($parent_data->getStatus() ==='almarhum'):?>
                                            checked="true"
                                            <?php endif;?>
                                        <?php endif;?>>
                                    Almarhum
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="status" value="cerai" 
                                        <?php if(!empty($parent_data->getStatus())):?>
                                            <?php if($parent_data->getStatus() ==='cerai'):?>
                                            checked="true"
                                            <?php endif;?>
                                        <?php endif;?>>
                                    Cerai
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Nama :</label>
                        <div class="col-sm-7">
                            <input type="text" required="true" name="name" class="form-control" placeholder="Masukkan Nama" value="<?=$parent_data->getName();?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Tanggal Lahir :</label>
                        <div class="col-sm-7">
                            <input class="form-control datepicker" type="text" required="true"
                                   data-date-format="dd-mm-yyyy" name="birth_date" value="<?php echo (is_null($parent_data->getBirthDate()))?'':$parent_data->getBirthDate()->format('d-m-Y');?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Tempat Lahir :</label>
                        <div class="col-sm-7">
                            <input type="text" required="true" name="birth_place" class="form-control" placeholder="Tempat Lahir" value="<?=$parent_data->getBirthPlace();?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Alamat :</label>
                        <div class="col-sm-7">
                            <textarea class="form-control col-sm-10" required="true" rows="3" name="address"><?=$parent_data->getAddress();?></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">No. Telp :</label>
                        <div class="col-sm-7">
                            <input type="text" required="true" name="contact" class="form-control" placeholder="Masukkan Nomor Telepon" value="<?=$parent_data->getContact();?>">
                        </div>
                    </div>
                    <!-- Hubungan Darah -->
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Hubungan :</label>
                        <?php if($parent == 'father' || $parent == 'mother') :?>
                        <div class="col-sm-7">
                            <div class="radio">
                                <label>
                                    <input type="radio" name="relation" value="anak kandung" 
                                        <?php if(!empty($parent_data->getRelation())):?>
                                            <?php if($parent_data->getRelation() ==='anak kandung'):?>
                                            checked="true"
                                            <?php endif;?>
                                        <?php endif;?>>
                                    Anak Kandung
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="relation" value="anak tiri" 
                                        <?php if(!empty($parent_data->getRelation())):?>
                                            <?php if($parent_data->getRelation() ==='anak tiri'):?>
                                            checked="true"
                                            <?php endif;?>
                                        <?php endif;?>>
                                    Anak Tiri
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="relation" value="anak angkat" 
                                        <?php if(!empty($parent_data->getRelation())):?>
                                            <?php if($parent_data->getRelation() ==='anak angkat'):?>
                                            checked="true"
                                            <?php endif;?>
                                        <?php endif;?>>
                                    Anak Angkat
                                </label>
                            </div>
                        </div>
                        <?php else :?>
                        <div class="col-sm-7">
                            <input type="text" name="relation" class="form-control" placeholder="Masukkan Hubungan dengan pendaftar" value="<?=$parent_data->getRelation();?>">
                        </div>
                        <?php endif;?>
                    </div>
                    <!-- TODO: Nationality pake radio -->
                    <div class="form-group">
                        <label class="col-sm-4 control-label ">Kewarganegaraan :</label>
                        <div class="col-sm-7">
                            <select class="form-control" name="nationality">
                                <option value="WNI"  
                                    <?php if(!empty($parent_data->getNationality())):?>
                                        <?php if($parent_data->getNationality()=='WNI'): ?>
                                                selected="true"
                                        <?php endif;?>
                                    <?php endif;?>>
                                    WNI
                                </option>
                                <option value="WNA"  
                                    <?php if(!empty($parent_data->getNationality())):?>
                                        <?php if($parent_data->getNationality()=='WNA'): ?>
                                                selected="true"
                                        <?php endif;?>
                                    <?php endif;?>>
                                    WNA
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Agama :</label>
                        <div class="col-sm-7">
                            <input type="text" required="true" name="religion" id="religion" tabindex="1" class="form-control" placeholder="Agama" value="<?=$parent_data->getReligion();?>">
                        </div>
                    </div>
                    <!-- Tingkat Pendidikan -->
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Pendidikan Terakhir :</label>
                        <div class="col-sm-7">
                            <div class="radio">
                                <label>
                                    <input type="radio" name="education_level" value="Tidak Lulus SD" 
                                        <?php if(!empty($parent_data->getEducationLevel())):?>
                                            <?php if($parent_data->getEducationLevel() ==='Tidak Lulus SD'):?>
                                            checked="true"
                                            <?php endif;?>
                                        <?php endif;?>>
                                    Tidak Lulus SD
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-offset-4 col-sm-7">
                            <div class="radio">
                                <label>
                                    <input type="radio" name="education_level" value="SD" 
                                        <?php if(!empty($parent_data->getEducationLevel())):?>
                                            <?php if($parent_data->getEducationLevel() ==='SD'):?>
                                            checked="true"
                                            <?php endif;?>
                                        <?php endif;?>>
                                    SD
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-offset-4 col-sm-7">
                            <div class="radio">
                                <label>
                                    <input type="radio" name="education_level" value="SMP" 
                                        <?php if(!empty($parent_data->getEducationLevel())):?>
                                            <?php if($parent_data->getEducationLevel() ==='SMP'):?>
                                            checked="true"
                                            <?php endif;?>
                                        <?php endif;?>>
                                    SMP
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-offset-4 col-sm-7">
                            <div class="radio">
                                <label>
                                    <input type="radio" name="education_level" value="SMA" 
                                        <?php if(!empty($parent_data->getEducationLevel())):?>
                                            <?php if($parent_data->getEducationLevel() ==='SMA'):?>
                                            checked="true"
                                            <?php endif;?>
                                        <?php endif;?>>
                                    SMA/SMK
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-offset-4 col-sm-7">
                            <div class="radio">
                                <label>
                                    <input type="radio" name="education_level" value="Diploma" 
                                        <?php if(!empty($parent_data->getEducationLevel())):?>
                                            <?php if($parent_data->getEducationLevel() ==='Diploma'):?>
                                            checked="true"
                                            <?php endif;?>
                                        <?php endif;?>>
                                    Diploma
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-offset-4 col-sm-7">
                            <div class="radio">
                                <label>
                                    <input type="radio" name="education_level" value="S1" 
                                        <?php if(!empty($parent_data->getEducationLevel())):?>
                                            <?php if($parent_data->getEducationLevel() ==='S1'):?>
                                            checked="true"
                                            <?php endif;?>
                                        <?php endif;?>>
                                    S1
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-offset-4 col-sm-7">
                            <div class="radio">
                                <label>
                                    <input type="radio" name="education_level" value="S2" 
                                        <?php if(!empty($parent_data->getEducationLevel())):?>
                                            <?php if($parent_data->getEducationLevel() ==='S2'):?>
                                            checked="true"
                                            <?php endif;?>
                                        <?php endif;?>>
                                    S2
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-offset-4 col-sm-7">
                            <div class="radio">
                                <label>
                                    <input type="radio" name="education_level" value="S3" 
                                        <?php if(!empty($parent_data->getEducationLevel())):?>
                                            <?php if($parent_data->getEducationLevel() ==='S3'):?>
                                            checked="true"
                                            <?php endif;?>
                                        <?php endif;?>>
                                    S3
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-offset-4 col-sm-7">
                            <div class="radio">
                                <label>
                                    <input type="radio" name="education_level" value="Lainnya" 
                                        <?php if(!empty($parent_data->getEducationLevel())):?>
                                            <?php if($parent_data->getEducationLevel() ==='Lainnya'):?>
                                            checked="true"
                                            <?php endif;?>
                                        <?php endif;?>>
                                    Lainnya
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Pekerjaan :</label>
                        <div class="col-sm-7">
                            <input type="text" name="job" class="form-control" placeholder="Masukkan Pekerjaan" value="<?=$parent_data->getJob();?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Jabatan :</label>
                        <div class="col-sm-7">
                            <input type="text" name="position" class="form-control" placeholder="Masukkan Jabatan" value="<?=$parent_data->getPosition();?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Nama Instansi :</label>
                        <div class="col-sm-7">
                            <input type="text" name="company" class="form-control" placeholder="Masukkan Tempat Kerja" value="<?=$parent_data->getCompany();?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Penghasilan (Rp.) :</label>
                        <div class="col-sm-7">
                            <input type="number" name="income" required="true" class="form-control" placeholder="Masukkan Penghasilan" value="<?=$parent_data->getIncome();?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Jumlah Tanggungan :</label>
                        <div class="col-sm-7">
                            <input type="text" name="burden_count" <?php echo ($parent == 'father')?'required="true"':'';?> class="form-control" placeholder="Masukkan Jumlah Tanggungan" value="<?=$parent_data->getBurdenCount();?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-4 col-sm-7">
                            <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-floppy-save">&nbsp;Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php endforeach;?>
<!-- =========================================================================== -->

<!-- Ganti Password -->
<div class="modal fade" id="editPassword" tabindex="-1" role="dialog" aria-labelledby="editProfil" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title text-center" id="tambahModal">Ganti Password Pendaftart</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" role="form" method="post" action="<?=base_url().'admin/do_password_registrant/'.$id;?>">
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Password Baru :</label>
                        <div class="col-sm-7">
                            <input type="password" class="form-control" name="password" 
                                   placeholder="Masukkan Password Baru" value="" required="true">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-4 col-sm-7">
                            <button type="submit" class="btn btn-sm btn-primary">OK</button>
                            <a class="btn btn-sm btn-warning" href="<?=base_url();?>home/">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- =========================================================================== -->