<?php
/**
 * @category Tests
 * @package Tbs
 * @subpackage Helper
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */

namespace Tbs\Log;
use \Tbs\Log\File     as Log;
use \Tbs\Log\LogLevel as Level;
require_once dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR . 'Bootstrap.php';

/**
 * @category Tests
 * @package Tbs
 * @subpackage Helper
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */
class FileTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Tbs\Log\File
     */
    protected $object = null;

    /**
     * @var string
     */
    protected $logfile = null;

    /**
     * Setup.
     */
    protected function setUp()
    {
        $this->logfile = sprintf('%s/test.log', STUFF_PATH);
    	$this->object  = new Log($this->logfile);
    }

    /**
     * TearDown.
     */
    protected function tearDown()
    {
        @unlink($this->logfile);
    	unset($this->object);
    }

    /**
     * Test if implements the right interface.
     */
    public function testInterface()
    {
        $this->assertInstanceOf('\Tbs\Log\Interfaces\LoggerInterface', $this->object);
    }

    /**
     * @see \Tbs\Log\File::__construct()
     */
    public function testLogFileExists()
    {
        $this->assertTrue(file_exists($this->logfile));
    }

    /**
     * @see \Tbs\Log\File::__construct()
     */
    public function testLogFileIsWritable()
    {
        $this->assertTrue(is_writable($this->logfile));
    }

    /**
     * Provider of log messages.
     * @return array
     */
    public function providerLogMessages()
    {
        return array(
        	array('this is a log message', Level::EMERGENCY),
            array('this is a log message', Level::ALERT),
            array('this is a log message', Level::CRITICAL),
            array('this is a log message', Level::ERROR),
            array('this is a log message', Level::WARNING),
            array('this is a log message', Level::NOTICE),
            array('this is a log message', Level::INFO),
            array('this is a log message', Level::DEBUG),
        );
    }

    /**
     * @see \Tbs\Log\File::log()
     * @dataProvider providerLogMessages
     */
    public function testLogOneLine($message, $level)
    {
        $line = sprintf('%s [%s]: %s', date('Y-m-d H:i:s'), strtoupper($level), $message) . "\n";
        $this->object->log($level, $message);
        $rs = file_get_contents($this->logfile);
        $this->assertEquals($line, $rs);
    }

    /**
     * @see \Tbs\Log\File::emergency()
     * @dataProvider providerLogMessages
     */
    public function testLogLevelOneLine($message, $level)
    {
        $line = sprintf('%s [%s]: %s', date('Y-m-d H:i:s'), strtoupper($level), $message) . "\n";
        $this->object->{$level}($message);
        $rs = file_get_contents($this->logfile);
        $this->assertEquals($line, $rs);
    }

    /**
     * @see \Tbs\Log\File::log()
     * @dataProvider providerLogMessages
     */
    public function testLogMultiLines($message, $level)
    {
        $total = rand(5,10);
        for ($i = 1; $i <= $total; $i++) {
            $line = sprintf('%s [%s]: %s', date('Y-m-d H:i:s'), strtoupper($level), $message) . "\n";
            $this->object->log($level, $message . "($i)");
        }

        $rs    = file_get_contents($this->logfile);
        $lines = @explode("\n", $rs);
        $this->assertEquals($total+1, count($lines));

        foreach ($lines as $line) {
            if (strlen($line)) {
                $regexp = '/^' . date('Y-m-d H:i:s') . ' \['.strtoupper($level).'\]: this is a log message\([0-9]{1,2}\)$/';
                $this->assertRegExp($regexp, $line);
            }
        }
    }

    /**
     * @see \Tbs\Log\File::log()
     * @dataProvider providerLogMessages
     */
    public function testLogLevelMultiLines($message, $level)
    {
        $total = rand(5,10);
        for ($i = 1; $i <= $total; $i++) {
            $line = sprintf('%s [%s]: %s', date('Y-m-d H:i:s'), strtoupper($level), $message) . "\n";
            $this->object->{$level}($message . "($i)");
        }

        $rs    = file_get_contents($this->logfile);
        $lines = @explode("\n", $rs);
        $this->assertEquals($total+1, count($lines));

        foreach ($lines as $line) {
            if (strlen($line)) {
                $regexp = '/^' . date('Y-m-d H:i:s') . ' \['.strtoupper($level).'\]: this is a log message\([0-9]{1,2}\)$/';
                $this->assertRegExp($regexp, $line);
            }
        }
    }

    /**
     * @see \Tbs\Log\File::log()
     * @dataProvider providerLogMessages
     */
    public function testLogInterpolate($message, $level)
    {
        $message .= ' with tags: {tag1} {tag2} {tag3}';
        $line     = sprintf('%s [%s]: %s', date('Y-m-d H:i:s'), strtoupper($level), $message) . "\n";
        $context  = array(
        	'tag1' => 'this is a tag1 context',
            'tag2' => 'this is a tag2 context',
            'tag3' => 'this is a tag3 context',
        );

        $this->object->log($level, $message, $context);
        $rs = file_get_contents($this->logfile);

        $newmess = 'this is a log message with tags: this is a tag1 context this is a tag2 context this is a tag3 context';
        $newline = sprintf('%s [%s]: %s', date('Y-m-d H:i:s'), strtoupper($level), $newmess) . "\n";

        $this->assertEquals($newline, $rs);
    }

    /**
     * @see \Tbs\Log\File::log()
     * @dataProvider providerLogMessages
     */
    public function testLogLevelInterpolate($message, $level)
    {
        $message .= ' with tags: {tag1} {tag2} {tag3}';
        $line     = sprintf('%s [%s]: %s', date('Y-m-d H:i:s'), strtoupper($level), $message) . "\n";
        $context  = array(
            'tag1' => 'this is a tag1 context',
            'tag2' => 'this is a tag2 context',
            'tag3' => 'this is a tag3 context',
        );

        $this->object->{$level}($message, $context);
        $rs = file_get_contents($this->logfile);

        $newmess = 'this is a log message with tags: this is a tag1 context this is a tag2 context this is a tag3 context';
        $newline = sprintf('%s [%s]: %s', date('Y-m-d H:i:s'), strtoupper($level), $newmess) . "\n";

        $this->assertEquals($newline, $rs);
    }
}
