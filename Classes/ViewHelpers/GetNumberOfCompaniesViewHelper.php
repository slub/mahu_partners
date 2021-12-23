<?php
/*******************************************************************************
 *
 * Copyright 2017-2018 SLUB Dresden
 *
 ******************************************************************************/

namespace Slub\MahuPartners\ViewHelpers;

use Slub\MahuPartners\Domain\Repository\CompanyRepository;


/**
 * Answers a tuple of stringified values and corresponding units for a given material-property-constellation.
 * Thereby, it transparently handles the different types of properties and styles of value definition.
 * 
 * @author Carsten Radeck
 *
 */
class GetNumberOfCompaniesViewHelper extends \TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper {

    private $repo;
    
	/**
	 * Register arguments.
	 * @return void
	 */
	public function initializeArguments() {
	    parent::initializeArguments();
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
	    $resp = $this->repo->findAll();
	    
	    return $resp->getQuery()->count();
	}
}

?>