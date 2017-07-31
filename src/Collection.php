<?php

namespace App;

class Collection
{
	protected $db;

	function __construct( \PDO $db )
	{
		$this->db = $db;
	}

	protected function dateToMysql( \DateTime $date, $sufix = "00:00:00" )
	{
		$clone = clone $date;
		return $clone->format('Y-m-d ').$sufix;
	}
}
