<?php
/**
 * CodeIgniter.
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2014 - 2019, British Columbia Institute of Technology
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @author	EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc. (https://ellislab.com/)
 * @copyright	Copyright (c) 2014 - 2019, British Columbia Institute of Technology (https://bcit.ca/)
 * @license	https://opensource.org/licenses/MIT	MIT License
 *
 * @link	https://codeigniter.com
 * @since	Version 2.1.0
 * @filesource
 */
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * CUBRID Database Adapter Class.
 *
 * Note: _DB is an extender class that the app controller
 * creates dynamically based on whether the query builder
 * class is being used or not.
 *
 * @category	Database
 *
 * @author		Esen Sagynov
 *
 * @link		https://codeigniter.com/user_guide/database/
 */
class CI_DB_cubrid_driver extends CI_DB
{
    /**
     * Database driver.
     *
     * @var string
     */
    public $dbdriver = 'cubrid';

    /**
     * Auto-commit flag.
     *
     * @var bool
     */
    public $auto_commit = true;

    // --------------------------------------------------------------------

    /**
     * Identifier escape character.
     *
     * @var string
     */
    protected $_escape_char = '`';

    /**
     * ORDER BY random keyword.
     *
     * @var array
     */
    protected $_random_keyword = ['RANDOM()', 'RANDOM(%d)'];

    // --------------------------------------------------------------------

    /**
     * Class constructor.
     *
     * @param array $params
     *
     * @return void
     */
    public function __construct($params)
    {
        parent::__construct($params);

        if (preg_match('/^CUBRID:[^:]+(:[0-9][1-9]{0,4})?:[^:]+:[^:]*:[^:]*:(\?.+)?$/', $this->dsn, $matches)) {
            if (stripos($matches[2], 'autocommit=off') !== false) {
                $this->auto_commit = false;
            }
        } else {
            // If no port is defined by the user, use the default value
            empty($this->port) or $this->port = 33000;
        }
    }

    // --------------------------------------------------------------------

    /**
     * Non-persistent database connection.
     *
     * @param bool $persistent
     *
     * @return resource
     */
    public function db_connect($persistent = false)
    {
        if (preg_match('/^CUBRID:[^:]+(:[0-9][1-9]{0,4})?:[^:]+:([^:]*):([^:]*):(\?.+)?$/', $this->dsn, $matches)) {
            $func = ($persistent !== true) ? 'cubrid_connect_with_url' : 'cubrid_pconnect_with_url';

            return ($matches[2] === '' && $matches[3] === '' && $this->username !== '' && $this->password !== '')
                ? $func($this->dsn, $this->username, $this->password)
                : $func($this->dsn);
        }

        $func = ($persistent !== true) ? 'cubrid_connect' : 'cubrid_pconnect';

        return ($this->username !== '')
            ? $func($this->hostname, $this->port, $this->database, $this->username, $this->password)
            : $func($this->hostname, $this->port, $this->database);
    }

    // --------------------------------------------------------------------

    /**
     * Reconnect.
     *
     * Keep / reestablish the db connection if no queries have been
     * sent for a length of time exceeding the server's idle timeout
     *
     * @return void
     */
    public function reconnect()
    {
        if (cubrid_ping($this->conn_id) === false) {
            $this->conn_id = false;
        }
    }

    // --------------------------------------------------------------------

    /**
     * Database version number.
     *
     * @return string
     */
    public function version()
    {
        if (isset($this->data_cache['version'])) {
            return $this->data_cache['version'];
        }

        return (!$this->conn_id or ($version = cubrid_get_server_info($this->conn_id)) === false)
            ? false
            : $this->data_cache['version'] = $version;
    }

    // --------------------------------------------------------------------

    /**
     * Execute the query.
     *
     * @param string $sql an SQL query
     *
     * @return resource
     */
    protected function _execute($sql)
    {
        return cubrid_query($sql, $this->conn_id);
    }

    // --------------------------------------------------------------------

    /**
     * Begin Transaction.
     *
     * @return bool
     */
    protected function _trans_begin()
    {
        if (($autocommit = cubrid_get_autocommit($this->conn_id)) === null) {
            return false;
        } elseif ($autocommit === true) {
            return cubrid_set_autocommit($this->conn_id, CUBRID_AUTOCOMMIT_FALSE);
        }

        return true;
    }

