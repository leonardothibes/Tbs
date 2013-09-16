<?php
/**
 * @package Tbs\Html\Interfaces
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */

namespace Tbs\Html\Interfaces;

/**
 * Interface for HTML generation classes.
 *
 * @package Tbs\Html\Interfaces
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */
interface Renderable
{
    /**
     * Render HTML of element.
     * @return string
     */
    public function render();
}
