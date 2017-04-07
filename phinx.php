<?php
$config = require(__DIR__ . '/config/config.php');

$phinxConfig = array(
	"paths" => array(
		"migrations" => "db/migrations",
		"seeds" => "db/seeds"
	),
	"environments" => array(
		"default_migration_table" => "phinxlog",
		"default_database" => "development"
	)
);

if ( isset($config['db']) )
{
	$phinxConfig['environments']['development'] = array(
		"adapter" => "mysql",
		"host" => $config['db']['host'],
		"name" => $config['db']['dbname'],
		"user" => $config['db']['user'],
		"pass" => $config['db']['pass'],
		"port" => 3306,
		"collation" => 'utf8mb4_unicode_ci'
	);
}

return $phinxConfig;