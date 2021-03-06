<?php
/**
 * @package Tbs\Helper
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */

namespace Tbs\Helper\Interfaces;

/**
 * Interface of multi-language date helpers.
 *
 * @package Tbs\Helper
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */
interface DateLang
{
    /**
     * Get a month name.
     *
     * @param  int $month
     * @return string
     */
    public function getMonthName($month);
}
