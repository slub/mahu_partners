<?php

namespace Slub\MahuPartners\Controller;


use Slub\MahuPartners\Domain\Repository\RegulationRepository;

/**
 * Description
 */
class RegulationController extends AbstractController {

	/**
	 * Array to collect the configuration information that will be added as a template variable.
	 * @var array
	 */
	protected $configuration = array();

	private $regulationRepository;
	
	/**
	 * Inject the company repository
	 *
	 * @param \Slub\MahuPartners\Domain\Repository\RegulationRepository $regulationRepository
	 */
	public function injectRegulationRepository(RegulationRepository $regulationRepository)
	{
	    $this->regulationRepository = $regulationRepository;
	}
	
	/**
	 * Index Action.
	 */
	public function indexAction() {
	    $q = $this->requestArguments["q"];
	    
	    $assignments = NULL;
	    
	    $start = microtime(true);
	    $query = $this->createQuery($this->requestArguments);
	    $results = $this->queryResults($query);
	    
	    $timeTracker= \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\TimeTracker\TimeTracker::class);
	    
	    $assignments = array(
	        "results" => $results,
	        "queryParameter" => $q["name"],
	        "search" => (empty($q) || empty($q["name"])?false:true),
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
	 * Performs the actual search for Regulations.
	 *
	 * @param array $query the query object
	 * @return array encapsulating object with the fields resultCount (int, the size of the result set), numfound (int, overall number of results for this query) and results (array, the results)
	 */
	private function queryResults($query){
	    $regRes= $this->regulationRepository->findByQuery($query);
	    $arr = $regRes["queryResult"]->toArray();
	    
	    return array(
	        "numfound" => $regRes["numfound"],
	        "regulations" => $arr,
	        "resultCount" => count($arr)
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
	            $assignments['results'] = $selectResults["regulations"];
	            $resultSet = $selectResults["regulations"];
	            
	            // the actual result is at position 0 (for the first document) or 1 (otherwise).
	            $document = $resultSet[$resultIndexOffset];
	            if ($document->getUid() === (int)$id) {
	                $assignments['regulation'] = $document;
	                $assignments["numfound"] = $selectResults["numfound"];
	                if ($resultIndexOffset !== 0) {
	                    $assignments['document-previous'] = $resultSet[0];
	                    $assignments['document-previous-number'] = $previousIndex + 1;
	                }
	                $nextResultIndex = 1 + $resultIndexOffset;
	                if (count($resultSet) > $nextResultIndex) {
	                    $assignments['document-next'] = $resultSet[$nextResultIndex];
	                    $assignments['document-next-number'] = $nextIndex + 1;
	                }
	            }
	        }
	    } else {
	        // detail page paging is disabled --> directly fetch the requested record and return it
	        $res= $this->regulationRepository->findByID($id);
	        
	        $assignments = array(
	            "regulation" => $res->getFirst(),
	        );
	    }
	    

	    $this->view->assignMultiple($assignments);
	    $this->addStandardAssignments();
	}
	
	/**
	 * Suggests search queries based on Regulation records.
	 */
	public function suggestAction() {
	    $q = $this->requestArguments["q"];
	    
	    $sugs = $this->regulationRepository->suggest($q,5);
	    
	    $assignments = array(
	        "suggestions" => $sugs
	    );
	    
	    $this->view->assignMultiple($assignments);
	}
}