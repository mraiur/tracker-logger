<?php
namespace App\Enums;

class EventType
{
	const START = 1;
	const END = 2;

	public static function getConstant( $value )
	{
		$reflection = new \ReflectionClass(__CLASS__ );
		$constants = $reflection->getConstants();

		$value = intval($value);
		if( $value > 0 && in_array($value, $constants))
		{
			return $value;
		}
		return null;
	}
}