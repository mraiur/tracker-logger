<?php
namespace App\Collection;

class Item {

	protected function formatMagic( $type, $key )
	{
		return str_replace("_", "", "set".ucwords($key, '_'));
	}

	function __construct( $data = [] )
	{
		foreach( $data as $key => $value )
		{
			$setMethodName = $this->formatMagic("set", $key );

			if( method_exists($this, $setMethodName ) )
			{
				$arguments = $value;

				if( !is_array($arguments) )
				{
					$arguments = [$arguments];
				}
				call_user_func_array([$this, $setMethodName], $arguments );
			}
		}
	}


}