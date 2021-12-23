<?php
namespace Slub\MahuPartners\Domain\Repository;

use TYPO3\CMS\Extbase\Persistence\Repository;

/**
 * 
 * @package Slub\MahuPartners\Domain\Repository\
 * @author radeck
 *
 */
class CompanyRepository extends Repository
{
    
    public function findByName($name)
    {
        $query = $this->createQuery();
        $query->matching($query->equals('name', $name));
        return $query->execute();
    }
    
    public function getCompanyByDivision($divID){
        $query = $this->createQuery();
        $query->matching($query->equals('divisions.id', $divID));
        return $query->execute()->getFirst();
    }
    
    public function findByUidIgnoreHidden($id) {
        $query = $this->createQuery();
        $query->getQuerySettings()->setIgnoreEnableFields(TRUE);
        $query->getQuerySettings()->setLanguageOverlayMode(TRUE);
        $query->matching($query->equals("uid", $id));
        return $query->execute()->getFirst();
    }
    
    public function findByID($id)
    {
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectSysLanguage(false);
        $query->getQuerySettings()->setLanguageOverlayMode(TRUE);
        $query->matching(
            $query->logicalOr([
                $query->equals("uid", $id),
                $query->equals('id', $id)
            ])
        );
        return $query->execute();
    }
    
    public function findByIDIgnoreHidden($id)
    {
        $query = $this->createQuery();
        $query->getQuerySettings()->setIgnoreEnableFields(TRUE);
        $query->getQuerySettings()->setLanguageOverlayMode(TRUE);
        $query->matching(
            $query->logicalOr([
                $query->equals("uid", $id),
                $query->equals('id', $id)
            ])
            );
        return $query->execute();
    }
    
    public function findCompaniesOfUser(string $uid, bool $ignoreHidden) {
        $query = $this->createQuery();
        $query->getQuerySettings()->setIgnoreEnableFields($ignoreHidden);
        $query->getQuerySettings()->setLanguageOverlayMode(TRUE);
        /*$query->matching(
            $query->equals("userid", $uid)
        );
        return $query->execute();*/
        $allComps= $query->execute()->toArray();
        $results = array();
        
        foreach ($allComps as $comp) {
            if ($comp->getUserid() === (int)$uid) {
                array_push($results, $comp);
                continue;
            }
            $editors = $comp->getEditors();
            $edsArray = explode(";", $editors);
            if (in_array($uid, $edsArray)) {
                array_push($results, $comp);
            }
        }
        return $results;
    }
    
/*    public function findByQuery($q){
        $name = $q["name"];
        
        $query = $this->createQuery();
        //$query->setOffset( $q["offset"] );
        //$query->setLimit( $q["count"] );
*/        
        /*$sort = $q["sort"];
         if ($sort && !empty($sort)) {
         $sconfig = explode(" ", $sort);
         if ($sconfig[1] == "asc") {
         $query->setOrderings(array($sconfig[0] => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING));
         } else {
         $query->setOrderings(array($sconfig[0] => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING));
         }
         } else {
         $query->setOrderings(array("name" => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING));
         }*/
        
        //$numFoundQuery = $this->createQuery();
/*        
        $query->matching($query->like('name', "%".$name."%"));
        //$numFoundQuery->matching($query->like('name', "%".$name."%"));
        
        $res = $query->execute();
        
        return array (
            "queryResult" => $res,
            "numfound" => $res->getQuery()->count()//$numFoundQuery->execute()->getQuery()->count()
        );
    }*/
    
