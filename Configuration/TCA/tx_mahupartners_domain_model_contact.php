<?php
return [
    'ctrl' => [
        'title' => 'LLL:EXT:mahu_partners/Resources/Private/Language/locallang_db.xlf:tx_mahupartners_domain_model_contact',
        'label' => 'surname',
        'label_alt' => 'email',
        'label_userFunc' => \Slub\MahuPartners\Domain\Model\Contact::class.'->getLabel',
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
        'searchFields' => 'surname,familyname,title,position,phone,email,fax,material_classes,accounts',
        'iconfile' => 'EXT:mahu_partners/Resources/Public/Icons/tx_mahupartners_domain_model_contact.gif'
    ],
    'interface' => [
        'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, surname, familyname, title, position, phone, email, fax, material_classes, accounts',
    ],
    'types' => [
        '1' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, surname, familyname, title, position, phone, email, fax, material_classes, accounts, --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access, starttime, endtime'],
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
                'foreign_table' => 'tx_mahupartners_domain_model_contact',
                'foreign_table_where' => 'AND tx_mahupartners_domain_model_contact.pid=###CURRENT_PID### AND tx_mahupartners_domain_model_contact.sys_language_uid IN (-1,0)',
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

        'surname' => [
            'exclude' => true,
            'label' => 'LLL:EXT:mahu_partners/Resources/Private/Language/locallang_db.xlf:tx_mahupartners_domain_model_contact.surname',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'familyname' => [
            'exclude' => true,
            'label' => 'LLL:EXT:mahu_partners/Resources/Private/Language/locallang_db.xlf:tx_mahupartners_domain_model_contact.familyname',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'title' => [
            'exclude' => true,
            'label' => 'LLL:EXT:mahu_partners/Resources/Private/Language/locallang_db.xlf:tx_mahupartners_domain_model_contact.title',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'position' => [
            'exclude' => true,
            'label' => 'LLL:EXT:mahu_partners/Resources/Private/Language/locallang_db.xlf:tx_mahupartners_domain_model_contact.position',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'phone' => [
            'exclude' => true,
            'label' => 'LLL:EXT:mahu_partners/Resources/Private/Language/locallang_db.xlf:tx_mahupartners_domain_model_contact.phone',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'email' => [
            'exclude' => true,
            'label' => 'LLL:EXT:mahu_partners/Resources/Private/Language/locallang_db.xlf:tx_mahupartners_domain_model_contact.email',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'nospace,email'
            ]
        ],
        'fax' => [
            'exclude' => true,
            'label' => 'LLL:EXT:mahu_partners/Resources/Private/Language/locallang_db.xlf:tx_mahupartners_domain_model_contact.fax',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'material_classes' => [
            'exclude' => true,
            'label' => 'LLL:EXT:mahu_partners/Resources/Private/Language/locallang_db.xlf:tx_mahupartners_domain_model_contact.material_classes',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim'
            ]
        ],
        'accounts' => [
            'exclude' => true,
            'label' => 'LLL:EXT:mahu_partners/Resources/Private/Language/locallang_db.xlf:tx_mahupartners_domain_model_contact.accounts',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'tx_mahupartners_domain_model_socialnetworkaccount',
                'foreign_field' => 'contact',
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
        'division' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
    ],
];
