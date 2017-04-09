<?php
require '../vendor/autoload.php';

$config = require("../config/config.php");

$app = new \Slim\App(['settings' => $config ]);

require __DIR__ . '/../config/dependencies.php';
require __DIR__ . '/../config/routes.php';



/*


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
});*/

$app->run();