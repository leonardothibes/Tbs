<?php
/**
 * @package Tbs\ZfComponents\V1\Db
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */

namespace Tbs\ZfComponents\V1\Db;

/**
 * Database Tables Abstraction
 *
 * @package Tbs\ZfComponents\V1\Db
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */
abstract class TableAbstraction extends \Zend_Db_Table_Abstract
{
    /**
     * Get the table name.
     * @return string
     */
    public function getTableName()
    {
        return $this->_name;
    }

    /**
     * Get the primary key(s) name(s).
     * @return string|array
     */
    public function getTablePrimary()
    {
        return $this->_primary;
    }
}
