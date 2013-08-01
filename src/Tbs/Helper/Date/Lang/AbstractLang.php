<?php
/**
 * @category Library
 * @package Tbs
 * @subpackage Helper
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */

namespace Tbs\Helper\Date\Lang;

use \Tbs\Helper\Interfaces\DateLang as D;

/**
 * Abstract class for the lang date classes.
 *
 * @category Library
 * @package Tbs
 * @subpackage Helper
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */
abstract class AbstractLang implements D
{
    /**
     * Get a month name.
     *
     * @param  int $month
     * @return string
     */
    public function getMonthName($month)
    {
        return $this->months[$month];
    }
}
