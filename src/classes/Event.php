<?php

class Event
{
	private $db;

	protected $id;
	protected $user_id;
	protected $event_type;

	public function __construct( $db)
	{
		$this->db = $db;
	}

	public function setUserId($id)
	{
		$this->user_id = $id;
	}

	public function setEventType($eventType)
	{
		$this->event_type = $eventType;
	}

	public function save()
	{
		$sql = "
			INSERT INTO sleep_log
            	(user_id, event_type, event_time)
			VALUES
            (:user_id, :event_type, NOW() )
		";

		$stmt = $this->db->prepare($sql);

		$result = $stmt->execute([
			"user_id" => $this->user_id,
			"event_type" => $this->event_type
		]);

		if(!$result)
		{
			return false;
		}
		return true;
	}
}