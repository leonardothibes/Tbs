<?php
/**
 * @category Tests
 * @package Tbs
 * @subpackage DockBlock
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */

namespace Tbs;

/**
 * @category Tests
 * @package Tbs
 * @subpackage DockBlock
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */
class StuffClass
{
    /**
     * Stuff property.
     * @var string
     */
    protected $stuffProperty = 'this is a stuff property';

    /**
     * Short description.
     *
     * This is a long description.
     *
     * @param string $param1 This is a first param.
     * @param int    $param2 This is a seccond param.
     *
     * @return array This is a return.
     * @throws \Exception
     */
    public function stuffMethod1($param1, $param2)
    {
        return array('___|\___\o/___help!!! Its a shark!!!');
    }
}
