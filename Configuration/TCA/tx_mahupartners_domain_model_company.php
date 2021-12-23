<?php
return [
    'ctrl' => [
        'title' => 'LLL:EXT:mahu_partners/Resources/Private/Language/locallang_db.xlf:tx_mahupartners_domain_model_company',
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
        'searchFields' => 'name,www,logo,facet,facet_value,description,since,services,street,zip,city,country,business_area,number_of_employees,form_of_company,superordinate,id,contacts,expertises,divisions',
        'iconfile' => 'EXT:mahu_partners/Resources/Public/Icons/tx_mahupartners_domain_model_company.gif'
    ],
    'interface' => [
        'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, name, id, type, www, logo, facet, facet_value, description, disclaimer, since, services, street, zip, city, country, business_area, number_of_employees, form_of_company, superordinate, userid, editors, contacts, expertises, divisions',
    ],
    'types' => [
        '1' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, name, id, type, www, logo, facet, facet_value, description, disclaimer, since, services, street, zip, city, country, business_area, number_of_employees, form_of_company, superordinate, userid, editors, contacts, expertises, divisions, --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access, starttime, endtime'],
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
                'foreign_table' => 'tx_mahupartners_domain_model_company',
                'foreign_table_where' => 'AND tx_mahupartners_domain_model_company.pid=###CURRENT_PID### AND tx_mahupartners_domain_model_company.sys_language_uid IN (-1,0)',
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
            'label' => 'LLL:EXT:mahu_partners/Resources/Private/Language/locallang_db.xlf:tx_mahupartners_domain_model_company.name',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'www' => [
            'exclude' => true,
            'label' => 'LLL:EXT:mahu_partners/Resources/Private/Language/locallang_db.xlf:tx_mahupartners_domain_model_company.www',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'logo' => [
            'exclude' => true,
            'label' => 'LLL:EXT:mahu_partners/Resources/Private/Language/locallang_db.xlf:tx_mahupartners_domain_model_company.logo',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'facet' => [
            'exclude' => true,
            'label' => 'LLL:EXT:mahu_partners/Resources/Private/Language/locallang_db.xlf:tx_mahupartners_domain_model_company.facet',
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
            'label' => 'LLL:EXT:mahu_partners/Resources/Private/Language/locallang_db.xlf:tx_mahupartners_domain_model_company.facet_value',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'description' => [
            'exclude' => true,
            'label' => 'LLL:EXT:mahu_partners/Resources/Private/Language/locallang_db.xlf:tx_mahupartners_domain_model_company.description',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim'
            ]
        ],
        'disclaimer' => [
            'exclude' => true,
            'label' => 'LLL:EXT:mahu_partners/Resources/Private/Language/locallang_db.xlf:tx_mahupartners_domain_model_company.disclaimer',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim'
            ]
        ],
        'since' => [
            'exclude' => true,
            'label' => 'LLL:EXT:mahu_partners/Resources/Private/Language/locallang_db.xlf:tx_mahupartners_domain_model_company.since',
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
            'label' => 'LLL:EXT:mahu_partners/Resources/Private/Language/locallang_db.xlf:tx_mahupartners_domain_model_company.services',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim'
            ]
        ],
        'street' => [
            'exclude' => true,
            'label' => 'LLL:EXT:mahu_partners/Resources/Private/Language/locallang_db.xlf:tx_mahupartners_domain_model_company.street',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'zip' => [
            'exclude' => true,
            'label' => 'LLL:EXT:mahu_partners/Resources/Private/Language/locallang_db.xlf:tx_mahupartners_domain_model_company.zip',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'city' => [
            'exclude' => true,
            'label' => 'LLL:EXT:mahu_partners/Resources/Private/Language/locallang_db.xlf:tx_mahupartners_domain_model_company.city',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'country' => [
            'exclude' => true,
            'label' => 'LLL:EXT:mahu_partners/Resources/Private/Language/locallang_db.xlf:tx_mahupartners_domain_model_company.country',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'business_area' => [
            'exclude' => true,
            'label' => 'LLL:EXT:mahu_partners/Resources/Private/Language/locallang_db.xlf:tx_mahupartners_domain_model_company.business_area',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'number_of_employees' => [
            'exclude' => true,
            'label' => 'LLL:EXT:mahu_partners/Resources/Private/Language/locallang_db.xlf:tx_mahupartners_domain_model_company.number_of_employees',
            'config' => [
                'type' => 'input',
                'size' => 4,
                'eval' => 'int',
                'default' => 0,
            ]
        ],
        'form_of_company' => [
            'exclude' => true,
            'label' => 'LLL:EXT:mahu_partners/Resources/Private/Language/locallang_db.xlf:tx_mahupartners_domain_model_company.form_of_company',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'superordinate' => [
            'exclude' => true,
            'label' => 'LLL:EXT:mahu_partners/Resources/Private/Language/locallang_db.xlf:tx_mahupartners_domain_model_company.superordinate',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'id' => [
            'exclude' => true,
            'label' => 'LLL:EXT:mahu_partners/Resources/Private/Language/locallang_db.xlf:tx_mahupartners_domain_model_company.id',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'type' => [
            'exclude' => true,
            'label' => 'LLL:EXT:mahu_partners/Resources/Private/Language/locallang_db.xlf:tx_mahupartners_domain_model_company.type',
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
        'userid' => [
            'exclude' => 1,
            'label' => "Id of the User that created the record",
            'config' => [
                'type' => 'input',
                'size' => 10,
                'eval' => 'int',
                'default' => 0,
            ],
        ],
        'editors' => [
            'exclude' => 1,
            'label' => "Ids of users that can editor that Company record.",
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'contacts' => [
            'exclude' => true,
            'label' => 'LLL:EXT:mahu_partners/Resources/Private/Language/locallang_db.xlf:tx_mahupartners_domain_model_company.contacts',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'tx_mahupartners_domain_model_contact',
                'foreign_field' => 'company',
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
            'label' => 'LLL:EXT:mahu_partners/Resources/Private/Language/locallang_db.xlf:tx_mahupartners_domain_model_company.expertises',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'tx_mahupartners_domain_model_expertise',
                'foreign_field' => 'company',
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
        'divisions' => [
            'exclude' => true,
            'label' => 'LLL:EXT:mahu_partners/Resources/Private/Language/locallang_db.xlf:tx_mahupartners_domain_model_company.divisions',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'tx_mahupartners_domain_model_division',
                'foreign_field' => 'company',
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
    
    ],
];
