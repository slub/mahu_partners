<?php
defined('TYPO3_MODE') or die();

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'mahu_partners',
    'MahuPartners',
    'Material Hub Frontend partners extension'
    );

# add plugin configuration flex form (allows to switch the controler action)
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['mahupartners_mahupartners'] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    'mahupartners_mahupartners',
    'FILE:EXT:mahu_partners/Configuration/FlexForms/mahupartnersFlexform.xml');