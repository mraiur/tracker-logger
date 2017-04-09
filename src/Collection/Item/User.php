<?php

namespace App\Collection\Item;

use App\Collection\Item;

class User extends Item
{
	protected $id = null;
	protected $username = null;

	public function getId()
	{
		return $this->id;
	}

	public function getUsername()
	{
		return $this->username;
	}

	public function setId( $id )
	{
		$this->id = $id;
	}

	public function setUsername( $username )
	{
		$this->username = $username;
	}
}