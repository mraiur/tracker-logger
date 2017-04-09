<?php
$container = $app->getContainer();

$container['view'] = function ($c) {
	$settings = $c->get('settings');
	$view = new Slim\Views\Twig($settings['view']['template_path'], $settings['view']['twig']);

	// Add extensions
	$view->addExtension(new Slim\Views\TwigExtension($c->get('router'), $c->get('request')->getUri()));
	$view->addExtension(new Twig_Extension_Debug());

	return $view;
};

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

$container[App\Action\HomeAction::class] = function ($c) {
	return new App\Action\HomeAction($c->get('view'), $c->get('logger'), $c->get('db'));
};

$container[App\Action\ViewUserAction::class] = function ($c) {
	return new App\Action\ViewUserAction($c->get('view'), $c->get('logger'), $c->get('db'));
};

$container[App\Action\TrackAction::class] = function ($c) {
	return new App\Action\TrackAction($c->get('view'), $c->get('logger'), $c->get('db'));
};