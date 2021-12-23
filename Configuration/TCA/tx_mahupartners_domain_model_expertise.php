<?php
return [
    'ctrl' => [
        'title' => 'LLL:EXT:mahu_partners/Resources/Private/Language/locallang_db.xlf:tx_mahupartners_domain_model_expertise',
        'label' => 'type',
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
        'searchFields' => 'type,name,description,purpose,quantities,customization,material_classes,regulations',
        'iconfile' => 'EXT:mahu_partners/Resources/Public/Icons/tx_mahupartners_domain_model_expertise.gif'
    ],
    'interface' => [
        'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, type, name, description, purpose, quantities, customization, material_classes, regulations',
    ],
    'types' => [
        '1' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, type, name, description, purpose, quantities, customization, material_classes, regulations, --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access, starttime, endtime'],
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
                'foreign_table' => 'tx_mahupartners_domain_model_expertise',
                'foreign_table_where' => 'AND tx_mahupartners_domain_model_expertise.pid=###CURRENT_PID### AND tx_mahupartners_domain_model_expertise.sys_language_uid IN (-1,0)',
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

        'type' => [
            'exclude' => true,
            'label' => 'LLL:EXT:mahu_partners/Resources/Private/Language/locallang_db.xlf:tx_mahupartners_domain_model_expertise.type',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
			        ['Production', 0],
			        ['Testing', 1],
			        ['Certification', 2],
			        ['Coating', 3],
			        ['Processing', 4],
			        ['Construction', 5],
                ],
                'size' => 1,
                'maxitems' => 1,
                'eval' => ''
            ],
        ],
        'name' => [
            'exclude' => true,
            'label' => 'LLL:EXT:mahu_partners/Resources/Private/Language/locallang_db.xlf:tx_mahupartners_domain_model_expertise.name',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'description' => [
            'exclude' => true,
            'label' => 'LLL:EXT:mahu_partners/Resources/Private/Language/locallang_db.xlf:tx_mahupartners_domain_model_expertise.description',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim'
            ]
        ],
        'purpose' => [
            'exclude' => true,
            'label' => 'LLL:EXT:mahu_partners/Resources/Private/Language/locallang_db.xlf:tx_mahupartners_domain_model_expertise.purpose',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'quantities' => [
            'exclude' => true,
            'label' => 'LLL:EXT:mahu_partners/Resources/Private/Language/locallang_db.xlf:tx_mahupartners_domain_model_expertise.quantities',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'customization' => [
            'exclude' => true,
            'label' => 'LLL:EXT:mahu_partners/Resources/Private/Language/locallang_db.xlf:tx_mahupartners_domain_model_expertise.customization',
            'config' => [
                'type' => 'check',
                'items' => [
                    '1' => [
                        '0' => 'LLL:EXT:lang/Resources/Private/Language/locallang_core.xlf:labels.enabled'
                    ]
                ],
                'default' => 0,
            ]
            
        ],
        'material_classes' => [
            'exclude' => true,
            'label' => 'LLL:EXT:mahu_partners/Resources/Private/Language/locallang_db.xlf:tx_mahupartners_domain_model_expertise.material_classes',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim'
            ]
        ],
        'regulations' => [
            'exclude' => true,
            'label' => 'LLL:EXT:mahu_partners/Resources/Private/Language/locallang_db.xlf:tx_mahupartners_domain_model_expertise.regulations',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingleBox',
                'foreign_table' => 'tx_mahupartners_domain_model_regulation',
                'MM' => 'tx_mahupartners_expertise_regulation_mm',
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
