<?php

namespace Travis;

use Travis\Date;

class Gavel
{
    public $congress, $session, $cycle, $year;

    /**
     * Constructor using congress and session as start data.
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

        // cleanup
        $object->congress = $congress;
        $object->session = $session;
        $object->calc_cycle();

        // return
        return $object;
    }

    /**
     * Constructor using year as start data.
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
        if (!$year) $year = Date::forge()->format('%Y');
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

        // cleaup
        $object->year = $year;
        $object->calc_cycle();

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
     * Return the election cycle year based on current year.
     *
     * @return  int
     */
    protected function calc_cycle()
    {
        if($odd = $this->year%2)
        {
            $this->cycle = $this->year + 1;
        }
        else
        {
            $this->cycle = $this->year;
        }
    }

    /**
     * Return standardized string of a bill (S.123 -> S123).
     *
     * @param   string  $string
     * @return  string
     */
    public static function bill_clean($string)
    {
        $string = preg_replace('/[.,!?:;\'"-]+/i', '', $string);
        $string = str_ireplace([' '], [''], $string);

        return strtoupper($string);
    }

    /**
     * Return properly formateed string of a bill (S123 -> S. 123).
     *
     * @param   string  $string
     * @return  string
     */
    public static function bill_format($string, $is_no_spaces = true)
    {
        $part = static::bill_split($string);

        $map = [
            'hconres' => 'H. Con. Res.',
            'hjres' => 'H. J. Res.',
            'hr' => 'H. R.',
            'hres' => 'H. Res.',
            's' => 'S.',
            'sconres' => 'S. Con. Res.',
            'sjres' => 'S. J. Res.',
            'sres' => 'S. Res.',
        ];

        $type = trim(isset($map[strtolower($part['type'])]) ? $map[strtolower($part['type'])] : $part['type']);
        $number = $part['number'];

        if ($is_no_spaces) $type = str_ireplace([' '], [''], $type);

        return $type.' '.$number;
    }

    /**
     * Return array of info from given bill string.
     *
     * @param   string  $string
     * @return  array
     */
    public static function bill_split($string)
    {
        $string = static::bill_clean($string);

        // split string
        $result = preg_split('/([a-z]+)/i', $string, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);

        // prepare array
        $final = array(
            'type' => isset($result[0]) ? $result[0] : null,
            'number' => isset($result[1]) ? $result[1] : null,
        );

        // return
        return $final;
    }
}