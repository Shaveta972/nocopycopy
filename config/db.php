<?php
if (YII_ENV_DEV) {
    return [
        'class' => 'yii\db\Connection',
        'dsn' => 'mysql:host=localhost;dbname=nocowjet_staging_no_copy',
        // 'username' => 'nocowjet_staging_no_copy',
        // 'password' => '4GH22YZHYCMI',
			// 'dsn' => 'mysql:host=localhost;dbname=no_copy',
			'username' => 'root',
			'password' => '',
        'charset' => 'utf8',
        'tablePrefix' => 'tbl_',
    ];
} else if (YII_ENV === 'staging') {
    return [
        'class' => 'yii\db\Connection',
        'dsn' => 'mysql:host=localhost;dbname=nocowjet_staging_no_copy',
        'username' => 'nocowjet_staging_no_copy',
        'password' => '4GH22YZHYCMI',
        'charset' => 'utf8',
        'tablePrefix' => 'tbl_',
    ];
} else if (YII_ENV_PROD) {
    return [
        'class' => 'yii\db\Connection',
        'dsn' => 'mysql:host=localhost;dbname=nocowjet_staging_no_copy',
        'username' => 'nocowjet_staging_no_copy',
        'password' => '4GH22YZHYCMI',
        'charset' => 'utf8',
        'tablePrefix' => 'tbl_',
        // Schema cache options (for production environment)
        'enableSchemaCache' => true,
        'schemaCacheDuration' => 60,
        'schemaCache' => 'cache',
    ];
}
