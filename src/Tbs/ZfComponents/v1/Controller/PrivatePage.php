<?php
/**
 * @category Library
 * @package Tbs
 * @subpackage ZfComponents
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */

namespace Tbs\ZfComponents\v1\Controller;

use Tbs\ZfComponents\v1\Controller\PublicPage as PublicPage;

/**
 * Base controller class for private pages.
 *
 * @category Library
 * @package Tbs
 * @subpackage ZfComponents
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
