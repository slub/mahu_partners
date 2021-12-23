<?php
/*******************************************************************************
 *
 * Copyright 2020 SLUB Dresden
 *
 ******************************************************************************/

namespace Slub\MahuPartners\ViewHelpers;

use Slub\MahuPartners\Domain\Repository\RegulationRepository;


/**
 * Answers a tuple of stringified values and corresponding units for a given material-property-constellation.
 * Thereby, it transparently handles the different types of properties and styles of value definition.
 * 
 * @author Carsten Radeck
 *
 */
class GetAllRegulationsViewHelper extends \TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper {

    private $repo;
    
	/**
	 * Register arguments.
	 * @return void
	 */
	public function initializeArguments() {
	    parent::initializeArguments();
	}
	
	/**
	 * Inject the regulation repository
	 *
	 * @param \Slub\MahuPartners\Domain\Repository\RegulationRepository $regulationRepository
	 */
	public function injectCompanyRepository(RegulationRepository $regulationRepository)
	{
	    $this->repo = $regulationRepository;
	}

	/**
	 * @return array
	 */
	public function render() {
	    $resp = $this->repo->findAll();
	    
	    return $resp;
	}
}

?>