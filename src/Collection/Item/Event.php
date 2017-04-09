<?php
namespace App\Collection\Item;

use App\Collection\Item;

class Event extends Item
{
	protected $id;
	protected $user_id;
	protected $event_type;
	protected $event_time;

	public function setId( $id )
	{
		$this->$id = $id;
	}

	public function setEventTime($value = null )
	{
		if( $value == null )
		{
			$value = new \DateTime();
		}
		else if( $value instanceof  \DateTime)
		{
			$this->event_time = $value;
		}
		else
		{
			$this->event_time = \DateTime::createFromFormat('Y-m-d H:i:s', $value);
		}

	}

	public function setUserId($value)
	{
		if( $value instanceof  User )
		{
			$this->user_id = $value->getId();
		}
		else
		{
			$this->user_id = intval($value);
		}
	}

	public function setEventType($eventType)
	{
		$this->event_type = intval($eventType);
	}

	public function getEventType()
	{
		return $this->event_type;
	}

	public function getId()
	{
		return $this->id;
	}

	public function getUserId()
	{
		return $this->user_id;
	}

	/**
	 * @return mixed
	 */
	public function getEventTime()
	{
		return $this->event_time;
	}

	public function getFormatedEventTime()
	{
		return $this->event_time->format('Y-m-d H:i:s');
	}
}