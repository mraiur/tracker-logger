<?php
namespace App\Collection;

use App\Collection;
use App\Collection\Item\Event;
use App\Collection\Item\User;
use App\Enums\EventType;

class EventCollection extends Collection
{
	public function save( Event $event )
	{
		$sql = "
		INSERT INTO sleep_log
			(user_id, event_type, event_time)
		VALUES
			(:user_id, :event_type, NOW() )
		";

		$stmt = $this->db->prepare($sql);

		$result = $stmt->execute([
			"user_id" => $event->getUserId(),
			"event_type" => $event->getEventType()
		]);

		if(!$result)
		{
			return false;
		}
		return true;
	}

	public function getUserLog( User $user, $start_date, $end_date)
	{
		$user_id = $user->getId();
		if( $start_date instanceof \DateTime )
		{
			$start_date = $this->dateToMysql( $start_date, '23:59:00');
		}

		if( $end_date instanceof \DateTime )
		{
			$end_date = $this->dateToMysql($end_date, '23:59:00');
		}

		$list = [];

		if( $user_id )
		{
			$sql = "
			SELECT
				id,
				event_type,
				event_time,
				user_id
			FROM
				sleep_log
			WHERE
				user_id = :user_id
			AND
				event_time > :start_date AND event_time < :end_date
		  	ORDER BY
		  		event_time ASC
			";
			$stmt = $this->db->prepare($sql);

			$stmt->bindParam(':user_id', $user_id, \PDO::PARAM_INT);
			$stmt->bindParam(':start_date', $start_date, \PDO::PARAM_STR);
			$stmt->bindParam(':end_date', $end_date, \PDO::PARAM_STR);

			$result = $stmt->execute(  );

			if( $result )
			{
				$records = $stmt->fetchAll();
				$byDay = [];
				foreacH( $records as $item )
				{
					$event =  new Event($item);
					$eventDate = $event->getEventTime()->format('Y-m-d');
					$byDay[$eventDate][] = $event;
				}

				foreach( $byDay as $date => $day )
				{
					$list[$date] = [];

					$block = [
						"start" => null,
						"end" => null,
						"duration" => null
					];

					foreach ( $day as $event )
					{
						$eventDate = $event->getEventTime();
						$eventType = $event->getEventType();


						$dayStartTime = \DateTime::createFromFormat('Y-m-d H:i:s', $event->getFormatedEventTime() );
						$dayStartTime->setTime(0, 0);

						$timeDifference = $dayStartTime->diff($eventDate);
						$timeMinuteDifference = $timeDifference->h * 60;
						$timeMinuteDifference += $timeDifference->i;

						if( $eventType === EventType::START )
						{
							$block['start'] = $timeMinuteDifference;
						}

						if( $eventType === EventType::END )
						{
							$block['end'] = $timeMinuteDifference;
						}

						if( $block['start'] != null && $block['end'] != null )
						{
							$block['duration'] = $block['end'] - $block['start'];
							$list[$date][] = $block;
							$block = [
								"start" => null,
								"end" => null,
								"duration" => null
							];
						}
					}
				}
			}

			return $list;
		}

		return $list;
	}
}
