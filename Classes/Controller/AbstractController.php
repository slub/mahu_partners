<?php

namespace Slub\MahuPartners\Controller;

/**
 * Description
 */
abstract class AbstractController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

	/**
	 * @var array
	 */
	protected $requestArguments;

	/**
	 * Array to collect the configuration information that will be added as a template variable.
	 * @var array
	 */
	protected $configuration = array();
	
	/**
	 * Initialisation and setup.
	 */
	public function initializeAction() {
		$this->requestArguments = $this->request->getArguments();
	}

	protected function getCompanyFolder($companyID){
	    
	    // load path settings
	    $path = "/user_upload/";
	    $storageID = "1";
	    if (!empty($this->settings["imageUpload"])) {
	        if (!empty($this->settings["imageUpload"]["path"])) {
	            $path = $this->settings["imageUpload"]["path"];
	            if (substr( $path, -1 ) !== "/") {
	                $path = $path."/";
	            }
	        }
	        if (!empty($this->settings["imageUpload"]["storage"])) {
	            $storageID = $this->settings["imageUpload"]["storage"];
	        }
	    }
	    
	    // store the uploaded file using the TYPO3 storage API
	    $resourceFactory = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Resource\ResourceFactory::class);
	    $storage = $resourceFactory->getStorageObject($storageID);
	    
	    if (!$storage->hasFolder($path . $companyID)) {
	        $storage->createFolder($path . $companyID);
	    }
	    return $storage->getFolder($path . $companyID);
	}
	
	/**
	 * Creates a query object for the given arguments 
	 * @param array $arguments
	 * @return array
	 */
	protected function createQuery($arguments){
	    $query = $arguments["q"];
	    if (!$query || empty($query) || $query["name"] == "*") {
	        $query= array("name"=>"%");
	    }
	    
	    $query["offset"] = $this->getOffset($arguments);
	    $query["count"] = $this->getCount($arguments);
	    $query["sort"] = $this->getSortOrder($arguments);
	    
	    $this->addResultCountOptionsToTemplate($arguments);
	    $this->addSortOrdersToTemplate($arguments);
	    
	    return $query;
	}
	
	/**
	 * Returns the index of the first row to return.
	 *
	 * @param array $arguments overrides $this->requestArguments if set
	 * @return int
	 */
	protected function getOffset ($arguments = NULL) {
	    if ($arguments === NULL) {
	        $arguments = $this->requestArguments;
	    }
	    
	    $offset = 0;
	    
	    if (array_key_exists('start', $arguments)) {
	        $offset =  intval($arguments['start']);
	    }
	    else if (array_key_exists('page', $arguments)) {
	        $offset = (intval($arguments['page']) - 1)  * $this->getCount();
	    }
	    
	    $this->configuration['offset'] = $offset;
	    return $offset;
	}
	
	
	/**
	 * Returns the number of results per page using the first of:
	 * * query parameter »count«
	 * * TypoScript setting »paging.perPage«
	 * limited by the setting »paging.maximumPerPage«
	 *
	 * @param array $arguments overrides $this->requestArguments if set
	 * @return int
	 */
	protected function getCount ($arguments = NULL) {
	    if ($arguments === NULL) {
	        $arguments = $this->requestArguments;
	    }
	    
	    $count = intval($this->settings['paging']['perPage']);
	    
	    if (array_key_exists('count', $arguments)) {
	        $count = intval($this->requestArguments['count']);
	    }
	    
	    $maxCount = intval($this->settings['paging']['maximumPerPage']);
	    $count = min(array($count, $maxCount));
	    
	    $this->configuration['count'] = $count;
	    return $count;
	}
	
	/**
	 * Provides result count information in the configuration »resultCountOptions«.
	 *
	 * For the key »menu« it contains an array with keys and values the result count
	 * that is suitable for use in the f:form.select View Helper’s options argument.
	 * For the key »default« it contains the default number of results.
	 * For the key »selected« it contains the the selected number of results.
	 *
	 * @param array $arguments request arguments
	 */
	protected function addResultCountOptionsToTemplate ($arguments) {
	    $resultCountOptions = array('menu' => array());
	    
	    if (is_array($this->settings['paging']['menu'])) {
	        ksort($this->settings['paging']['menu']);
	        foreach ($this->settings['paging']['menu'] as $resultCount) {
	            $resultCountOptions['menu'][$resultCount] = $resultCount;
	        }
	        
	        $resultCountOptions['default'] = $this->settings['paging']['perPage'];
	        
	        if ($arguments['count'] && array_key_exists($arguments['count'], $resultCountOptions['menu'])) {
	            $resultCountOptions['selected'] = $arguments['count'];
	        }
	        else {
	            $resultCountOptions['selected'] = $resultCountOptions['default'];
	        }
	    }
	    
	    $this->configuration['resultCountOptions'] = $resultCountOptions;
	}
	
	/**
	 * Sets up $query’s sort order from URL arguments or the TypoScript default.
	 *
	 */
	protected function getSortOrder ($arguments) {
	    $sortString = '';
	    if (!empty($arguments['sort'])) {
	        $sortString = $arguments['sort'];
	    }
	    else if (!empty($this->settings['sort'])) {
	        foreach ($this->settings['sort'] as $sortSetting) {
	            if ($sortSetting['id'] === 'default') {
	                $sortString = $sortSetting['sortCriteria'];
	                break;
	            }
	        }
	    }
	    return $sortString;
	}
	
	/**
	 * Provides sorting information in the template variable »sortOptions«.
	 *
	 * For the key »menu« it contains an array with keys: sort criteria and
	 * values: localised labels that is suitable for use in the f:form.select
	 * View Helper’s options argument.
	 * For the key »default« it contains the default sort order string.
	 * For the key »selected« it contains the selected sort order string.
	 *
	 * @param array $arguments request arguments
	 */
	private function addSortOrdersToTemplate ($arguments) {
	    $sortOptions = array('menu' => array());
	    
	    if (is_array($this->settings['sort'])) {
	        ksort($this->settings['sort']);
	        foreach ($this->settings['sort'] as $sortOptionIndex => $sortOption) {
	            if (array_key_exists('id', $sortOption) && array_key_exists('sortCriteria', $sortOption)) {
	                $localisationKey = 'LLL:EXT:mahu_partners/Resources/Private/Language/locallang.xml:input.sort-' . $sortOption['id'];
	                $localisedLabel = \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate($localisationKey, $this->request->getControllerExtensionKey());
	                if (!$localisedLabel) {
	                    $localisedLabel = $sortOption['id'];
	                }
	                $sortOptions['menu'][$sortOption['sortCriteria']] = $localisedLabel;
	                
	                if ($sortOption['id'] === 'default') {
	                    $sortOptions['default'] = $sortOption['sortCriteria'];
	                }
	            }
	            else {
	                $message = 'find: TypoScript sort option »' . $sortOptionIndex . '« does not have the required keys »id« and »sortCriteria. Ignoring this setting.';
	                $this->logError($message, \TYPO3\CMS\Core\Messaging\FlashMessage::WARNING, array('sortOption' => $sortOption));
	            }
	        }
	        
	        if ($arguments['sort'] && array_key_exists($arguments['sort'], $sortOptions['menu'])) {
	            $sortOptions['selected'] = $arguments['sort'];
	        }
	        else {
	            $sortOptions['selected'] = $sortOptions['default'];
	        }
	    }
	    
	    $this->configuration['sortOptions'] = $sortOptions;
	}
	
	/**
	 * Assigns standard variables to the view.
	 */
	protected function addStandardAssignments () {
		$this->view->assign('arguments', $this->requestArguments);

		$contentObject = $this->configurationManager->getContentObject();
		$uid = $contentObject->data['uid'];
		$this->configuration['uid'] = $uid;

		$this->configuration['prefixID'] = 'tx_mahupartners_mahupartners';

		$this->configuration['pageTitle'] = $GLOBALS['TSFE']->page['title'];
		
		$this->configuration['language'] = $GLOBALS['TSFE']->config['config']['language'];

		$this->view->assign('config', $this->configuration);
	}

}