    public function findByQuery($q, $superordinateLookup){
        $name = $q["name"];
        
        $results = array();
        $all = $this->findAll()->toArray();
        if (empty($name) || $name === "%") {
            foreach ($all as $c) {
                array_push($results, array(
                    "match" => 1,
                    "company" => $c
                ));
            }
        } else {

            foreach ($all as $company){
                $cname = $company->getName();
                
                if ($cname == $name) {
                    array_push($results, array(
                        "match" => 1,
                        "company" => $company
                    ));
                } else {
                    $match = $this->similarity($name, $cname);
                    
                    $isResearch = $company->getType() == 2;
                    if ($isResearch) {
                        $superNameDe = $superordinateLookup["de"][$company->getSuperordinate()];
                        $superNameEn = $superordinateLookup["en"][$company->getSuperordinate()];
                        
                        $matchSND = $this->similarity($name, $superNameDe);
                        $matchSNE = $this->similarity($name, $superNameEn);
                        
                        $match = max($match, $matchSND, $matchSNE);
                    }
                    
                    // if candidate score is above the threshold, add it to the result list
                    if ($match > 0.4) {
                        array_push($results, array(
                            "match" => $match,
                            "company" => $company
                        ));
                    }
                }
            }
        }
        
        return array (
            "queryResult" => $results,
            "numfound" => count($results)
        );
    }
    
    private function startsWith( $haystack, $needle ) {
        $length = strlen( $needle );
        return substr( $haystack, 0, $length ) === $needle;
    }
    
    private function similarity($needle, $haystack)
    {
        $_a = strtoupper($needle);
        $_b = strtoupper($haystack);
        if ($_a == $_b) {
            return 1;
        }
        if ($this->startsWith($_b, $_a)) { // starts with
            return 0.8;
        }
        if (stristr($_b,$_a)) { // contains
            return 0.6;
        }
        return 1 - (levenshtein($_a, $_b) / max(strlen($_a), strlen($_b)));
    }
    
    public function suggest($q, $l, $superordinateLookup) {
        $limit = 5;
        if (is_int($l)) {
            $limit = $l;
        }
        
/*        $query = $this->createQuery();
        $query->setLimit($limit);
        $query->matching($query->like('name', "%".$q."%"));
        $resObjs = $query->execute();
        
        $res = array();
        foreach ($resObjs->toArray() as $resObj) {
            $res[] = $resObj->getName();
        }
        
        return $res;*/

        $results = array();
        $all = $this->findAll()->toArray();
        foreach ($all as $company){
            $cname = $company->getName();
            
            $match = $this->similarity($q, $cname);
            if ($match > 0.4) {
                if (!in_array($cname, $results)) {
                    array_push($results, $cname);
                }
            }
            
            $isResearch = $company->getType() == 2;
            if ($isResearch) {
                $superName = $superordinateLookup[$company->getSuperordinate()];
                
                $matchSN = $this->similarity($q, $superName);
                if ($matchSN > 0.4) {
                    if (!in_array($superName, $results)) {
                        array_push($results, $superName);
                    }
                }
            }
            
            if ($match > 0.4) {
                if (!in_array($cname, $results)) {
                    array_push($results, $cname);
                }
            }
        }
        
        return array_slice($results, 0, $limit);
    }
    
    public function list($limit, $mode) {
        
        if (isset($mode)) {
            if ($mode == "random") {
                $companies = $this->findAll()->toArray();
                $noc = count($companies);
                
                $result = array();
                $taken = array();
                for ($i = 0; $i < min($limit, $noc); ++$i) {
                    $rand = -1;
                    do {
                        $rand = rand(0, $noc-1);
                    } while(in_array($rand, $taken));
                    $taken[]= $rand;
                    
                    $result[] = $companies[$rand];
                }
                return $result;
            }
            if ($mode == "latest") {
                $query = $this->createQuery();
                if (isset($limit) && is_int($limit)) {
                    $query->setLimit($limit);
                }
                $query->setOrderings(array("since" => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING) );
                
                return $companies = $query->execute()->toArray();
            }
        } else {
            $query = $this->createQuery();
            if (isset($limit) && is_int($limit)) {
                $query->setLimit($limit);
            }
            return $query->execute()->toArray();
        }
    }
}

?>