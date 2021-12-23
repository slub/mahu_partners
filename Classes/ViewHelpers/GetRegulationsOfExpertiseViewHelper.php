<?php
/*******************************************************************************
 *
 * Copyright 2020 SLUB Dresden
 *
 ******************************************************************************/

namespace Slub\MahuPartners\ViewHelpers;



/**
 * Answers a tuple of stringified values and corresponding units for a given material-property-constellation.
 * Thereby, it transparently handles the different types of properties and styles of value definition.
 * 
 * @author Carsten Radeck
 *
 */
class GetRegulationsOfExpertiseViewHelper extends \TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper {

    private $repo;
    
	/**
	 * Register arguments.
	 * @return void
	 */
	public function initializeArguments() {
	    parent::initializeArguments();
	    $this->registerArgument('expertise', 'object', 'an expertise object', TRUE);
	}
	
	/**
	 * @return array
	 */
	public function render() {
	    $result = array();
	    $exp = $this->arguments['expertise'];
	    if (empty($exp)) {
	        return $result;
	    }
	    
	    $regs = $exp->getRegulations();
	    
	    foreach ($regs as $reg) {
	        $result[] = $reg->getId();
	    }
	    
	    return $result;
	}
}

?>