<?php

namespace Slub\MahuPartners\Controller;


use Slub\MahuPartners\Domain\Repository\CompanyRepository;
use Slub\MahuPartners\Domain\Repository\DivisionRepository;
use Slub\MahuPartners\Domain\Repository\RegulationRepository;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use TYPO3\CMS\Core\Mail\MailMessage;

/**
 * Description
 */
class PartnerController extends AbstractController {

	/**
	 * Array to collect the configuration information that will be added as a template variable.
	 * @var array
	 */
	protected $configuration = array();

	private $companyRepo;
	private $divisionsRepo;
	private $regulationRepo;
	private $persistenceManager = null;
	
	/**
	 * Inject the company repository
	 *
	 * @param \Slub\MahuPartners\Domain\Repository\CompanyRepository $companyRepository
	 */
	public function injectCompanyRepository(CompanyRepository $companyRepository)
	{
	    $this->companyRepo = $companyRepository;
	}
	
	/**
	 * Inject the division repository
	 *
	 * @param \Slub\MahuPartners\Domain\Repository\DivisionRepository $divisionsRepository
	 */
	public function injectDivisionRepository(DivisionRepository $divisionsRepository)
	{
	    $this->divisionsRepo = $divisionsRepository;
	}
	
	/**
	 * Inject the persistance manager
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager $persistanceManager
	 */
	public function injectPersistenceManager(PersistenceManager $persistanceManager)
	{
	    $this->persistenceManager = $persistanceManager;
	}
	
	/**
	 * Inject the regulation repository
	 *
	 * @param \Slub\MahuPartners\Domain\Repository\RegulationRepository $regulationRepository
	 */
	public function injectRegulationRepository(RegulationRepository $regulationRepository)
	{
	    $this->regulationRepo = $regulationRepository;
	}
	
	/**
	 * Index Action.
	 */
	public function indexAction() {
	    $q = $this->requestArguments["q"];
	    
	    $assignments = NULL;
	    
	    $search = (empty($q) || empty($q["name"])?false:true);

	    $start = microtime(true);
	    $query = $this->createQuery($this->requestArguments);
	    $results = $this->queryResults($query, !$search?true:false);
	    
	    $timeTracker= \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\TimeTracker\TimeTracker::class);
	    
	    $assignments = array(
	        "results" => $results,
	        "queryParameter" => $q["name"],
	        "search" => $search,
	        "timing" => array(
	           "query" => (microtime(true) - $start)." µs",
	           "request" => ($timeTracker->getDifferenceToStarttime())." ms"
	        )
	    );
	    
	    $this->configuration['counterStart'] = $this->getOffset() + 1;
	    $this->configuration['counterEnd'] = $this->getOffset() + $this->getCount();
	    
	    $this->addResultCountOptionsToTemplate($this->requestArguments);
	    
	    $this->view->assignMultiple($assignments);
	    $this->addStandardAssignments();
	    
