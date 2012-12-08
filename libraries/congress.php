<?php

class Congress
{
    public $congress, $session, $cycle, $year;
    
    /**
     * Build congress info based on congress.
     *
     * @return  object
     */
    protected static function from_congress($congress, $session)
    {
        // create
        $class = __CLASS__;
        $object = new $class;

        // set vars
        $object->congress = $congress;
        $object->session = $session;

        // calculate
        // ...

        // return
        return $object;
    }
    
    /**
     * Build congress info based on year.
     *
     * @return  object
     */
    public static function from_year($year = null)
    {
        // create
        $class = __CLASS__;
        $object = new $class;

        // set vars
        if (!$year) $year = (int) strftime('%Y', time());
        $object->year = $year;
    
        // set givens
        $object->year = 2007;
        $object->congress = 110;
        $object->session = 1;
        
        // loop thru years to target
        while($object->year !== $year)
        {
            if($object->year < $year)
            {
                $object->year++;
                $object->session++;
            }
            elseif($object->year > $year)
            {
                $object->year--;
                $object->session--;
            }
            if($object->session === 3)
            {
                $object->congress++;
                $object->session = 1;
            }
            elseif($object->session === 0)
            {
                $object->congress--;
                $object->session = 2;
            }
        }
        $object->year = $year;
        
        // add cycle
        if($odd = $year%2)
        {
            $object->cycle++;
        }
        else
        {
            $object->cycle = $year;
        }
        
        // return
        return $object;
    }

    /**
     * Alias of from_year() method.
     *
     * @return  object
     */
    public static function current()
    {
        return static::from_year();
    }
    
    /**
     * Filter bill ids to standardized format.
     *
     * @return  string
     */
    public static function filter($string)
    {
        return preg_replace('/[.,!?:;\'"-]+/i', '', $string);
    }
}