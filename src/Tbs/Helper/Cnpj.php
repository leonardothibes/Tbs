<?php
/**
 * @package Tbs\Helper
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */

namespace Tbs\Helper;

use \Tbs\Helper\Interfaces\Mask     as M;
use \Tbs\Helper\Interfaces\Validate as V;

/**
 * CNPJ helper functions.
 *
 * @package Tbs\Helper
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */
class Cnpj implements M, V
{
    /**
     * Test if CNPJ is valid.
     *
     * @param  string $cnpj
     * @return bool
     */
    public static function isValid($cnpj)
    {
        $cnpj = str_pad(str_replace(array('.', '-', '/'), '', $cnpj), 14, '0', STR_PAD_LEFT);
        if (strlen($cnpj) != 14) {
            return false;
        }
        for ($t = 12; $t < 14; $t++) {
            for ($d = 0, $p = $t - 7, $c = 0; $c < $t; $c++) {
                $d += $cnpj{$c} * $p;
                $p  = ($p < 3) ? 9 : --$p;
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cnpj{$c} != $d) {
                return false;
            }
        }
        return true;
    }

    /**
     * Sanitize the CNPJ.
     *
     * @param  string $cnpj
     * @return string
    */
    public static function sanitize($cnpj)
    {
        $sanitized = filter_var(strip_tags(self::unMask($cnpj)), FILTER_SANITIZE_NUMBER_INT);
        return self::mask($sanitized);
    }

    /**
     * Test if the CNPJ is masked.
     *
     * @param  string $cnpj
     * @return bool
     */
    public static function isMasked($cnpj)
    {
        return (bool)preg_match('/^[0-9]{2}\.[0-9]{3}\.[0-9]{3}\/[0-9]{4}\-[0-9]{2}$/', $cnpj);
    }

    /**
     * Mask the CNPJ.
     *
     * @param  string $cnpj
     * @return string
    */
    public static function mask($cnpj)
    {
        if (self::isMasked($cnpj)) {
            return $cnpj;
        }
        return substr($cnpj, 0, 2)  . '.' .
               substr($cnpj, 2, 3)  . '.' .
               substr($cnpj, 5, 3)  . '/' .
               substr($cnpj, 8, 4)  . '-' .
               substr($cnpj, 12, 2);
    }

    /**
     * Unmask the CNPJ.
     *
     * @param  string $cnpj
     * @return string
    */
    public static function unMask($cnpj)
    {
        return (string)str_replace(array('.', '/', '-'), '', trim($cnpj));
    }

    /**
     * Generates a random number of CNPJ valid.
     *
     * @param bool $mask
     * @return string
     */
    public static function random($mask = false)
    {
        //Gerando os 12 primeiros números.
        $n1  = rand(0, 9);
        $n2  = rand(0, 9);
        $n3  = rand(0, 9);
        $n4  = rand(0, 9);
        $n5  = rand(0, 9);
        $n6  = rand(0, 9);
        $n7  = rand(0, 9);
        $n8  = rand(0, 9);
        $n9  = 0;
        $n10 = 0;
        $n11 = 0;
        $n12 = rand(1, 9);
        //Gerando os 12 primeiros números.

        //Calculando o primeiro dígido verificador.
        $d1 = $n12*2+$n11*3+$n10*4+$n9*5+$n8*6+$n7*7+$n6*8+$n5*9+$n4*2+$n3*3+$n2*4+$n1*5;
        $d1 = 11 - ($d1 % 11);
        if ($d1 >= 10) {
            $d1 = 0;
        }

        //Calculando o segundo dígito verificador.
        $d2 = $d1*2+$n12*3+$n11*4+$n10*5+$n9*6+$n8*7+$n7*8+$n6*9+$n5*2+$n4*3+$n3*4+$n2*5+$n1*6;
        $d2 = 11 - ($d2 % 11);
        if ($d2 >= 10) {
            $d2 = 0;
        }

        //Formando o CNPJ completo.
        $cnpj = $n1.$n2.$n3.$n4.$n5.$n6.$n7.$n8.$n9.$n10.$n11.$n12.$d1.$d2;

        //Mascarando o CNPJ, se for o caso.
        return (string)($mask === true) ? self::mask($cnpj) : $cnpj;
    }
}
