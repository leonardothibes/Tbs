<?php
/**
 * @category Tests
 * @package Tbs
 * @subpackage Helper
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */

namespace Tbs\Helper;
use \Tbs\Helper\Email as email;
require_once dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR . 'Bootstrap.php';

/**
 * @category Tests
 * @package Tbs
 * @subpackage Helper
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */
class EmailTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Tbs\Helper\Email
     */
    protected $object = null;

    /**
     * Setup.
     */
    protected function setUp()
    {
    	$this->object = new email;
    }

    /**
     * TearDown.
     */
    protected function tearDown()
    {
    	unset($this->object);
    }

    /**
     * Test if implements the right interface.
     */
    public function testInterface()
    {
        $this->assertInstanceOf('\Tbs\Helper\Interfaces\Validate', $this->object);
    }

    /**
     * Provider of valid e-mails.
     * @return array
     */
    public function providerValidEmails()
    {
        return array(
        	array('eu@leonardothibes.com'),
            array('lthibes@lidercap.com.br'),
            array('leonardothibes@yahoo.com.br'),
        );
    }

    /**
     * @see \Tbs\Helper\Email::domainIsValid()
     * @dataProvider providerValidEmails
     */
    public function testEmailIsValid($email)
    {
        $rs = email::domainIsValid($email);
        $this->assertTrue($rs);
    }

    /**
     * @see \Tbs\Helper\Email::domainIsValid()
     * @dataProvider providerValidEmails
     */
    public function testDomainIsValid($email)
    {
        list($login, $domain) = @explode('@', $email);
        $rs = email::domainIsValid($domain);
        $this->assertTrue($rs);
    }

    /**
     * @see \Tbs\Helper\Email::domainIsValid()
     * @dataProvider providerValidEmails
     */
    public function testDomainIsInValid($email)
    {
        $rs = email::domainIsValid($email . '.me');
        $this->assertFalse($rs);
    }

    /**
     * @see \Tbs\Helper\Email::isValid()
     * @dataProvider providerValidEmails
     */
    public function testIsValid($email)
    {
        $rs = email::isValid($email);
        $this->assertTrue($rs);
    }

    /**
     * @see \Tbs\Helper\Email::isValid()
     * @dataProvider providerValidEmails
     */
    public function testIsInValidNotEmail($email)
    {
        list($login, $domain) = @explode('@', $email);
        $rs = email::isValid($email);
        $this->assertTrue($rs);
    }

    /**
     * @see \Tbs\Helper\Email::isValid()
     * @dataProvider providerValidEmails
     */
    public function testIsInValidEmail($email)
    {
        $rs = email::isValid($email . rand(1,10));
        $this->assertTrue($rs);
    }

    /**
     * @see \Tbs\Helper\Email::sanitize()
     * @dataProvider providerValidEmails
     */
    public function testSanitizeEquals($email)
    {
        $rs = email::sanitize($email);
        $this->assertEquals($email, $rs);
    }

    /**
     * @see \Tbs\Helper\Email::sanitize()
     * @dataProvider providerValidEmails
     */
    public function testSanitizeTags($email)
    {
        $rs = email::sanitize($email . '<script>alert("some content");</script>');
        $this->assertEquals($email . 'scriptalertsomecontentscript', $rs);
    }
}
