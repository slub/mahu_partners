<?php
return [
    'ctrl' => [
        'title' => 'LLL:EXT:mahu_partners/Resources/Private/Language/locallang_db.xlf:tx_mahupartners_domain_model_division',
        'label' => 'name',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'versioningWS' => true,
        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ],
        'searchFields' => 'name,street,zip,city,country,www,logo,facet,facet_value,description,since,services,id,contacts,expertises',
        'iconfile' => 'EXT:mahu_partners/Resources/Public/Icons/tx_mahupartners_domain_model_division.gif'
    ],
    'interface' => [
        'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, name, id, type, street, zip, city, country, www, logo, facet, facet_value, description, disclaimer, since, services, contacts, expertises',
    ],
    'types' => [
        '1' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, name, id, type, street, zip, city, country, www, logo, facet, facet_value, description, disclaimer, since, services, contacts, expertises, --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access, starttime, endtime'],
    ],
    'columns' => [
        'sys_language_uid' => [
            'exclude' => true,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.language',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'special' => 'languages',
                'items' => [
                    [
                        'LLL:EXT:lang/locallang_general.xlf:LGL.allLanguages',
                        -1,
                        'flags-multiple'
                    ]
                ],
                'default' => 0,
            ],
        ],
        'l10n_parent' => [
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'exclude' => true,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.l18n_parent',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'default' => 0,
                'items' => [
                    ['', 0],
                ],
                'foreign_table' => 'tx_mahupartners_domain_model_division',
                'foreign_table_where' => 'AND tx_mahupartners_domain_model_division.pid=###CURRENT_PID### AND tx_mahupartners_domain_model_division.sys_language_uid IN (-1,0)',
            ],
        ],
        'l10n_diffsource' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        't3ver_label' => [
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.versionLabel',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'max' => 255,
            ],
        ],
        'hidden' => [
            'exclude' => true,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.hidden',
            'config' => [
                'type' => 'check',
                'items' => [
                    '1' => [
                        '0' => 'LLL:EXT:lang/Resources/Private/Language/locallang_core.xlf:labels.enabled'
                    ]
                ],
            ],
        ],
        'starttime' => [
            'exclude' => true,
            'behaviour' => [
                'allowLanguageSynchronization' => true
            ],
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.starttime',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'size' => 13,
                'eval' => 'datetime',
                'default' => 0,
            ],
        ],
        'endtime' => [
            'exclude' => true,
            'behaviour' => [
                'allowLanguageSynchronization' => true
            ],
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.endtime',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'size' => 13,
                'eval' => 'datetime',
                'default' => 0,
                'range' => [
                    'upper' => mktime(0, 0, 0, 1, 1, 2038)
                ],
            ],
        ],

        'name' => [
            'exclude' => true,
            'label' => 'LLL:EXT:mahu_partners/Resources/Private/Language/locallang_db.xlf:tx_mahupartners_domain_model_division.name',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'street' => [
            'exclude' => true,
            'label' => 'LLL:EXT:mahu_partners/Resources/Private/Language/locallang_db.xlf:tx_mahupartners_domain_model_division.street',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'zip' => [
            'exclude' => true,
            'label' => 'LLL:EXT:mahu_partners/Resources/Private/Language/locallang_db.xlf:tx_mahupartners_domain_model_division.zip',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'city' => [
            'exclude' => true,
            'label' => 'LLL:EXT:mahu_partners/Resources/Private/Language/locallang_db.xlf:tx_mahupartners_domain_model_division.city',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'country' => [
            'exclude' => true,
            'label' => 'LLL:EXT:mahu_partners/Resources/Private/Language/locallang_db.xlf:tx_mahupartners_domain_model_division.country',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'www' => [
            'exclude' => true,
            'label' => 'LLL:EXT:mahu_partners/Resources/Private/Language/locallang_db.xlf:tx_mahupartners_domain_model_division.www',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'logo' => [
            'exclude' => true,
            'label' => 'LLL:EXT:mahu_partners/Resources/Private/Language/locallang_db.xlf:tx_mahupartners_domain_model_division.logo',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'facet' => [
            'exclude' => true,
            'label' => 'LLL:EXT:mahu_partners/Resources/Private/Language/locallang_db.xlf:tx_mahupartners_domain_model_division.facet',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
			        ['Producer', 'producer'],
			        ['Supplier', 'supplier'],
			        ['Data deliverer', 'dataDeliverer'],
                ],
                'size' => 1,
                'maxitems' => 1,
                'eval' => ''
            ],
        ],
        'facet_value' => [
            'exclude' => true,
            'label' => 'LLL:EXT:mahu_partners/Resources/Private/Language/locallang_db.xlf:tx_mahupartners_domain_model_division.facet_value',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'description' => [
            'exclude' => true,
            'label' => 'LLL:EXT:mahu_partners/Resources/Private/Language/locallang_db.xlf:tx_mahupartners_domain_model_division.description',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim'
            ]
        ],
        'disclaimer' => [
            'exclude' => true,
            'label' => 'LLL:EXT:mahu_partners/Resources/Private/Language/locallang_db.xlf:tx_mahupartners_domain_model_division.disclaimer',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim'
            ]
        ],
        'since' => [
            'exclude' => true,
            'label' => 'LLL:EXT:mahu_partners/Resources/Private/Language/locallang_db.xlf:tx_mahupartners_domain_model_division.since',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'size' => 12,
                'eval' => 'datetime',
                'default' => null,
            ],
        ],
        'services' => [
            'exclude' => true,
            'label' => 'LLL:EXT:mahu_partners/Resources/Private/Language/locallang_db.xlf:tx_mahupartners_domain_model_division.services',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim'
            ]
        ],
        'id' => [
            'exclude' => true,
            'label' => 'LLL:EXT:mahu_partners/Resources/Private/Language/locallang_db.xlf:tx_mahupartners_domain_model_division.id',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'type' => [
            'exclude' => true,
            'label' => 'LLL:EXT:mahu_partners/Resources/Private/Language/locallang_db.xlf:tx_mahupartners_domain_model_division.type',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['', 0],
                    ['Firma', 1],
                    ['Forschungseinrichtung', 2],
                ],
                'size' => 1,
                'maxitems' => 1,
                'eval' => ''
            ],
        ],
        'contacts' => [
            'exclude' => true,
            'label' => 'LLL:EXT:mahu_partners/Resources/Private/Language/locallang_db.xlf:tx_mahupartners_domain_model_division.contacts',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'tx_mahupartners_domain_model_contact',
                'foreign_field' => 'division',
                'maxitems' => 9999,
                'appearance' => [
                    'collapseAll' => 0,
                    'levelLinksPosition' => 'top',
                    'showSynchronizationLink' => 1,
                    'showPossibleLocalizationRecords' => 1,
                    'showAllLocalizationLink' => 1
                ],
            ],

        ],
        'expertises' => [
            'exclude' => true,
            'label' => 'LLL:EXT:mahu_partners/Resources/Private/Language/locallang_db.xlf:tx_mahupartners_domain_model_division.expertises',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'tx_mahupartners_domain_model_expertise',
                'foreign_field' => 'division',
                'maxitems' => 9999,
                'appearance' => [
                    'collapseAll' => 0,
                    'levelLinksPosition' => 'top',
                    'showSynchronizationLink' => 1,
                    'showPossibleLocalizationRecords' => 1,
                    'showAllLocalizationLink' => 1
                ],
            ],

        ],
    
        'company' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
    ],
];
