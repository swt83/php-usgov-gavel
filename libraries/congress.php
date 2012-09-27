<?php

class Congress
{
	public $congress, $session, $cycle, $year;

	public static function forge()
	{
		return static::forge_from_year();
	}
	
	public static function forge_from_congress($congress, $session)
	{
		$class = __CLASS__;
		$object = new $class;
		return $object->from_congress($congress, $session);
	}
	
	public static function forge_from_year($year = null)
	{
		$class = __CLASS__;
		$object = new $class;
		return $object->from_year($year);
	}
	
	protected function from_congress($congress, $session)
	{
	
	}
	
	protected function from_year($year)
	{
		// year default is now
		if (!$year)
		{
			$year = (int) strftime('%Y', time());
		}
		
		// set what we know
		$this->year = 2007;
		$this->congress = 110;
		$this->session = 1;
		
		// loop thru years to target
		while($this->year !== $year)
		{
			if($this->year < $year)
			{
				$this->year++;
				$this->session++;
			}
			elseif($this->year > $year)
			{
				$this->year--;
				$this->session--;
			}
			if($this->session === 3)
			{
				$this->congress++;
				$this->session = 1;
			}
			elseif($this->session === 0)
			{
				$this->congress--;
				$this->session = 2;
			}
		}
		$this->year = $year;
		
		// add cycle
		if($odd = $year%2)
		{
			$this->cycle++;
		}
		else
		{
			$this->cycle = $year;
		}
		
		// return
		return $this;
	}
	
	public static function filter($string)
	{
		return preg_replace('/[.,!?:;\'"-]+/i', '', $string);
	}
}