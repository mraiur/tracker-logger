<?php

namespace App\Action;


use App\Collection;
use Psr\Log\LoggerInterface;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Views\Twig;

class HomeAction
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

		$userCollection = new Collection\UserCollection( $this->db );

		$tplData = [
			'users' => $userCollection->listUsers()
		];
		$this->view->render($response, 'home.twig', $tplData);
		return $response;
	}
}