	    $this->addQueryInformationAsJavaScript($q);
	}
	
	/**
	 * Stores information about the active query in the »underlyingQuery« JavaScript variable.
	 *
	 * @param array $query
	 * @param int|NULL $position of the record in the result list
	 * @param array $arguments overrides $this->requestArguments if set
	 */
	private function addQueryInformationAsJavaScript ($query, $position = NULL, $arguments = NULL) {
	    if ($arguments === NULL) {
	        $arguments = $this->requestArguments;
	    }
	    
	    if ($this->settings['paging']['detailPagePaging']) {
	        $scriptTag = new \TYPO3Fluid\Fluid\Core\ViewHelper\TagBuilder('script');
	        $scriptTag->addAttribute('type', 'text/javascript');
	        
	        $underlyingQuery = array('q' => $query);
	        if ($position !== NULL) {
	            $underlyingQuery['position'] = $position;
	        }
	        if ($arguments['count']) {
	            $underlyingQuery['count'] = $arguments['count'];
	        }
	        if ($arguments['sort']) {
	            $underlyingQuery['sort'] = $arguments['sort'];
	        }
	        $scriptTag->setContent('const mahupartners_query = ' . json_encode($underlyingQuery) . ';');
	        $this->response->addAdditionalHeaderData($scriptTag->render());
	    }
	}
	
	/**
	 * List the latest Company records.
	 */
	public function listLatestAction() {
	    $limit= $this->settings["companylist"]["number"] ?? 6;
	    $mode= $this->settings["companylist"]["mode"] ?? "latest";
	    
	    $companies = $this->companyRepo->list($limit, $mode);
	    
	    $assignments = array(
	        "results" => $companies,
	        "noresults" => count($companies) == 0
	    );
	    
	    $this->view->assignMultiple($assignments);
	    $this->addStandardAssignments();
	}
	
	/**
	 * List the Company records created by the currently logged in user.
	 */
	public function listAction() {
	    // get the Company records associated with the current user profile
	    $companies = $this->companyRepo->findCompaniesOfUser(
	        $GLOBALS['TSFE']->fe_user->user["uid"],
	        true);
	    
	    $assignments = array(
	        "results" => $companies,
	        "noresults" => count($companies) == 0
	    );
	    
	    $this->view->assignMultiple($assignments);
	    $this->addStandardAssignments();
	}
	
	/**
	 * Performs the actual search for Companies or Divisions.
	 * 
	 * @param array $query the query object
	 * @param boolean $onlyCompanies states whether only companies should be searched (or whether divisions as well) 
	 * @return array encapsulating object with the fields resultCount (int, the size of the result set), numfound (int, overall number of results for this query) and results (array, the results)
	 */
	private function queryResults($query, $onlyCompanies){
	    
	    $results = array();
	    
	    $compRes = $this->companyRepo->findByQuery($query, $this->settings["researchInstitutes"]);
	    
	    foreach ($compRes["queryResult"] as $comp) {
	        $results[]= array(
	            "type" => "company",
	            "entity" => $comp["company"],
	            "match" => $comp["match"]
	        );
	    }

	    if (!$onlyCompanies) {
    	    $divRes = $this->divisionsRepo->findByQuery($query);
    	    foreach ($divRes["queryResult"]->toArray() as $div) {
    	        $parent = $this->companyRepo->getCompanyByDivision($div->getId());
    	        
    	        $results[]= array(
    	            "type" => "division",
    	            "parent" => $parent,
    	            "entity" => $div
                );
            }
        }

        // sort (currently the only supported sort criterium is the name)
        $sort = $query["sort"];
        if ($sort && ! empty($sort)) {
            $sconfig = explode(" ", $sort);
            if ($sconfig[1] == "asc") {
                usort($results, function($a, $b){
                    return strcasecmp($a["entity"]->getName(), $b["entity"]->getName());
                });
            } else {
                usort($results, function($a, $b){
                    return strcasecmp($b["entity"]->getName(), $a["entity"]->getName());
                });
            }
        } else {
            usort($results, function($a, $b){
                return strcasecmp($a["entity"]->getName(), $b["entity"]->getName());
            });
	    }
	    
	    // apply offset and limit
	    $results = array_slice($results, $query["offset"], $query["count"]);
	    
	    return array(
	        "resultCount" => count($results),
	        "numfound" => $compRes["numfound"] + $divRes["numfound"],
	        "results" => $results
	    );
	}

	/**
	 * Single item view action.
	 */
	public function detailAction() {
	    $id = $this->requestArguments["id"];
	    
	    $arguments = $this->requestArguments;

	    if ($this->settings['paging']['detailPagePaging'] && array_key_exists('underlyingQuery', $arguments)) {
	        // If underlying query has been sent, fetch more data to enable paging arrows.
	        $underlyingQueryInfo = $arguments['underlyingQuery'];
	        
	        // These indexes are 0-based for Solr & PHP. The user visible numbering is 1-based.
	        $positionIndex = $underlyingQueryInfo['position'] - 1;
	        $previousIndex = max(array($positionIndex - 1, 0));
	        $nextIndex = $positionIndex + 1;
	        $resultIndexOffset = ($positionIndex === 0) ? 0 : 1;
	        
	        foreach ($arguments['underlyingQuery'] as $key => $value) {
	            $arguments[$key] = $value;
	        }
	        
	        $this->addQueryInformationAsJavaScript($underlyingQueryInfo['q'], (int)$underlyingQueryInfo['position'], $arguments);
	        
	        $query = $this->createQuery($arguments);
	        $query["offset"]= $previousIndex;
	        $query["count"]= ($nextIndex - $previousIndex + 1);
	        
	        $selectResults = $this->queryResults($query, false);
	        
            if ($selectResults["resultCount"] > 0) {
                $assignments['results'] = $selectResults["results"];
                $resultSet = $selectResults["results"];
                
                // the actual result is at position 0 (for the first document) or 1 (otherwise).
                $document = $resultSet[$resultIndexOffset];
                if ($document["entity"]->getId() === $id || $document["entity"]->getUid() == $id) {
                    $assignments['company'] = $document["entity"];
                    $assignments["isDivision"] = $document["type"] === "division";
                    $assignments["numfound"] = $selectResults["numfound"];
                    if ($resultIndexOffset !== 0) {
                        $assignments['document-previous'] = $resultSet[0]["entity"];
                        $assignments['document-previous-number'] = $previousIndex + 1;
                    }
                    $nextResultIndex = 1 + $resultIndexOffset;
                    if (count($resultSet) > $nextResultIndex) {
                        $assignments['document-next'] = $resultSet[$nextResultIndex]["entity"];
                        $assignments['document-next-number'] = $nextIndex + 1;
                    }
                }
            }
	    } else {
	        // detail page paging is disabled --> directly fetch the requested record and return it
	        $isDivision = false;
	        $res= $this->companyRepo->findByID($id);
	        if (empty($res->toArray())) {
	            $res = $this->divisionsRepo->findByID($id);
	            if (!empty($res->toArray())){
	                $isDivision = true;
	            }
	        }
	        
	        $assignments = array(
	            "company" => $res->getFirst(),
	            "isDivision" => $isDivision
	        );
	    }
	    
	    $this->view->assignMultiple($assignments);
	    $this->addStandardAssignments();
	}
	
	/**
	 * Single item view action.
	 */
	public function previewAction() {
	    $id = $this->requestArguments["id"];
	    
        // detail page paging is disabled --> directly fetch the requested record and return it
        $isDivision = false;
        $res= $this->companyRepo->findByIDIgnoreHidden($id);
        if (empty($res->toArray())) {
            $res = $this->divisionsRepo->findByID($id);
            if (!empty($res->toArray())){
                $isDivision = true;
            }
        }
        
        $assignments = array(
            "company" => $res->getFirst(),
            "isDivision" => $isDivision
        );
	    
	    $this->view->assignMultiple($assignments);
	    $this->addStandardAssignments();
	}
	
	private function checkAccess($userID, $record){
	    
	    if ($userID === $record->getUserid()) {
	        return true;
	    }
	    
	    $editorIDs = explode(";", $record->getEditors());
	    if (in_array($userID, $editorIDs)) {
	        return true;
	    }
	    
	    return false;
	}
	
	public function editAction() {
	    $company = $this->requestArguments["company"];
	    
	    if (empty($company)) {
	        // request for edit form
	        $id = $this->requestArguments["id"];
	        $isDivision= FALSE;
	        $success = TRUE;
	        $comp= null;
	        if (!empty($id)) {
	            // detail page paging is disabled --> directly fetch the requested record and return it
	            $isDivision = false;
	            $res= $this->companyRepo->findByIDIgnoreHidden($id);
	            if (empty($res->toArray())) {
	                $res = $this->divisionsRepo->findByID($id);
	                if (!empty($res->toArray())){
	                    $isDivision = true;
	                }
	            }
	            if (empty($res->toArray())) {
	               $success = FALSE;
	            } else {
	               $comp = $res->getFirst();
	               if (!$this->checkAccess($GLOBALS['TSFE']->fe_user->user["uid"], $comp)) {
	                   $success = FALSE;
	                   $comp= null;
	               }
	            }
	        } else {
	            $success = FALSE;
	        }
	        
	        $assignments = array(
	            "company" => $comp,
	            "isDivision" => $isDivision,
	            "showForm" => TRUE,
	            "success" => $success
	        );
	    } else {
            // edit form has been submitted
	        $id = $company["id"];
	        $comp = null;
	        $success = TRUE;
	        
            $isDivision = false;
            $res= $this->companyRepo->findByIDIgnoreHidden($id);
            if (empty($res->toArray())) {
                $res = $this->divisionsRepo->findByID($id);
                if (!empty($res->toArray())){
                    $isDivision = true;
                }
            }
            
            // create folder for that company
            $cfolder= $this->getCompanyFolder($id);
            
            // copy the logo file, if there is one, to the company folder
            $this->handleLogoFile($company, $cfolder);
            
            if (empty($res->toArray())) {
                $success = FALSE;
            } else {
                $comp = $res->getFirst();
            }
            
            if ($this->checkAccess($GLOBALS['TSFE']->fe_user->user["uid"], $comp)) {
                $this->editCompanyRecord($comp, $company);
                
                try {
                $this->sendMail("edit", $comp);
                } catch (\Exception $e) {}
            } else {
                $success= FALSE;
                $comp = null; 
            }
            
            $assignments = array(
                "company" => $comp,
                "isDivision" => $isDivision,
                "showForm" => FALSE,
                "success" => $success
            );
	    }
	    
	    $this->view->assignMultiple($assignments);
	    $this->addStandardAssignments();
	}
	
	public function newAction() {
	    $company = $this->requestArguments["company"];
	    $comp = null;
	    $showForm = FALSE;
	    $success = FALSE;
	    
	    $assignments = array();
	    
	    if (!empty($company)) {
	        // generate ID
	        if ($company["type"] == 2) { // research institute
	            $company["id"] = $this->generateID($company["superordinate"]."-".$company["name"]);
	        } else { // company
	            $company["id"] = $this->generateID($company["name"]);
	        }
	        
	        // make sure there is no Company with the same ID yet
	        $existing = $this->companyRepo->findByIDIgnoreHidden($company["id"])->getFirst();
	        if (!empty($existing)) {
	            $success = FALSE;
	            $assignments["existingCompany"] = $existing;
	        } else {

    	        // create folder for that company
	            $cfolder= $this->getCompanyFolder($company["id"]);
    	        
    	        // copy the logo file, if there is one, to the company folder
    	        $this->handleLogoFile($company, $cfolder);
    	        
    	        // create the new Company record....
    	        $comp = $this->createNewCompanyRecord($company);
    	        
    	        
    	        try {
    	           $this->sendMail("add", $comp);
    	        } catch (\Exception $e) {}
    	        
    	        // display state
    	        $success = TRUE;
	        }
	    } else {
	        // deliver form for new organization
	        $showForm = TRUE;
	    }
	    
	    $assignments["company"] = $comp;
	    $assignments["showForm"] = $showForm;
	    $assignments["success"] = $success;
	    
	    $this->view->assignMultiple($assignments);
	    $this->addStandardAssignments();
	}
	
	private function handleLogoFile(&$company, $folder) {
	    // check if there is an uploaded file with the ID 'logoFile' (as defined in the organization description form) 
	    if (!empty($_FILES['logofile'])) {
	        if ($_FILES['logofile']['error'] === 0) {
	            
	            $siteURL = "/";
	            if (!empty($this->settings["imageUpload"])) {
	                if (!empty($this->settings["imageUpload"]["siteURL"])) {
	                    $siteURL = $this->settings["imageUpload"]["siteURL"];
	                    
	                    if (substr( $siteURL, -1 ) !== "/") {
	                        $siteURL=$siteURL."/";
	                    }
	                }
	            }
	            
	            $storage = $folder->getStorage();
	            
	            $newFile = $storage->addFile(
	                $_FILES['logofile']['tmp_name'],
	                $folder,
	                $_FILES['logofile']['name']
	                );
	            
                // finally, set the Company's logo property to the file URL
	            $company["logo"] = $siteURL.$newFile->getPublicUrl();
	        } else {
	            // TODO dump error message in the frontend
	        }
	    }
	}
	
	private function sendMail($event, $company){
	    $username = $GLOBALS['TSFE']->fe_user->user["first_name"] . " " . $GLOBALS['TSFE']->fe_user->user["last_name"];
	    $companyname = $company->getName()." (id='".$company->getId()."')";
	    
	    // send an email notification if configured
	    $conf = $this->settings["notification"][$event];
	    if (!empty($conf) && $conf["enabled"] == 1) {
	        $om = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\Object\ObjectManager::class);
	        $email = $om->get(MailMessage::class);
	        
	        $subject = \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate("LLL:EXT:mahu_partners/Resources/Private/Language/locallang.xml:email.".$event.".header", $this->request->getControllerExtensionKey());
	        $body = sprintf(
	            \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate("LLL:EXT:mahu_partners/Resources/Private/Language/locallang.xml:email.".$event.".body", $this->request->getControllerExtensionKey()),
	            $username,
	            $companyname
	            );
	        
	        $email->setSender($conf["sender"],$conf["senderName"]);
	        $email->setFrom($conf["sender"],$conf["senderName"]);
	        $email->setTo($conf["to"],$conf["toName"]);
	        // set localized body and subject text
	        $email->setSubject($subject);
	        
	        if (is_a($email, 'Swift_Message')) {// typo3 9
	            $email->setBody($body);
	        }
	        if (is_a($email, 'Symfony\Component\Mime\Email')) { // typo3 v10
	            $email->text($body);
	        }

	        // send the mail
	        $email->send();
	    }
	}
	
	private function createNewCompanyRecord($companyData) {
	    // no record yet
	    $company = new \Slub\MahuPartners\Domain\Model\Company();
	    
	    $company->setId($companyData["id"]);
	    
        if (!empty($companyData["name"])) {
            $company->setName($companyData["name"]);
        }
        if (!empty($companyData["description"])) {
            $company->setDescription($companyData["description"]);
        }
        if (!empty($companyData["disclaimer"])) {
            $company->setDisclaimer($companyData["disclaimer"]);
        }
        if (!empty($companyData["www"])) {
            $company->setWww($companyData["www"]);
        }
        if (!empty($companyData["logo"])) {
            $company->setLogo($companyData["logo"]);
        }
        if (!empty($companyData["type"])) {
            $company->setType($companyData["type"]);
        }
        if (!empty($companyData["formOfCompany"])) {
            $company->setFormOfCompany($companyData["formOfCompany"]);
        }
        if (!empty($companyData["businessArea"])) {
            $company->setBusinessArea($companyData["businessArea"]);
        }
        if (!empty($companyData["numberOfEmployees"])) {
            $company->setNumberOfEmployees($companyData["numberOfEmployees"]);
        }
        if (!empty($companyData["street"])) {
            $company->setStreet($companyData["street"]);
        }
        if (!empty($companyData["zip"])) {
            $company->setZip($companyData["zip"]);
        }
        if (!empty($companyData["city"])) {
            $company->setCity($companyData["city"]);
        }
        if (!empty($companyData["country"])) {
            $company->setCountry($companyData["country"]);
        }
        if (!empty($companyData["services"])) {
            $company->setServices($companyData["services"]);
        }
        if (!empty($companyData["superordinate"])) {
            $company->setSuperordinate($companyData["superordinate"]);
        }
        
        
        // handle contacts and expertises
        if (!empty($companyData["contacts"])) {
            $contactRecords = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
            
            foreach ($companyData["contacts"] as $contact) {
                $cRec = new \Slub\MahuPartners\Domain\Model\Contact();
                
                if (!empty($contact["surname"])) {
                    $cRec->setSurname($contact["surname"]);
                }
                if (!empty($contact["familyname"])) {
                    $cRec->setFamilyname($contact["familyname"]);
                }
                if (!empty($contact["title"])) {
                    $cRec->setTitle($contact["title"]);
                }
                if (!empty($contact["position"])) {
                    $cRec->setPosition($contact["position"]);
                }
                if (!empty($contact["email"])) {
                    $cRec->setEmail($contact["email"]);
                }
                if (!empty($contact["phone"])) {
                    $cRec->setPhone($contact["phone"]);
                }
                if (!empty($contact["fax"])) {
                    $cRec->setFax($contact["fax"]);
                }
                if (!empty($contact["material_classes"])) {
                    $cRec->setMaterialClasses($contact["material_classes"]);
                }
                
                $contactRecords->attach($cRec);
            }
            
            $company->setContacts($contactRecords);
        }
        if (!empty($companyData["expertises"])) {
            $expertiseRecords = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
            
            foreach ($companyData["expertises"] as $expertise) {
                $eRec = new \Slub\MahuPartners\Domain\Model\Expertise();
                
                if (!empty($expertise["type"])) {
                    $eRec->setType($expertise["type"]);
                }
                if (!empty($expertise["name"])) {
                    $eRec->setName($expertise["name"]);
                }
                if (!empty($expertise["description"])) {
                    $eRec->setDescription($expertise["description"]);
                }
                if (!empty($expertise["purpose"])) {
                    $eRec->setPurpose($expertise["purpose"]);
                }
                if (!empty($expertise["quantities"])) {
                    $eRec->setQuantities($expertise["quantities"]);
                }
                if (!empty($expertise["customization"])) {
                    $eRec->setCustomization($expertise["customization"]==="1"?true:false);
                }
                if (!empty($expertise["material_classes"])) {
                    $eRec->setMaterialClasses($expertise["material_classes"]);
                }
                if (!empty($expertise["regulations"])) {
                    $regulationRecords = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
                    foreach($expertise["regulations"] as $regulationID) {
                        $regulationRecord = $this->regulationRepo->findByID($regulationID)->getFirst();

                        if (!empty($regulationRecord)) {
                           $regulationRecords->attach($regulationRecord);
                        }
                    }
                    $eRec->setRegulations($regulationRecords);
                }
                
                $expertiseRecords->attach($eRec);
            }
            
            $company->setExpertises($expertiseRecords);
        }
	    
	    
	    // set addition time
        $company->setSince(new \DateTime);
	    
        // set user ID to company record
        $uuid= $GLOBALS['TSFE']->fe_user->user["uid"];
        $company->setUserid($uuid);
        
        // add Company record
        $company->setHidden(true);
        $this->companyRepo->add($company);
        $this->persistenceManager->persistAll();
        
        return $company;
	}
	
	private function editCompanyRecord($company, $companyData) {
        // required fields must not be empty
        /*if (!empty($companyData["name"])) {
            $company->setName($companyData["name"]);
        }*/
        if (!empty($companyData["www"])) {
            $company->setWww($companyData["www"]);
        }
        
        $company->setDescription($companyData["description"]);
        $company->setDisclaimer($companyData["disclaimer"]);
        $company->setLogo($companyData["logo"]);
        $company->setFormOfCompany($companyData["formOfCompany"]);
        $company->setBusinessArea($companyData["businessArea"]);
        $company->setNumberOfEmployees($companyData["numberOfEmployees"]);
        $company->setStreet($companyData["street"]);
        $company->setZip($companyData["zip"]);
        $company->setCity($companyData["city"]);
        $company->setCountry($companyData["country"]);
        $company->setServices($companyData["services"]);
        
        // handle contacts
        if (!empty($companyData["contacts"])) {
            $newContacts = array();
            $editedContacts = array();
            
            $contactRecords = $company->getContacts();
            
            foreach ($companyData["contacts"] as $contact) {
                $id = $contact["id"];
                if (empty($id)) {
                    // create a new Contact record
	                $cRec = new \Slub\MahuPartners\Domain\Model\Contact();
	                
	                if (!empty($contact["surname"])) {
	                    $cRec->setSurname($contact["surname"]);
	                }
	                if (!empty($contact["familyname"])) {
	                    $cRec->setFamilyname($contact["familyname"]);
	                }
	                if (!empty($contact["title"])) {
	                    $cRec->setTitle($contact["title"]);
	                }
	                if (!empty($contact["position"])) {
	                    $cRec->setPosition($contact["position"]);
	                }
	                if (!empty($contact["email"])) {
	                    $cRec->setEmail($contact["email"]);
	                }
	                if (!empty($contact["phone"])) {
	                    $cRec->setPhone($contact["phone"]);
	                }
	                if (!empty($contact["fax"])) {
	                    $cRec->setFax($contact["fax"]);
	                }
	                if (!empty($contact["material_classes"])) {
	                    $cRec->setMaterialClasses($contact["material_classes"]);
	                }
	                
	                array_push($newContacts, $cRec);
                } else {
                    // edit a given record 
                    $existingContactRecord = null;
                    foreach ($contactRecords as $existing) {
                        if ($existing->getUid() === (int)$id) {
                            $existingContactRecord = $existing;
                            break;
                        }
                    }
                    if (empty($existingContactRecord)) {
                        // the submitted ID is unknown... (should not happen)
                        continue;
                    }
                    
                    // email is required
                    if (!empty($contact["email"])) {
                        $existingContactRecord->setEmail($contact["email"]);
                    }
                    $existingContactRecord->setSurname($contact["surname"]);
                    $existingContactRecord->setFamilyname($contact["familyname"]);
                    $existingContactRecord->setTitle($contact["title"]);
                    $existingContactRecord->setPosition($contact["position"]);
                    $existingContactRecord->setPhone($contact["phone"]);
                    $existingContactRecord->setFax($contact["fax"]);
                    $existingContactRecord->setMaterialClasses($contact["material_classes"]);
                    
                    array_push($editedContacts, $existingContactRecord);
                }
            }
            
            // remove those existing records that are neither new nor edited (i.e. deleted in the frontend form)
            foreach ($company->getContacts()->toArray() as $oldCont) {
                if (in_array($oldCont, $newContacts, true) || in_array($oldCont, $editedContacts, true)) {
                    continue;
                }
                
                $company->getContacts()->detach($oldCont);
            }
            // add new Contact records
            foreach ($newContacts as $newContact) {
                $contactRecords->attach($newContact);
            }
            
            $company->setContacts($contactRecords);
        } else {
            // no contacts received from the frontend --> remove all attached contact records if there are such
            foreach ($company->getContacts()->toArray() as $oldCont) {
                $company->getContacts()->detach($oldCont);
            }
        }
        
        // handle expertises
        if (!empty($companyData["expertises"])) {
            $newExpertises = array();
            $editedExpertises = array();
            
            $expertiseRecords = $company->getExpertises();
            
            foreach ($companyData["expertises"] as $expertise) {
                $id = $expertise["id"];
                if (empty($id)) {
                    // create a new Expertise record
                    $eRec = new \Slub\MahuPartners\Domain\Model\Expertise();

	                if (!empty($expertise["type"])) {
	                    $eRec->setType($expertise["type"]);
	                }
	                if (!empty($expertise["name"])) {
	                    $eRec->setName($expertise["name"]);
	                }
	                if (!empty($expertise["description"])) {
	                    $eRec->setDescription($expertise["description"]);
	                }
	                if (!empty($expertise["purpose"])) {
	                    $eRec->setPurpose($expertise["purpose"]);
	                }
	                if (!empty($expertise["quantities"])) {
	                    $eRec->setQuantities($expertise["quantities"]);
	                }
	                if (!empty($expertise["customization"])) {
	                    $eRec->setCustomization($expertise["customization"]==="1"?true:false);
	                }
	                if (!empty($expertise["material_classes"])) {
	                    $eRec->setMaterialClasses($expertise["material_classes"]);
	                }
	                if (!empty($expertise["regulations"])) {
	                    $regulationRecords = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
	                    foreach($expertise["regulations"] as $regulationID) {
	                        $regulationRecord = $this->regulationRepo->findByID($regulationID)->getFirst();
	                        
	                        if (!empty($regulationRecord)) {
	                            $regulationRecords->attach($regulationRecord);
	                        }
	                    }
	                    $eRec->setRegulations($regulationRecords);
	                }
	                
	                array_push($newExpertises, $eRec);
                } else {
                    // edit a given record
                    $existingExpertiseRecord = null;
                    foreach ($expertiseRecords as $existing) {
                        if ($existing->getUid() === (int)$id) {
                            $existingExpertiseRecord = $existing;
                            break;
                        }
                    }
                    if (empty($existingExpertiseRecord)) {
                        // the submitted ID is unknown... (should not happen)
                        continue;
                    }
                    
                    if (!empty($expertise["type"])) {
                        $existingExpertiseRecord->setType($expertise["type"]);
                    }
                    $existingExpertiseRecord->setName($expertise["name"]);
                    $existingExpertiseRecord->setDescription($expertise["description"]);
                    $existingExpertiseRecord->setPurpose($expertise["purpose"]);
                    $existingExpertiseRecord->setQuantities($expertise["quantities"]);
                    $existingExpertiseRecord->setCustomization($expertise["customization"]==="1"?true:false);
                    $existingExpertiseRecord->setMaterialClasses($expertise["material_classes"]);
                    if (!empty($expertise["regulations"])) {
                        $regulationRecords = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
                        foreach($expertise["regulations"] as $regulationID) {
                            $regulationRecord = $this->regulationRepo->findByID($regulationID)->getFirst();
                            
                            if (!empty($regulationRecord)) {
                                $regulationRecords->attach($regulationRecord);
                            }
                        }
                        $existingExpertiseRecord->setRegulations($regulationRecords);
                    }
                    
                    array_push($editedExpertises, $existingExpertiseRecord);
                }
            }
            
            // remove those existing records that are neither new nor edited (i.e. deleted in the frontend form)
            foreach ($company->getExpertises()->toArray() as $oldExp) {
                if (in_array($oldExp, $newExpertises, true) || in_array($oldExp, $editedExpertises, true)) {
                    continue;
                }
                
                $company->getExpertises()->detach($oldExp);
            }
            // add new Expertise records
            foreach ($newExpertises as $newExpertise) {
                $expertiseRecords->attach($newExpertise);
            }
            
            $company->setExpertises($expertiseRecords);
        } else {
            // no expertises received from the frontend --> remove all attached expertise records if there are such
            foreach ($company->getExpertises()->toArray() as $oldExp) {
                $company->getExpertises()->detach($oldExp);
            }
        }
	    
	    $this->companyRepo->update($company);
	    $this->persistenceManager->persistAll();
	}
	
	private function generateID($name){
        $id = str_replace(" ","-", $name); // replace whitespaces by hyphens
        $id = mb_strtolower($id);
        
        // replace umlauts, dicritics etc.
        //$id = str_replace(array("ä", "ö", "ü", "ß"), array("ae", "oe", "ue", "ss"), $id);
        $id = str_replace("ß","ss", $id);
        $id = str_replace(array("æ","œ","ç","ñ"),array("ae","oe","c", "n"),$id);
        $id = str_replace(array("ä", "à","á","â","ã","å"),"a",$id);
        $id = str_replace(array("ü","ù","ú","û"),"u",$id);
        $id = str_replace(array("ö","ò","ó","ô","õ"),"o",$id);
        $id = str_replace(array("ì","í","î","ï"),"i",$id);
        $id = str_replace(array("è","é","ê","ë"),"e",$id);
        $id = str_replace(array("ý","ÿ"),"y",$id);
        
        // remove certain words
        $id = preg_replace("/-gmbh-?/","-",$id);
        $id = preg_replace("/-co-?/","-",$id);
        $id = preg_replace("/-kg-?/","-",$id);
        $id = preg_replace("/-inc-?/","-",$id);
        $id = preg_replace("/-ag-?/","-",$id);
        
        // removes special chars
        $id = preg_replace('/[^A-Za-z0-9\-]/', '', $id);
        
        // replaces multiple hyphens with a single one
        $id = preg_replace('/-+/', '-', $id);
        // remove trailing hyphens
        $id = preg_replace("/-$/","", $id);
	        
        return $id;
	}
	
	/**
	 * Suggests search queries based on Company records.
	 */
	public function suggestAction() {
	    $q = $this->requestArguments["q"];
	    
	    $lang = $GLOBALS['TYPO3_REQUEST']->getAttribute('language')->getTwoLetterIsoCode();
	    
	    $sugs = $this->companyRepo->suggest($q,5, $this->settings["researchInstitutes"][$lang]);
	    $d = 5 - count($sugs);
	    if ($d > 0) {
	        $sugs = array_merge($sugs, $this->divisionsRepo->suggest($q, $d) );
	    }
	    
	    $assignments = array(
	        "suggestions" => $sugs
	    );
	    
	    $this->view->assignMultiple($assignments);
	}
}