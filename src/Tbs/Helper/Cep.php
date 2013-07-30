<?php
/**
 * @category Library
 * @package Tbs
 * @subpackage Helper
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */

namespace Tbs\Helper;

use \Tbs\Helper\Interfaces\Mask     as M;
use \Tbs\Helper\Interfaces\Validate as V;

/**
 * CEP helper functions.
 *
 * @category Library
 * @package Tbs
 * @subpackage Helper
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */
class Cep implements M, V
{
    /**
     * Test if CEP is valid.
     *
     * @param  mixed $cep
     * @return bool
     */
    public static function isValid($cep)
    {
        return (bool)preg_match('/^[0-9]{5}\-[0-9]{3}$/', $cep);
    }

    /**
     * Sanitize the CEP.
     *
     * @param  mixed $cep
     * @return mixed
    */
    public static function sanitize($cep)
    {
        $cep = strip_tags($cep);
        return substr(filter_var($cep, FILTER_SANITIZE_NUMBER_INT), 0, 5) . '-' .
               substr(filter_var($cep, FILTER_SANITIZE_NUMBER_INT), 6, 3);
    }

    /**
     * Test if the CEP is masked.
     *
     * This method just call self::isValid.
     *
     * @param  mixed $cep
     * @return bool
     */
    public static function isMasked($cep)
    {
        return self::isValid($cep);
    }

    /**
     * Mask the CEP.
     *
     * @param  mixed $cep
     * @return mixed
    */
    public static function mask($cep)
    {
        $cep = trim($cep);
        return (string)substr($cep, 0, 5) . '-' . substr($cep, 5, 7);
    }

    /**
     * Unmask the CEP.
     *
     * @param  mixed $cep
     * @return mixed
    */
    public static function unMask($cep)
    {
        return str_replace('-', '', trim($cep));
    }
}
