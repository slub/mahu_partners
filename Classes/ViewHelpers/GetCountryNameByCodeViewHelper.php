<?php
/*******************************************************************************
 *
 * Copyright 2020 SLUB Dresden
 *
 ******************************************************************************/

namespace Slub\MahuPartners\ViewHelpers;
use Symfony\Component\Intl\Countries;
/**
 * @author Carsten Radeck
 *
 */
class GetCountryNameByCodeViewHelper extends \TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper {
    
	/**
	 * Register arguments.
	 * @return void
	 */
	public function initializeArguments() {
	    parent::initializeArguments();
	    $this->registerArgument('countryCode', 'string', 'the two letter country code for that a country name is requested', TRUE);
	    $this->registerArgument('languageCode', 'string', 'two letter language code', FALSE, 'de');
	}
	
	/**
	 * @return array
	 */
	public function render() {
	    $this->arguments['countryCode'];
	    
	    $countries = Countries::getNames($this->arguments['languageCode']);
	    if (array_key_exists($this->arguments['countryCode'], $countries)){
	        return $countries[$this->arguments['countryCode']];
	    }
	    
	    return $this->arguments['countryCode'];
	}
}
