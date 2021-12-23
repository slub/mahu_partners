<?php
namespace Slub\MahuPartners\Domain\Repository;

/***
 *
 * This file is part of the "Mahu Companies" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2019
 *
 ***/

/**
 * The repository for Regulations
 */
class RegulationRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
    public function findByName($name)
    {
        $query = $this->createQuery();
        $query->matching($query->equals('name', $name));
        return $query->execute();
    }
    
    public function findByID($id)
    {
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectSysLanguage(false);

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
        
        if ($q["offset"] && (int)$q["offset"] > 0){
            $query->setOffset( $q["offset"] );
        }
        
        if ($q["count"] && (int)$q["count"] > 0){
            $query->setLimit( $q["count"] );
        }
        
        $sort = $q["sort"];
        if ($sort && !empty($sort)) {
            $sconfig = explode(" ", $sort);
            if ($sconfig[1] == "asc") {
                $query->setOrderings(array($sconfig[0] => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING));
            } else {
                $query->setOrderings(array($sconfig[0] => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING));
            }
        } else {
            $query->setOrderings(array("name" => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING));
        }
        
        $numFoundQuery = $this->createQuery();
        
        $query->matching(
            $query->logicalOr(
                [
                    $query->like('name', "%".$name."%"),
                    $query->like('tags', "%".$name."%")
                ]
            )
        );
        
        $numFoundQuery->matching(
            $numFoundQuery->logicalOr(
                [
                    $numFoundQuery->like('name', "%".$name."%"),
                    $numFoundQuery->like('tags', "%".$name."%")
                ]
                )
            );
        
        return array (
            "queryResult" => $query->execute(),
            "numfound" => $numFoundQuery->execute()->getQuery()->count()
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
        
        // enrich suggestions for the field "tags"
        $c= count($res);
        if ($c < $limit) {
            $query = $this->createQuery();
            $query->setLimit($limit - $c);
            $query->matching($query->like('tags', "%".$q."%"));
            $resObjs = $query->execute();

            foreach ($resObjs->toArray() as $resObj) {
                $ts = $resObj->getTags();
                $tse = explode(";", $ts);
                foreach($tse as $t) {
                    if (stripos($t , $q) !== false) {
                        if (!in_array($t, $res)){
                            $res[] = $t;
                        }
                    }
                }
            }
        }
        
        return $res;
    }
}
