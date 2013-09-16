<?php
/**
 * @package Tbs\ZfComponents\V1\Controller
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */

namespace Tbs\ZfComponents\V1\Controller;

/**
 * Base controller class for public pages.
 *
 * @package Tbs\ZfComponents\V1\Controller
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */
abstract class PublicPage extends \Zend_Controller_Action
{
    /**
     * Full URL.
     * @var string
     */
    protected $url = null;

    /**
     * Zend_Log instance.
     * @var Zend_Log
     */
    protected $log = null;

    /**
     * Primary configuration.
     *
     * This method run before of the "init"
     * method of the application controllers.
     *
     * @see \Zend_Controller_Action::preDispatch()
     */
    public function preDispatch()
    {
        //Init URL.
        $this->url = sprintf(
            '%s://%s%s',
            $this->_request->getScheme(),
            $this->_request->getHttpHost(),
            $this->_request->getRequestUri()
        );

        //Init log.
        $this->log = Zend_Registry::get('log');

        //Info of current page.
        $this->view->module     = $this->_request->getModuleName();
        $this->view->controller = $this->_request->getControllerName();
        $this->view->action     = $this->_request->getActionName();
    }

    /**
     * Get a route param with a default value for blank
     *
     * @param string $name Route param
     * @param mixed $default Default value.
     *
     * @return mixed
     */
    public function getParam($name, $default = null)
    {
        $value = $this->_getParam($name);
        return (strpos($value, ':') === 0) ? $default : $value;
    }

    /**
     * Set a header to XML.
     *
     * @param  string $charset
     * @return \Zend_Controller_Action_Interface
     */
    protected function setHeaderAsXml($charset = null)
    {
        $this->setHeader('text/xml', $charset);
        return $this;
    }

    /**
     * Set a header to HTML.
     *
     * @param  string $charset
     * @return \Zend_Controller_Action_Interface
     */
    protected function setHeaderAsHtml($charset = null)
    {
        $this->setHeader('text/html', $charset);
        return $this;
    }

    /**
     * Change a header of page.
     *
     * @param string $header
     * @param string $charset
     *
     * @return \Zend_Controller_Action_Interface
     */
    protected function setHeader($type, $charset = null)
    {
        $charset = strlen($charset) ? (string)$charset : Bootstrap::$charset;
        header(sprintf('Content-Type: %s; charset=%s', $type, $charset));
        return $this;
    }

    /**
     * Disable layout render.
     * @return \Zend_Controller_Action_Interface
     */
    protected function setNoLayout()
    {
        $this->_helper->layout()->disableLayout();
        return $this;
    }

    /**
     * Disable view render.
     * @return \Zend_Controller_Action_Interface
     */
    protected function setNoView()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        return $this;
    }
}
