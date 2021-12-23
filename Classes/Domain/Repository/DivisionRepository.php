<?php
namespace Slub\MahuPartners\Domain\Repository;

use TYPO3\CMS\Extbase\Persistence\Repository;

/**
 * 
 * @package Slub\MahuPartners\Domain\Repository\
 * @author radeck
 *
 */
class DivisionRepository extends Repository
{
    
    public function findByID($id)
    {
        $query = $this->createQuery();
        $query->matching(
            $query->logicalOr([
                $query->equals("uid", $id),
                $query->equals('id', $id)
            ])
        );
        return $query->execute();
    }
    
    public function findByQuery($q){
        $name = $q["name"];
        
        $query = $this->createQuery();
        //$query->setOffset( $q["offset"] );
        //$query->setLimit( $q["count"] );
        
        //$numFoundQuery = $this->createQuery();
        
        $query->matching($query->like('name', "%".$name."%"));
        //$numFoundQuery->matching($query->like('name', "%".$name."%"));
        
        $res = $query->execute();
        
        return array (
            "queryResult" => $res,
            "numfound" => $res->getQuery()->count()
        );
    }
    
    public function suggest($q, $l) {
        $limit = 5;
        if (is_int($l)) {
            $limit = $l;
        }
        
        $query = $this->createQuery();
        $query->setLimit($limit);
        $query->matching($query->like('name', "%".$q."%"));
        $resObjs = $query->execute();
        
        $res = array();
        foreach ($resObjs->toArray() as $resObj) {
            $res[] = $resObj->getName();
        }
        
        return $res;
    }
}

?>