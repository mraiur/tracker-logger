<?php

namespace App;

class Collection
{
	protected $db;

	function __construct( \PDO $db )
	{
		$this->db = $db;
	}

	protected function dateToMysql( \DateTime $date )
	{
		return $date->format('Y-m-d H:i:s');
	}
}