<?php

class User
{
	private $db;

	protected $id;
	protected $username;

	public function __construct( $db)
	{
		$this->db = $db;
	}

	public function getId()
	{
		return $this->id;
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
				$this->id = $record['id'];

				return true;
			}
		}
		return false;
	}
}