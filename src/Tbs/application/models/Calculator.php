<?php

namespace Phpskel;

/**
 * Calculator class.
 */
class Calculator
{
    /**
     * Sum two values.
     *
     * @param int $v1
     * @param int $v2
     *
     * @return int
     * @throws \Exception
     */
    public function add($v1, $v2)
    {
        if (!is_int($v1) or !is_int($v2)) {
            throw new \Exception('Invalid params');
        }
        return $v1 + $v2;
    }
}
