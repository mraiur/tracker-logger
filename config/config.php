<?php

$config = [
	"displayErrorDetails" => true,
	"addContentLengthHeader" => false,

	'mode'              => 'debug',
	'base_path'         => 'base-web',
	'host'				=> 'http://localhost',

	// View settings
	'view' => [
		'template_path' => __DIR__ . '/../src/view',
		'twig' => [
			'cache' => __DIR__ . '/../cache/twig',
			'debug' => true,
			'auto_reload' => true,
		],
	],
	// monolog settings
	'logger' => [
		'name' => 'app',
		'path' => __DIR__ . '/../../log/' . date('Y-m-d') . '-app.log',
	],

	"db" => [
		'host'      => "127.0.0.1",
		'user'      => "root",
		'pass'      => "root",
		'dbname'    => '',
		'collation' => 'utf8_unicode_ci',
		'charset'   => 'utf8'
	]
];

if( file_exists( __DIR__."/config.local.php" ) )
{
	$config = array_replace_recursive($config, require( __DIR__."/config.local.php"));
}
return $config;