    // --------------------------------------------------------------------

    /**
     * Commit Transaction.
     *
     * @return bool
     */
    protected function _trans_commit()
    {
        if (!cubrid_commit($this->conn_id)) {
            return false;
        }

        if ($this->auto_commit && !cubrid_get_autocommit($this->conn_id)) {
            return cubrid_set_autocommit($this->conn_id, CUBRID_AUTOCOMMIT_TRUE);
        }

        return true;
    }

    // --------------------------------------------------------------------

    /**
     * Rollback Transaction.
     *
     * @return bool
     */
    protected function _trans_rollback()
    {
        if (!cubrid_rollback($this->conn_id)) {
            return false;
        }

        if ($this->auto_commit && !cubrid_get_autocommit($this->conn_id)) {
            cubrid_set_autocommit($this->conn_id, CUBRID_AUTOCOMMIT_TRUE);
        }

        return true;
    }

    // --------------------------------------------------------------------

    /**
     * Platform-dependent string escape.
     *
     * @param	string
     *
     * @return string
     */
    protected function _escape_str($str)
    {
        return cubrid_real_escape_string($str, $this->conn_id);
    }

    // --------------------------------------------------------------------

    /**
     * Affected Rows.
     *
     * @return int
     */
    public function affected_rows()
    {
        return cubrid_affected_rows();
    }

    // --------------------------------------------------------------------

    /**
     * Insert ID.
     *
     * @return int
     */
    public function insert_id()
    {
        return cubrid_insert_id($this->conn_id);
    }

    // --------------------------------------------------------------------

    /**
     * List table query.
     *
     * Generates a platform-specific query string so that the table names can be fetched
     *
     * @param bool $prefix_limit
     *
     * @return string
     */
    protected function _list_tables($prefix_limit = false)
    {
        $sql = 'SHOW TABLES';

        if ($prefix_limit !== false && $this->dbprefix !== '') {
            return $sql." LIKE '".$this->escape_like_str($this->dbprefix)."%'";
        }

        return $sql;
    }

    // --------------------------------------------------------------------

    /**
     * Show column query.
     *
     * Generates a platform-specific query string so that the column names can be fetched
     *
     * @param string $table
     *
     * @return string
     */
    protected function _list_columns($table = '')
    {
        return 'SHOW COLUMNS FROM '.$this->protect_identifiers($table, true, null, false);
    }

    // --------------------------------------------------------------------

    /**
     * Returns an object with field data.
     *
     * @param string $table
     *
     * @return array
     */
    public function field_data($table)
    {
        if (($query = $this->query('SHOW COLUMNS FROM '.$this->protect_identifiers($table, true, null, false))) === false) {
            return false;
        }
        $query = $query->result_object();

        $retval = [];
        for ($i = 0, $c = count($query); $i < $c; $i++) {
            $retval[$i] = new stdClass();
            $retval[$i]->name = $query[$i]->Field;

            sscanf($query[$i]->Type, '%[a-z](%d)',
                $retval[$i]->type,
                $retval[$i]->max_length
            );

            $retval[$i]->default = $query[$i]->Default;
            $retval[$i]->primary_key = (int) ($query[$i]->Key === 'PRI');
        }

        return $retval;
    }

    // --------------------------------------------------------------------

    /**
     * Error.
     *
     * Returns an array containing code and message of the last
     * database error that has occurred.
     *
     * @return array
     */
    public function error()
    {
        return ['code' => cubrid_errno($this->conn_id), 'message' => cubrid_error($this->conn_id)];
    }

    // --------------------------------------------------------------------

    /**
     * FROM tables.
     *
     * Groups tables in FROM clauses if needed, so there is no confusion
     * about operator precedence.
     *
     * @return string
     */
    protected function _from_tables()
    {
        if (!empty($this->qb_join) && count($this->qb_from) > 1) {
            return '('.implode(', ', $this->qb_from).')';
        }

        return implode(', ', $this->qb_from);
    }

    // --------------------------------------------------------------------

    /**
     * Close DB Connection.
     *
     * @return void
     */
    protected function _close()
    {
        cubrid_close($this->conn_id);
    }
}
