<?php
defined('TYPO3_MODE') or die();


\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'mahu_partners', // The extension name (in UpperCamelCase) with vendor prefix
    'MahuPartners', // A unique name of the plugin in UpperCamelCase
    array ( // An array holding the enabled controller-action-combinations
        \Slub\MahuPartners\Controller\PartnerController::class => 'index, detail, list, listLatest, suggest, edit, new, preview', // The first controller and its first action will be the default
        \Slub\MahuPartners\Controller\RegulationController::class => 'index, detail, list, suggest', // The first controller and its first action will be the default
        \Slub\MahuPartners\Controller\FileController::class  => 'index,remove,add', // The first controller and its first action will be the default
    ),
    array ( // An array holding the non-cachable controller-action-combinations
        \Slub\MahuPartners\Controller\PartnerController::class => 'index, detail, list, listLatest, edit, new, preview', // The first controller and its first action will be the default
        \Slub\MahuPartners\Controller\RegulationController::class => 'index, detail, list', // The first controller and its first action will be the default
        \Slub\MahuPartners\Controller\FileController::class  => 'index,remove,add', // The first controller and its first action will be the default
    )
);
