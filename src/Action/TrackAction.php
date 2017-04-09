<?php

namespace App\Action;


use App\Collection\EventCollection;
use App\Collection\Item\Event;
use App\Collection\UserCollection;
use App\Enums\EventType;
use Psr\Log\LoggerInterface;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Views\Twig;

class TrackAction
{
	private $view;
	private $logger;
	private $db;

	public function __construct( Twig $view, LoggerInterface $logger, \PDO $db)
	{
		$this->view = $view;
		$this->logger = $logger;
		$this->db = $db;
	}

	function __invoke( Request  $request, Response $response, $args )
	{
		$this->logger->info("Home page action dispatched");


		$logType = EventType::getConstant( $request->getAttribute('log_type') );
		if( $logType )
		{

			$user_token = filter_var($request->getQueryParam('user_token'), FILTER_SANITIZE_STRING);

			$userCollection = new UserCollection($this->db);
			$eventCollection = new EventCollection($this->db);

			$user = $userCollection->getByToken( $user_token );

			if( $user )
			{
				$event = new Event();
				$event->setEventType( $logType );
				$event->setUserId( $user );
				$event->setEventTime();

				if( $eventCollection->save( $event ) )
				{
					$response->getBody()->write("saved");
				}
				else
				{
					$response->getBody()->write("error 3");
				}
			}
			else
			{
				$response->getBody()->write("error 2");
			}
		}
		else
		{
			$response->getBody()->write("error 1");
		}

		return $response;
	}
}