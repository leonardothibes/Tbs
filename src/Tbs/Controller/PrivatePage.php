<?php
/**
 * @category Library
 * @package Tbs
 * @subpackage Controller
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */

namespace Tbs\Controller;

/**
 * Base controller class for private pages.
 *
 * @category Library
 * @package Tbs
 * @subpackage Controller
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */
abstract class PrivatePage extends \Tbs\Controller\PublicPage
{
    /**
     * Primary configuration of authenticated page.
     * @see Tbs\Controller\PublicPage::preDispatch()
     */
    public function preDispatch()
    {
        parent::preDispatch();
    }
}
