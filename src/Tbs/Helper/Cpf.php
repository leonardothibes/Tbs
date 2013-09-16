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
 * CPF helper functions.
 *
 * @package Tbs\Helper
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */
class Cpf implements M, V
{
    /**
     * Test if CPF is valid.
     *
     * @param  string $cpf
     * @return bool
     */
    public static function isValid($cpf)
    {
        //Retirando a máscara.
        $cpf = self::unMask($cpf);

        //Se houverem letras no CPF então já retorna false direto.
        if (!is_numeric($cpf)) {
            return false;
        }

        //Verificando combinações inválidas de CPF.
        $nulos = array(
            '12345678909','11111111111','22222222222','33333333333',
            '44444444444','55555555555','66666666666','77777777777',
            '88888888888','99999999999','00000000000'
        );
        if (in_array($cpf, $nulos)) {
            return false;
        }
        //Verificando combinações inválidas de CPF.

        //Calculando o primeiro dígito verificador.
        $acum = 0;
        for ($i = 0; $i < 9; $i++) {
            $acum += $cpf[$i] * (10-$i);
        }

        $x = $acum % 11;
        $acum = ($x > 1) ? (11 - $x) : 0;

        if ($acum != $cpf[9]) {
            return false;
        }
        //Calculando o primeiro dígito verificador.

        //Calcula o segundo dígito verificador.
        $acum = 0;
        for ($i = 0; $i < 10; $i++) {
            $acum += $cpf[$i] * (11 - $i);
        }

        $x = $acum % 11;
        $acum = ($x > 1) ? (11 - $x) : 0;

        if ($acum != $cpf[10]) {
            return false;
        }
        //Calcula o segundo dígito verificador.

        //Retorna verdadeiro se o cpf é válido.
        return true;
    }

    /**
     * Sanitize the CPF.
     *
     * @param  string $cpf
     * @return mixed
    */
    public static function sanitize($cpf)
    {
        $cpf = strip_tags($cpf);
        return filter_var($cpf, FILTER_SANITIZE_STRING);
    }

    /**
     * Test if the CPF is masked.
     *
     * @param  string $cpf
     * @return bool
     */
    public static function isMasked($cpf)
    {
        return (bool)preg_match('/^[0-9]{3}\.[0-9]{3}\.[0-9]{3}\-[0-9]{2}$/', $cpf);
    }

    /**
     * Mask the CPF.
     *
     * @param  string $cpf
     * @return mixed
    */
    public static function mask($cpf)
    {
        $cpf = trim($cpf);
        $cpf = substr($cpf, 0, 3)  . '.' . substr($cpf, 3, 10);
        $cpf = substr($cpf, 0, 7)  . '.' . substr($cpf, 7, 12);
        $cpf = substr($cpf, 0, 11) . '-' . substr($cpf, 11, 12);
        return (string)$cpf;
    }

    /**
     * Unmask the CPF.
     *
     * @param  string $cpf
     * @return mixed
    */
    public static function unMask($cpf)
    {
        return (string)str_replace(array('.', '-'), '', trim($cpf));
    }

    /**
     * Generates a random number of CPF valid.
     *
     * @param bool $mask
     * @return string
     */
    public static function random($mask = false)
    {
        //Gerando os 9 primeiros números.
        $n1 = rand(0, 9);
        $n2 = rand(0, 9);
        $n3 = rand(0, 9);
        $n4 = rand(0, 9);
        $n5 = rand(0, 9);
        $n6 = rand(0, 9);
        $n7 = rand(0, 9);
        $n8 = rand(0, 9);
        $n9 = rand(0, 9);
        //Gerando os 9 primeiros números.

        //Calculando o primeiro dígido verificador.
        $d1 = $n9*2+$n8*3+$n7*4+$n6*5+$n5*6+$n4*7+$n3*8+$n2*9+$n1*10;
        $d1 = 11 - ($d1 % 11);
        if ($d1 >= 10) {
            $d1 = 0;
        }

        //Calculando o segundo dígito verificador.
        $d2 = $d1*2+$n9*3+$n8*4+$n7*5+$n6*6+$n5*7+$n4*8+$n3*9+$n2*10+$n1*11;
        $d2 = 11 - ($d2 % 11);
        if ($d2 >= 10) {
            $d2 = 0;
        }

        //Formando o CPF completo.
        $cpf = $n1.$n2.$n3.$n4.$n5.$n6.$n7.$n8.$n9.$d1.$d2;

        //Mascarando o CPF, se for o caso.
        return (string)($mask === true) ? self::mask($cpf) : $cpf;
    }
}
