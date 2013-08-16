<?php
/**
 * @category Library
 * @package Tbs
 * @subpackage Log
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */

namespace Tbs\Log;

/**
 * Describes a logger-aware instance.
 *
 * @category Library
 * @package Tbs
 * @subpackage Log
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 * @link <http://www.php-fig.org/psr/3/>
 */
interface LoggerAwareInterface
{
    /**
     * Sets a logger instance on the object
     *
     * @param  LoggerInterface $logger
     * @return void
     */
    public function setLogger(LoggerInterface $logger);
}
