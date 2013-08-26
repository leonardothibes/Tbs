<?php
/**
 * @category Library
 * @package Tbs
 * @subpackage Html
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */

namespace Tbs;

use \Tbs\Html\Interfaces\Renderable;

/**
 * HTML Generator Class.
 *
 * @category Library
 * @package Tbs
 * @subpackage Html
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */
class Html implements Renderable
{
    /**
     * HTML rendered string.
     * @var string
     */
    protected $html = null;

    /**
     * Render HTML of element.
     * @return string
     */
    public function render()
    {
        return $this->html;
    }

    /**
     * Target to $this->render method.
     * @return string
     */
    public function __toString()
    {
        return $this->render();
    }
}
