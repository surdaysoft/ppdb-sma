<?php



/**
 * RegistrantRepo
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class RegistrantRepo extends Doctrine\ORM\EntityRepository
{
    public function getData($gender = null, $onlyShowCompleted = false, $showDeleted = false){
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->addSelect('r')->from('RegistrantEntity', 'r');
        if(!is_null($gender)){
            $qb->andwhere('r.gender = :gender');
        }
        if($onlyShowCompleted){
            $qb->andWhere($qb->expr()->andX(
                    $qb->expr()->isNotNull('r.father'),
                    $qb->expr()->isNotNull('r.mother')
                    ));
        }
        if(!$showDeleted){
            $qb->andWhere($qb->expr()->neq('r.deleted', ':deleted'));
        }
        $qb->orderBy('r.id', 'ASC');
        if(!is_null($gender)){
            $qb->setParameter('gender', $gender);
        }
        if(!$showDeleted){
            $qb->setParameter('deleted', true);
        }
        $query = $qb->getQuery();
        $result =  $query->getResult();
        return $result;
    }
    
    public function getDataByJurusan($gender = null, $tahfidz = false, $showDeleted = false){
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->Select(['r']);
        $qb->from('RegistrantEntity', 'r')->join('RegistrantDataEntity', 'd');
        $qb->where('r.program = :program');
        if(!is_null($gender)){
            $qb->andwhere('r.gender = :gender');
        }
        $qb->andWhere($qb->expr()->neq('r.deleted', ':deleted'));
        $qb->orderBy('r.id', 'ASC');
        if(!is_null($gender)){
            $qb->setParameter('gender', $gender);
        }
        if($tahfidz){
            $qb->setParameter('program', 'Tahfidz');
        } else {
            $qb->setParameter('program', 'Reguler');
        }
        $qb->setParameter('deleted', !$showDeleted);
        $query = $qb->getQuery();
      
        $query->setFetchMode('RegistrantEntity', 'registrantData', \Doctrine\ORM\Mapping\ClassMetadata::FETCH_EAGER);
        $query->setFetchMode('RegistrantEntity', 'father', \Doctrine\ORM\Mapping\ClassMetadata::FETCH_EAGER);
        $query->setFetchMode('RegistrantEntity', 'mother', \Doctrine\ORM\Mapping\ClassMetadata::FETCH_EAGER);
        $query->setFetchMode('RegistrantEntity', 'guardian', \Doctrine\ORM\Mapping\ClassMetadata::FETCH_EAGER);
        $query->setFetchMode('RegistrantDataEntity', 'achievements', \Doctrine\ORM\Mapping\ClassMetadata::FETCH_EAGER);
        $query->setFetchMode('RegistrantDataEntity', 'hobbies', \Doctrine\ORM\Mapping\ClassMetadata::FETCH_EAGER);
        $query->setFetchMode('RegistrantDataEntity', 'physicalAbnormalities', \Doctrine\ORM\Mapping\ClassMetadata::FETCH_EAGER);
        $query->setFetchMode('RegistrantDataEntity', 'hospitalSheets', \Doctrine\ORM\Mapping\ClassMetadata::FETCH_EAGER);
        $result =  $query->getResult();
        return $result;
    }
    
    public function getCount(){
        $query = $this->getEntityManager()->createQuery('SELECT COUNT(r.id) FROM RegistrantEntity r');
        $count = $query->getSingleScalarResult();   
        return $count;
    }
    
    public function getCountByFilter($filter){
//        try {
            $qb = $this->getEntityManager()->createQueryBuilder();
            $qb->select('COUNT(r.id)')
                    ->from('RegistrantEntity', 'r');
            foreach ($filter as $key => $value){
                $qb->andWhere('r.'.$key .' = :set'.$key);
            }
            $qb->andWhere($qb->expr()->neq('r.deleted', ':deleted'));
            foreach ($filter as $key => $value){
                $qb->setParameter('set'.$key, $value);
            }
            $qb->setParameter('deleted', true);
            $count = $qb->getQuery()->getSingleScalarResult();
            return $count;
//        } catch (Doctrine\ORM\Query\QueryException $e) {
//            return false;
//        }
    }
    
    public function getDataByFilter($filter){
//        try {
            $qb = $this->getEntityManager()->createQueryBuilder();
            $qb->select('r')
                    ->from('RegistrantEntity', 'r');
            foreach ($filter as $key => $value){
                $qb->andWhere('r.'.$key .' = :set'.$key);
            }
            $qb->andWhere($qb->expr()->neq('r.deleted', ':deleted'));
            foreach ($filter as $key => $value){
                $qb->setParameter('set'.$key, $value);
            }
            $qb->setParameter('deleted', true);
            $qb->orderBy('r.id', 'ASC');
            $query = $qb->getQuery();
            $result =  $query->getResult();
            return end($result);
//        } catch (Doctrine\ORM\Query\QueryException $e) {
//            return null;
//        } catch (Doctrine\ORM\NoResultException $e) {
//            return null;
//        } catch (Doctrine\ORM\NonUniqueResultException $e) {
//            return null;
//        }
    }
}
