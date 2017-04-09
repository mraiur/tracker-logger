<?php

namespace App\Collection;

use App\Collection;
use App\Collection\Item\User;

class UserCollection extends Collection
{
	public function listUsers()
	{
		$list = [];

		$sql = "
		SELECT
			id,
			username
		FROM
			users
		";
		$stmt = $this->db->prepare($sql);
		$result = $stmt->execute([]);

		if( $result )
		{
			$records = $stmt->fetchAll();

			foreacH( $records as $item )
			{
				$user = new User( $item );
				$list[] = $user;
			}
		}

		return $list;
	}

	public function getByUsername($username)
	{
		$sql = "
		SELECT 
			id,
			username
		FROM 
			users
        WHERE 
        	username = :username ";
		$stmt = $this->db->prepare($sql);
		$result = $stmt->execute(["username" => $username]);

		if( $result )
		{
			$record = $stmt->fetch();
			if( $record )
			{
				return new User($record);
			}
		}
		return false;
	}

	public function getByToken($token)
	{
		$sql = "
		SELECT 
			id,
			username
		FROM 
			users
        WHERE 
        	log_token = :token ";
		$stmt = $this->db->prepare($sql);
		$result = $stmt->execute(["token" => $token]);

		if( $result )
		{
			$record = $stmt->fetch();
			if( $record )
			{
				return new User($record);
			}
		}
		return false;
	}
}