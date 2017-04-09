<?php

namespace App\Action;


use App\Collection;
use App\Collection\EventCollection;
use App\Collection\UserCollection;
use Psr\Log\LoggerInterface;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Views\Twig;

class ViewUserAction
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
		$this->logger->info("ViewUser action");

		$username = $request->getAttribute('username');

		$start_date = \DateTime::createFromFormat('Y-m-d', $request->getAttribute('start_date') );
		$end_date = \DateTime::createFromFormat('Y-m-d',$request->getAttribute('end_date') );

		if(!$start_date)
		{
			$start_date = new \DateTime();
		}

		if(!$end_date)
		{
			$end_date = new \DateTime();
			$end_date->sub(new \DateInterval('P7D'));
		}

		$userCollection = new UserCollection( $this->db );
		$eventCollection = new EventCollection( $this->db );

		$user = $userCollection->getByUsername( $username );


		$log = $eventCollection->getUserLog( $user, $start_date, $end_date );
		$formatedLog = [];

		$headers = [];

		$hourSize = 100 / 24;
		for( $i = 0; $i < 24; $i++ )
		{
			$label = ($i<10) ? '0'.$i : $i;
			$headers[] = [
				'width' => $hourSize,
				'left' => $hourSize * $i,
				'text' => $label . "h"
			];
		}

		foreach( $log as $day => $blocks )
		{
			$formatedLog[$day] = [];

			foreach( $blocks as $block )
			{
				$label = '';

				if( $block['duration'] > 60 )
				{
					$blockHours = floor( $block['duration']/60 );
					$blockMinutes = $block['duration'] - ($blockHours*60);
					$label = $blockHours."h ".$blockMinutes."min";
				}
				else
				{
					$label = $block['duration']."min";
				}
				$block['width'] = ( $block['duration'] / 60 ) * $hourSize;
				$block['left'] = ( $block['start'] / 60 ) * $hourSize;
				$block['text'] = $label;
				$formatedLog[$day][] = $block;
			}
		}

		$tplData = [
			'user' => $user,
			"headers" => $headers,
			'formatedLog' => $formatedLog
		];

//		var_dump($tplData); die();

		$this->view->render($response, 'view_user.twig', $tplData);
		return $response;
	}
}