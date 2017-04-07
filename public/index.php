<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';

spl_autoload_register(function ($classname) {
	require ("../src/classes/" . $classname . ".php");
});

$config = require("../config/config.php");

$app = new \Slim\App(['settings' => $config ]);
$container = $app->getContainer();

$container['view'] = new \Slim\Views\PhpRenderer("../src/templates/");

$container['logger'] = function($c) {
	$logger = new \Monolog\Logger('my_logger');
	$file_handler = new \Monolog\Handler\StreamHandler("../logs/app.log");
	$logger->pushHandler($file_handler);
	return $logger;
};

$container['db'] = function ($c) {
	$db = $c['settings']['db'];
	$pdo = new PDO("mysql:host=" . $db['host'] . ";dbname=" . $db['dbname'], $db['user'], $db['pass']);
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
	return $pdo;
};

$app->get('/{user}', function (Request $request, Response $response) {
	$user = $request->getAttribute('user');
	$response->getBody()->write("view data for user $user");

	return $response;
});

$app->post('/track/{log_type}', function(Request $request, Response $response) {

	$data = $request->getParsedBody();
	$user_token = filter_var($data['user_token'], FILTER_SANITIZE_STRING);
	$logType = $request->getAttribute('log_type');

	$user = new User($this->db);
	if( $user->getByToken( $user_token ) && $logType )
	{
		$event = new Event($this->db);
		$event->setEventType( $logType );
		$event->setUserId( $user->getId() );

		if( $event->save() )
		{
			$response->getBody()->write("saved");
		}
		else
		{
			$response->getBody()->write("error 1");
		}
	}
	else
	{
		$response->getBody()->write("error 2");
	}

	return $response;
});

$app->run();