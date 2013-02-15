<?php

class Gavel {

    public $congress, $session, $cycle, $year;
    
    /**
     * Build congress info based on congress.
     *
     * @param   int $congress
     * @param   int $session
     * @return  object
     */
    public static function from_congress($congress, $session)
    {
        // create
        $class = __CLASS__;
        $object = new $class;

        // set vars
        $congress = (int) $congress;
        $session = (int) $session;

        // set givens
        $object->year = 2007;
        $object->congress = 110;
        $object->session = 1;

        // loop thru congresses to target...
        while ($object->congress !== $congress or $object->session !== $session)
        {
            if ($object->congress < $congress)
            {
                $object->year++;
                $object->session++;
            }
            elseif ($object->congress > $congress)
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
            if ($object->congress === $congress and $object->session !== $session)
            {
                if ($object->session === 1)
                {
                    $object->year++;
                    $object->session++;
                }
                elseif ($object->session === 2)
                {
                    $object->year--;
                    $object->session--;
                }
            }
        }
        $object->congress = $congress;
        $object->session = $session;
        $object->set_cycle();

        // return
        return $object;
    }
    
    /**
     * Build congress info based on year.
     *
     * @param   int $year   Year to find congress/session pair
     * @return  object
     */
    public static function from_year($year = null)
    {
        // create
        $class = __CLASS__;
        $object = new $class;

        // set vars
        if (!$year) $year = (int) strftime('%Y', time());
        $year = (int) $year;
    
        // set givens
        $object->year = 2007;
        $object->congress = 110;
        $object->session = 1;
        
        // loop thru years to target...
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
        $object->set_cycle();
        
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
     * Calculate the cycle associated w/ the year.
     *
     * @return void
     */
    public function set_cycle()
    {
        // calculate cycle
        if($odd =  $this->year%2)
        {
            $this->cycle++;
        }
        else
        {
            $this->cycle = $this->year;
        }
    }

    /**
     * Filter bill ids to standardized format.
     *
     * @param   string  $string Bill reference ids for filtering
     * @return  string
     */
    public static function filter($string)
    {
        return preg_replace('/[.,!?:;\'"-]+/i', '', $string);
    }

}