<?php
/*******************************************************************************
 *
 * Copyright 2017 SLUB Dresden
 *
 ******************************************************************************/

namespace Slub\MahuPartners\ViewHelpers;

use Slub\MahuPartners\Domain\Repository\CompanyRepository;


/**
 * 
 * @author radeck
 *
 */
class GetURLofFileInUserFolderViewHelper extends \TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper {

    private $repo;
    
	/**
	 * Register arguments.
	 * @return void
	 */
	public function initializeArguments() {
		parent::initializeArguments();
		$this->registerArgument('fileOrURL', 'string', 'filename or URL', TRUE, "");
		$this->registerArgument('companyID', 'string', 'ID of the data deliverer of the material', TRUE, "");
	}
	
	/**
	 * Inject the company repository
	 *
	 * @param \Slub\MahuPartners\Domain\Repository\CompanyRepository $companyRepository
	 */
	public function injectCompanyRepository(CompanyRepository $companyRepository)
	{
	    $this->repo = $companyRepository;
	}
	
    /**
	 * @return array
	 */
	public function render() {
	    $certURL = $this->arguments['fileOrURL'];
	    
	    // if it is already a URL, there is nothing to do
	    $sp = strpos($certURL, "://");
	    if ($sp !== false) {
	        return $certURL;
	    }
	    
	    // otherwise, try to fetch the Company record by the given ID
	    $ddID = $this->arguments['companyID'];
	    $response = $this->repo->findByIDIgnoreHidden($ddID);
	    
	    $company = $response->getFirst();
	    
	    // check if the Company is existing
	    if (empty($company)) {
	        return $certURL;
	    }
	    
	    // initialize user storage settings
	    $path = "/user_upload/";
	    $storageID = "1";
	    $siteURL = "/";
	    if (!empty($this->settings["imageUpload"])) {
	        if (!empty($this->settings["imageUpload"]["path"])) {
	            $path = $this->settings["imageUpload"]["path"];
	        }
	        if (!empty($this->settings["imageUpload"]["storage"])) {
	            $storageID = $this->settings["imageUpload"]["storage"];
	        }
	        if (!empty($this->settings["imageUpload"]["siteURL"])) {
	            $siteURL = $this->settings["imageUpload"]["siteURL"];
	        }
	    }
	    if (substr( $path, -1 ) !== "/") {
	        $path = $path."/";
	    }
	    
	    // lookup the referenced file using TYPO3's storage API
	    $resourceFactory = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Resource\ResourceFactory::class);
	    $storage = $resourceFactory->getStorageObject($storageID);
	    $fileIdentifier = $path . $company->getId() ."/". $certURL;
	    if (!$storage->hasFile($fileIdentifier)) {
	        return $certURL;
	    }
	    
	    // if the file exists, construct a URL and return it.
	    $file = $storage->getFile($fileIdentifier);

	    if (substr( $siteURL, -1 ) !== "/") {
	        $siteURL = $siteURL."/";
	    }

	    return $siteURL . $file->getPublicUrl();
	}
}

?>