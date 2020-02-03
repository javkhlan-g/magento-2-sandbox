<?php
return [
  'backend' => [
    'frontName' => 'opensesame'
  ],
  'directories' => [
    'document_root_is_pub' => true
  ],
  'crypt' => [
    'key' => 'dadcf9721b9fa3bc4897a2e32aec4291'
  ],
  'db' => [
    'table_prefix' => '',
    'connection' => [
      'default' => [
        'host' => 'mysql',
        'dbname' => 'magento',
        'username' => 'magento',
        'password' => 'magento',
        'model' => 'mysql4',
        'engine' => 'innodb',
        'initStatements' => 'SET NAMES utf8;',
        'active' => '1'
      ]
    ]
  ],
  'resource' => [
    'default_setup' => [
      'connection' => 'default'
    ]
  ],
  'x-frame-options' => 'SAMEORIGIN',
  'MAGE_MODE' => 'default',
  'session' => [
    'save' => 'redis',
    'redis' => [
      'host' => 'redis',
      'port' => '6379',
      'password' => '',
      'timeout' => '2.5',
      'persistent_identifier' => 'M2',
      'database' => '0',
      'compression_threshold' => '2048',
      'compression_library' => 'gzip',
      'log_level' => '1',
      'max_concurrency' => '25',
      'break_after_frontend' => '5',
      'break_after_adminhtml' => '30',
      'first_lifetime' => '600',
      'bot_first_lifetime' => '60',
      'bot_lifetime' => '7200',
      'disable_locking' => '0',
      'min_lifetime' => '60',
      'max_lifetime' => '2592000'
    ]
  ],
  'cache' => [
    'frontend' => [
      'default' => [
        'id_prefix' => 'M2_',
        'backend' => 'Cm_Cache_Backend_Redis',
        'backend_options' => [
          'server' => 'redis',
          'port' => '6379',
          'persistent' => 'M2',
          'database' => '1',
          'force_standalone' => '0',
          'connect_retries' => '1',
          'read_timeout' => '10',
          'automatic_cleaning_factor' => '0',
          'compress_data' => '1',
          'compress_tags' => '1',
          'compress_threshold' => '20480',
          'compression_lib' => 'gzip',
          'use_lua' => '0'
        ]
      ],
      'page_cache' => [
        'id_prefix' => 'M2_',
        'backend' => 'Cm_Cache_Backend_Redis',
        'backend_options' => [
          'server' => 'redis',
          'port' => '6379',
          'persistent' => 'M2',
          'database' => '2',
          'force_standalone' => '0',
          'connect_retries' => '1',
          'read_timeout' => '10',
          'automatic_cleaning_factor' => '0',
          'compress_data' => '0',
          'compress_tags' => '1',
          'lifetimelimit' => '7200'
        ]
      ]
    ]
  ],
  'lock' => [
    'provider' => 'db',
    'config' => [
      'prefix' => null
    ]
  ],
  'cache_types' => [
    'config' => 1,
    'layout' => 1,
    'block_html' => 1,
    'collections' => 1,
    'reflection' => 1,
    'db_ddl' => 1,
    'compiled_config' => 1,
    'eav' => 1,
    'customer_notification' => 1,
    'config_integration' => 1,
    'config_integration_api' => 1,
    'full_page' => 1,
    'config_webservice' => 1,
    'translate' => 1,
    'vertex' => 1,
    'google_product' => 1
  ],
  'downloadable_domains' => [
    'local.accorin.us'
  ],
  'install' => [
    'date' => 'Tue, 07 Jan 2020 04:01:13 +0000'
  ],
  'system' => [
    'default' => [
      'web' => [
        'unsecure' => [
          'base_url' => 'https://local.accorin.us/',
          'base_link_url' => '{{unsecure_base_url}}'
        ],
        'secure' => [
          'base_url' => 'https://local.accorin.us/',
          'base_link_url' => '{{secure_base_url}}'
        ],
        'default' => [
          'front' => 'cms'
        ]
      ]
    ]
  ]
];
