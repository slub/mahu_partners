<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

call_user_func(
    function($extKey)
    {

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_mahupartners_domain_model_company', 'EXT:mahu_partners/Resources/Private/Language/locallang_csh_tx_mahupartners_domain_model_company.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_mahupartners_domain_model_company');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_mahupartners_domain_model_division', 'EXT:mahu_partners/Resources/Private/Language/locallang_csh_tx_mahupartners_domain_model_division.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_mahupartners_domain_model_division');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_mahupartners_domain_model_contact', 'EXT:mahu_partners/Resources/Private/Language/locallang_csh_tx_mahupartners_domain_model_contact.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_mahupartners_domain_model_contact');

		\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_mahupartners_domain_model_socialnetworkaccount', 'EXT:mahu_partners/Resources/Private/Language/locallang_csh_tx_mahupartners_domain_model_socialnetworkaccount.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_mahupartners_domain_model_socialnetworkaccount');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_mahupartners_domain_model_regulation', 'EXT:mahu_partners/Resources/Private/Language/locallang_csh_tx_mahupartners_domain_model_regulation.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_mahupartners_domain_model_regulation');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_mahupartners_domain_model_expertise', 'EXT:mahu_partners/Resources/Private/Language/locallang_csh_tx_mahupartners_domain_model_expertise.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_mahupartners_domain_model_expertise');
    },
    $_EXTKEY
);