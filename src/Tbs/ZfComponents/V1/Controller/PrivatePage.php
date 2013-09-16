<?php
/**
 * @package Tbs\ZfComponents\V1\Controller
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */

namespace Tbs\ZfComponents\V1\Controller;

use \Tbs\ZfComponents\V1\Controller\PublicPage;

/**
 * Base controller class for private pages.
 *
 * @package Tbs\ZfComponents\V1\Controller
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */
abstract class PrivatePage extends PublicPage
{
    /**
     * Primary configuration of authenticated page.
     * @see \Tbs\Controller\PublicPage::preDispatch()
     */
    public function preDispatch()
    {
        parent::preDispatch();
    }
}
