<?php
return [
    'ctrl' => [
        'title' => 'LLL:EXT:mahu_partners/Resources/Private/Language/locallang_db.xlf:tx_mahupartners_domain_model_regulation',
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
        'searchFields' => 'id,name,description,region,tags,img_url,uri,matching_expression,facet_values',
        'iconfile' => 'EXT:mahu_partners/Resources/Public/Icons/tx_mahupartners_domain_model_regulation.gif'
    ],
    'interface' => [
        'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, id, name, description, region, tags, img_url, uri, matching_expression, facet_values',
    ],
    'types' => [
        '1' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, id, name, description, region, tags, img_url, uri, matching_expression, facet_values, --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access, starttime, endtime'],
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
                'foreign_table' => 'tx_mahupartners_domain_model_regulation',
                'foreign_table_where' => 'AND tx_mahupartners_domain_model_regulation.pid=###CURRENT_PID### AND tx_mahupartners_domain_model_regulation.sys_language_uid IN (-1,0)',
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

        'id' => [
            'exclude' => true,
            'label' => 'LLL:EXT:mahu_partners/Resources/Private/Language/locallang_db.xlf:tx_mahupartners_domain_model_regulation.id',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'name' => [
            'exclude' => true,
            'label' => 'LLL:EXT:mahu_partners/Resources/Private/Language/locallang_db.xlf:tx_mahupartners_domain_model_regulation.name',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'description' => [
            'exclude' => true,
            'label' => 'LLL:EXT:mahu_partners/Resources/Private/Language/locallang_db.xlf:tx_mahupartners_domain_model_regulation.description',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim'
            ]
        ],
        'region' => [
            'exclude' => true,
            'label' => 'LLL:EXT:mahu_partners/Resources/Private/Language/locallang_db.xlf:tx_mahupartners_domain_model_regulation.region',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'tags' => [
            'exclude' => true,
            'label' => 'LLL:EXT:mahu_partners/Resources/Private/Language/locallang_db.xlf:tx_mahupartners_domain_model_regulation.tags',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim'
            ]
        ],
        'img_url' => [
            'exclude' => true,
            'label' => 'LLL:EXT:mahu_partners/Resources/Private/Language/locallang_db.xlf:tx_mahupartners_domain_model_regulation.img_url',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'uri' => [
            'exclude' => true,
            'label' => 'LLL:EXT:mahu_partners/Resources/Private/Language/locallang_db.xlf:tx_mahupartners_domain_model_regulation.uri',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'matching_expression' => [
            'exclude' => true,
            'label' => 'LLL:EXT:mahu_partners/Resources/Private/Language/locallang_db.xlf:tx_mahupartners_domain_model_regulation.matching_expression',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'facet_values' => [
            'exclude' => true,
            'label' => 'LLL:EXT:mahu_partners/Resources/Private/Language/locallang_db.xlf:tx_mahupartners_domain_model_regulation.facet_values',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim'
            ]
        ],
    
    ],
];
