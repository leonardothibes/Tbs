<?php
/**
 * @package Tbs\Helper
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */

namespace Tbs\Helper;

use \Tbs\Helper\Interfaces\Validate as V;

/**
 * Date helper functions.
 *
 * @package Tbs\Helper
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */
class Date implements V
{
    /**
     * Test if date is valid.
     *
     * @param  string $date
     * @return bool
     */
    public static function isValid($date)
    {
        if (!preg_match('/^[0-9]{2}\/[0-9]{2}\/[0-9]{4}$/', $date)) {
            return false;
        }
        list($d, $m, $y) = explode('/', $date);
        return checkdate($m, $d, $y);
    }

    /**
     * Sanitize the date.
     *
     * @param  string $date
     * @return mixed
    */
    public static function sanitize($date)
    {
        list($d, $m, $y) = @explode('/', $date);
        $d = ($d < 10) ? '0' . (int)$d : (int)$d;
        $m = ($m < 10) ? '0' . (int)$m : (int)$m;
        return sprintf('%s/%s/%d', $d, $m, $y);
    }

    /**
     * List retroactive years.
     *
     * @param int $amount Amount of years to list.
     * @param int $last   Last year's list(current is default).
     *
     * @return array
     */
    public static function yearsList($amount, $last = null)
    {
        $last  = strlen($last) ? (int)$last : date('Y');
        $first = $last - $amount;
        return self::yearsRange($first, $last);
    }

    /**
     * List a range years.
     *
     * @param int $first Amount of years to list.
     * @param int $last  Last year's list(current is default).
     *
     * @return array
     */
    public static function yearsRange($first, $last = null)
    {
        $last  = strlen($last) ? (int)$last : date('Y');
        $list  = array();
        for ($i = $last; $i >= $first; $i--) {
            $list[$i] = $i;
        }
        return $list;
    }

    /**
     * Get last day of specified month.
     *
     * @param int $month
     * @param int $year
     *
     * @return int
     */
    public static function lastDay($month, $year = null)
    {
        $year = strlen($year) ? (int)$year : date('Y');
        $date = mktime(0, 0, 0, $month + 1, 1, $year);
        return (int)date("d", $date - 1);
    }

    /**
     * Get a month name.
     *
     * @param int    $month
     * @param string $lang
     *
     * @return string
     */
    public static function monthName($month, $lang = 'en')
    {
        switch($lang) {
            case 'pt':
            case 'br':
                $lang = new \Tbs\Helper\Date\Lang\Pt;
                break;
            default:
                $lang = new \Tbs\Helper\Date\Lang\En;
                break;
        }
        return $lang->getMonthName($month);
    }

    /**
     * Get a short month name.
     *
     * @param int    $month
     * @param string $lang
     *
     * @return string
     */
    public static function shortMonthName($month, $lang = 'en')
    {
        $name = self::monthName($month, $lang);
        return substr($name, 0, 3);
    }
}
