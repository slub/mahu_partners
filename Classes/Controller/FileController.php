<?php

namespace Slub\MahuPartners\Controller;

use Slub\MahuPartners\Domain\Repository\CompanyRepository;
use TYPO3\CMS\Core\Mail\MailMessage;

/**
 * Description
 */
class FileController extends AbstractController {

	/**
	 * Initialisation and setup.
	 */
	public function initializeAction() {
		$this->requestArguments = $this->request->getArguments();
	}
	
	private $companyRepo;
	
	/**
	 * Inject the company repository
	 *
	 * @param \Slub\MahuPartners\Domain\Repository\CompanyRepository $companyRepository
	 */
	public function injectCompanyRepository(\Slub\MahuPartners\Domain\Repository\CompanyRepository $companyRepository)
	{
	    $this->companyRepo = $companyRepository;
	}
	
	/**
	 * List the files of the logged in user. 
	 */
	public function indexAction() {
	    $companyID= $this->requestArguments["company"];
	    if (!$companyID) {
	        return;
	    }
	    
	    $userid = $GLOBALS['TSFE']->fe_user->user['uid'];
	    if (empty($userid)) {
	        $this->view->assign("nologin", true);
	        // add some standard variables to the viewer
	        $this->addStandardAssignments();
	        return;
	    }
	    
	    if (!$this->hasPermission($userid, $companyID)){
	        return;
	    }
	    
	    $folder= $this->getCompanyFolder($companyID);
	    
        // try to gather the files from $path/{username}
        $files = null;
        try {
            $files = $folder->getStorage()->getFilesInFolder($folder);
        } catch (\TYPO3\CMS\Core\Resource\Exception\FolderDoesNotExistException $e) {}
	    
        $company= $this->companyRepo->findByIDIgnoreHidden($companyID)->getFirst();
        
	    $this->view->assign("files", $files);
	    $this->view->assign("company", $company);
	    
	    // add some standard variables to the viewer
	    $this->addStandardAssignments();
	}
	
	/**
	 * Remove the given file of the logged in user.
	 */
	public function removeAction() {
	    $username = $GLOBALS['TSFE']->fe_user->user['username'];
	    if (empty($username)) {
	        return;
	    }
	    $companyID= $this->requestArguments["company"];
	    if (empty($companyID)) {
	        return;
	    }
	    $fileID = $this->requestArguments["file"];
	    if (empty($fileID)) {
	        return;
	    }
	    
	    if (!$this->hasPermission($GLOBALS['TSFE']->fe_user->user['uid'], $companyID)){
	        return;
	    }
	    
	    $folder= $this->getCompanyFolder($companyID);
	    
	    // try to gather the files from the company folder
	    try {
	        $file = $folder->getStorage()->getFileInFolder($fileID, $folder);
	        if ($file != null) {
	           $file->getStorage()->deleteFile($file);
	           
	           // send an email notification if configured
	           $conf = $this->settings["notification"]["fileremove"];
	           if (!empty($conf) && $conf["enabled"] == 1) {
    	           $om = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\Object\ObjectManager::class);
    	           $email = $om->get(MailMessage::class);
    	           
    	           $email->setSender($conf["sender"],$conf["senderName"]);
    	           $email->setFrom($conf["sender"],$conf["senderName"]);
    	           $email->setTo($conf["to"],$conf["toName"]);
    	           // set localized body and subject text
    	           $email->setSubject(
    	               \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate("LLL:EXT:mahupartners/Resources/Private/Language/locallang.xml:email.fileremove.header", $this->request->getControllerExtensionKey())
    	               );
    	           
    	           $body = sprintf(
    	                   \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate("LLL:EXT:mahupartners/Resources/Private/Language/locallang.xml:email.fileremove.body", $this->request->getControllerExtensionKey()),
    	                   $username,
    	                   $fileID
    	               );
    	           
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
	    } catch (\Exception $e) {}
	    
	    $this->forward("index");
	}
	
	/**
	 * Remove the given file of the logged in user.
	 */
	public function addAction() {
	    
	    $companyID= $this->requestArguments["company"];
	    if (empty($companyID)) {
	        return;
	    }
	    
	    $username = $GLOBALS['TSFE']->fe_user->user['username'];
	    if (empty($username)) {
	        return;
	    }
	    
	    if (!$this->hasPermission($GLOBALS['TSFE']->fe_user->user['uid'], $companyID)){
	        return;
	    }
	    
	    if (!empty($_FILES['newfile'])) {
	        if ($_FILES['newfile']['error'] === 0) {
	            
	            $folder = $this->getCompanyFolder($companyID);
	            
	            $storage = $folder->getStorage();
	            
	            $storage->addFile(
	                $_FILES['newfile']['tmp_name'],
	                $folder,
	                $_FILES['newfile']['name'],
	                );

	            // send an email notification if configured
	            $conf = $this->settings["notification"]["fileadd"];
	            if (!empty($conf) && $conf["enabled"] == 1) {
	                try {
	                    $om = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\Object\ObjectManager::class);
	                    $email = $om->get(MailMessage::class);
	                    
	                    $email->setSender($conf["sender"],$conf["senderName"]);
	                    $email->setFrom($conf["sender"],$conf["senderName"]);
	                    $email->setTo($conf["to"],$conf["toName"]);
	                    
	                    // set localized body and subject text
	                    $email->setSubject(
	                        \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate("LLL:EXT:userfiles/Resources/Private/Language/locallang.xml:email.fileadd.header", $this->request->getControllerExtensionKey())
	                        );
	                    
	                    $body = sprintf(
	                        \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate("LLL:EXT:userfiles/Resources/Private/Language/locallang.xml:email.fileadd.body", $this->request->getControllerExtensionKey()),
	                        $username,
	                        $_FILES['newfile']['name']
	                        );
	                    
	                    $email->text($body);
	                    
	                    // send the mail
	                    $email->send();
	                } catch (\Exception $e) {}
	            }
	            
	        } else {
	            // TODO dump error message in the frontend
	        }
	    }
	    $this->forward("index");
	}
	
	private function hasPermission($userID, $companyID){
	    $company= $this->companyRepo->findByIDIgnoreHidden($companyID)->getFirst();
	    
	    if ($userID === $company->getUserid()) {
	        return true;
	    }
	    
	    $editorIDs = explode(";", $company->getEditors());
	    if (in_array($userID, $editorIDs)) {
	        return true;
	    }
	    
	    return false;
	}
	
	private function endsWith( $haystack, $needle ) {
	    $length = strlen( $needle );
	    if( !$length ) {
	        return true;
	    }
	    return substr( $haystack, -$length ) === $needle;
	}
	 
	/**
	 * Assigns standard variables to the view.
	 */
	protected function addStandardAssignments () {
		$this->view->assign('arguments', $this->requestArguments);

		$contentObject = $this->configurationManager->getContentObject();
		$uid = $contentObject->data['uid'];
		$this->configuration['uid'] = $uid;

		$this->configuration['prefixID'] = 'tx_mahuconverter_mahuconverter';

		$this->configuration['pageTitle'] = $GLOBALS['TSFE']->page['title'];
		
		$this->configuration['language'] = $GLOBALS['TSFE']->config['config']['language'];

		$this->view->assign('config', $this->configuration);
	}

}
