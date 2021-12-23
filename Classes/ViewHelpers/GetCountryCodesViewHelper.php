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
class GetCountryCodesViewHelper extends \TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper {
    
	/**
	 * Register arguments.
	 * @return void
	 */
	public function initializeArguments() {
	    parent::initializeArguments();
	    $this->registerArgument('languageCode', 'string', 'two letter language code', FALSE, 'de');
	}
	
	/**
	 * @return array
	 */
	public function render() {
	    $codes = array_merge(array(""=>""), Countries::getNames($this->arguments['languageCode']));
	    return $codes;
	}
}

?>