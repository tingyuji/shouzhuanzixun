<?php

// constants used by class
define('MYSQLI_TYPES_NUMERIC', 'int real ');
define('MYSQLI_TYPES_DATE', 'datetime timestamp year date time ');
define('MYSQLI_TYPES_STRING', 'string blob ');

class database {

    var $last_error;         // holds the last error. Usually mysqli_error()
    var $last_query;         // holds the last query executed.
    var $row_count;          // holds the last number of rows from a select
    protected $host;               // mySQL host to connect to
    protected $username;           // mySQL user name
    protected $password;           // mySQL password
    protected $database;           // mySQL database to select
    protected $db_link;            // current/last database link identifier
    protected $auto_slashes;       // the class will add/strip slashes when it can

    function __construct() {
        // class constructor.  Initializations here.
        // Setup your own default values for connecting to the database here. You
        // can also set these values in the connect() function and using
        // the select_database() function.

        $this->host = '';
        $this->username = '';
        $this->password = '';
        $this->database = '';

        $this->auto_slashes = true;
    }

    function connect($host = '', $user = '', $pw = '', $db = '', $persistant = true) {

        // Opens a connection to MySQL and selects the database.  If any of the
        // function's parameter's are set, we want to update the class variables.  
        // If they are NOT set, then we're giong to use the currently existing
        // class variables.
        // Returns true if successful, false if there is failure.  

        if (!empty($host))
            $this->host = $host;
        if (!empty($user))
            $this->username = $user;
        if (!empty($pw))
            $this->password = $pw;
        if (!empty($db))
            $this->database = $db;


        // Establish the connection.
//      if ($persistant) 
//         $this->db_link = mysql_pconnect($this->host, $this->username, $this->password);
//      else 
        $this->db_link = @new mysqli($this->host, $this->username, $this->password);
        if ($this->db_link->connect_error) {
            die('不能连接MySQL. Error: ' . $this->db_link->connect_error);
        }

        $this->db_link->set_charset('UTF-8');
        // Check for an error establishing a connection
        if (!$this->db_link) {
            $this->last_error = $this->db_link->error;
            return false;
        }

        // Select the database
        if (!$this->select_db($db))
            return false;

        return $this->db_link;  // success
    }

    function real_escape_string($str) {
        return $this->db_link->real_escape_string($str);
    }

    function select_db($db = '') {

        // Selects the database for use.  If the function's $db parameter is 
        // passed to the function then the class variable will be updated.

        if (!empty($db))
            $this->database = $db;

        if (!$this->db_link->select_db($this->database)) {
            $this->last_error = $this->db_link->error;
            return false;
        }

        return true;
    }

    function select($sql) {

        // Performs an SQL query and returns the result pointer or false
        // if there is an error.

        $this->last_query = $sql;
        $r = $this->db_link->query($sql);
        if (!$r) {
            $this->row_count = 0;
            $this->last_error = $this->db_link->error;
            return false;
        }
        if ($r === true) {
            return true;
        }

        $this->row_count = $r->num_rows;
        return $r;
    }

    function select_one($sql) {

        // Performs an SQL query with the assumption that only ONE column and
        // one result are to be returned.
        // Returns the one result.

        $this->last_query = $sql;

        $r = $this->db_link->query($sql);
        if (!$r) {
            $this->last_error = $this->db_link->error;
            return false;
        }
        if ($r->num_rows > 1) {
            $this->last_error = "Your query in function select_one() returned more that one result.";
            return false;
        }
        if ($r->num_rows < 1) {
            $this->last_error = "Your query in function select_one() returned no results.";
            return false;
        }

        $ret = $r->fetch_array(MYSQLI_BOTH);

        /* free result set */
        $r->close();
        if ($this->auto_slashes)
            return stripslashes($ret);
        else
            return $ret;
    }

    function get_row($result, $type = 'MYSQLI_BOTH') {

        // Returns a row of data from the query result.  You would use this
        // function in place of something like while($row=mysqli_fetch_array($r)). 
        // Instead you would have while($row = $db->get_row($r)) The
        // main reason you would want to use this instead is to utilize the
        // auto_slashes feature.

        if (!$result) {
            $this->last_error = "Invalid resource identifier passed to get_row() function.";
            return false;
        }

        if ($type == 'MYSQLI_ASSOC')
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        if ($type == 'MYSQLI_NUM')
            $row = mysqli_fetch_array($result, MYSQLI_NUM);
        if ($type == 'MYSQLI_BOTH')
            $row = mysqli_fetch_array($result, MYSQLI_BOTH);

        if (!$row)
            return false;
        if ($this->auto_slashes) {
            // strip all slashes out of row...
            foreach ($row as $key => $value) {
                $row[$key] = stripslashes($value);
            }
        }
        return $row;
    }

    function dump_query($sql) {

        // Useful during development for debugging  purposes.  Simple dumps a 
        // query to the screen in a table.

        $r = $this->select($sql);
        if (!$r)
            return false;
        echo "<div style=\"border: 1px solid blue; font-family: sans-serif; margin: 8px;\">\n";
        echo "<table cellpadding=\"3\" cellspacing=\"1\" border=\"0\" width=\"100%\">\n";

        $i = 0;
        while ($row = mysqli_fetch_assoc($r)) {
            if ($i == 0) {
                echo "<tr><td colspan=\"" . sizeof($row) . "\"><span style=\"font-face: monospace; font-size: 9pt;\">$sql</span></td></tr>\n";
                echo "<tr>\n";
                foreach ($row as $col => $value) {
                    echo "<td bgcolor=\"#E6E5FF\"><span style=\"font-face: sans-serif; font-size: 9pt; font-weight: bold;\">$col</span></td>\n";
                }
                echo "</tr>\n";
            }
            $i++;
            if ($i % 2 == 0)
                $bg = '#E3E3E3';
            else
                $bg = '#F3F3F3';
            echo "<tr>\n";
            foreach ($row as $value) {
                echo "<td bgcolor=\"$bg\"><span style=\"font-face: sans-serif; font-size: 9pt;\">$value</span></td>\n";
            }
            echo "</tr>\n";
        }
        echo "</table></div>\n";
    }

    /*
     * 
     * CAUTION: It's very important that after executing mysqli_multi_query you have first process the resultsets 
     * before sending any another statement to the server, otherwise your socket is still blocked.
     * Refer to: http://php.net/manual/en/mysqli.multi-query.php
     */

    function multiple_query($sql) {

        // Inserts data in the database via SQL query.
        // Returns the id of the insert or true if there is not auto_increment
        // column in the table.  Returns false if there is an error.      
        $this->last_query = $sql;

        //TODO: loop through result
        return $this->db_link->multi_query($sql);
//        if (!$r) {
//            $this->last_error = $this->db_link->error;
////         echo $this->last_error;
//            return false;
//        }
//        return $r;
    }

    /*
     * used to clean the multiple_query result. see function comment of above multiple_query.
     */

    function multiple_query_clean() {
        do {
            if (!$this->db_link->more_results()) {
                break;
            }
        } while ($this->db_link->next_result());
    
        return true;
    }

    function insert_sql($sql) {

        // Inserts data in the database via SQL query.
        // Returns the id of the insert or true if there is not auto_increment
        // column in the table.  Returns false if there is an error.      
        $this->last_query = $sql;

        $r = $this->db_link->query($sql);
        if (!$r) {
            $this->last_error = $this->db_link->error;
            return false;
        }

        $id = $this->db_link->insert_id;

        if ($id == 0)
            return true;
        else
            return $id;
    }

    function update_sql($sql) {

        // Updates data in the database via SQL query.
        // Returns the number or row affected or true if no rows needed the update.
        // Returns false if there is an error.

        $this->last_query = $sql;
        $r = $this->db_link->query($sql);
        if (!$r) {
            $this->last_error = $this->db_link->error;
            echo $this->last_error. "<P>";
            return -1;
        }

        $rows = $this->db_link->affected_rows;
        return $rows;
    }

    function insert_array($table, $data) {

        // Inserts a row into the database from key->value pairs in an array. The
        // array passed in $data must have keys for the table's columns. You can
        // not use any MySQL functions with string and date types with this 
        // function.  You must use insert_sql for that purpose.
        // Returns the id of the insert or true if there is not auto_increment
        // column in the table.  Returns false if there is an error.

        if (empty($data)) {
            $this->last_error = "You must pass an array to the insert_array() function.";
            return false;
        }

        $cols = '(';
        $values = '(';

        foreach ($data as $key => $value) {     // iterate values to input
            $cols .= "$key,";

            $col_type = $this->get_column_type($table, $key);  // get column type
            if (!$col_type)
                return false;  // error!

                
// determine if we need to encase the value in single quotes
            if (is_null($value)) {
                $values .= "NULL,";
            } elseif (substr_count(MYSQLI_TYPES_NUMERIC, "$col_type ")) {
                $values .= "$value,";
            } elseif (substr_count(MYSQLI_TYPES_DATE, "$col_type ")) {
                $value = $this->sql_date_format($value, $col_type); // format date
                $values .= "'$value',";
            } elseif (substr_count(MYSQLI_TYPES_STRING, "$col_type ")) {
                if ($this->auto_slashes)
                    $value = addslashes($value);
                $values .= "'$value',";
            }
        }
        $cols = rtrim($cols, ',') . ')';
        $values = rtrim($values, ',') . ')';

        // insert values
        $sql = "INSERT INTO $table $cols VALUES $values";
        return $this->insert_sql($sql);
    }

    function update_array($table, $data, $condition) {

        // Updates a row into the database from key->value pairs in an array. The
        // array passed in $data must have keys for the table's columns. You can
        // not use any MySQL functions with string and date types with this 
        // function.  You must use insert_sql for that purpose.
        // $condition is basically a WHERE claus (without the WHERE). For example,
        // "column=value AND column2='another value'" would be a condition.
        // Returns the number or row affected or true if no rows needed the update.
        // Returns false if there is an error.

        if (empty($data)) {
            $this->last_error = "You must pass an array to the update_array() function.";
            return false;
        }

        $sql = "UPDATE $table SET";
        foreach ($data as $key => $value) {     // iterate values to input
            $sql .= " $key=";

            $col_type = $this->get_column_type($table, $key);  // get column type
            if (!$col_type)
                return false;  // error!

                
// determine if we need to encase the value in single quotes
            if (is_null($value)) {
                $sql .= "NULL,";
            } elseif (substr_count(MYSQLI_TYPES_NUMERIC, "$col_type ")) {
                $sql .= "$value,";
            } elseif (substr_count(MYSQLI_TYPES_DATE, "$col_type ")) {
                $value = $this->sql_date_format($value, $col_type); // format date
                $sql .= "'$value',";
            } elseif (substr_count(MYSQLI_TYPES_STRING, "$col_type ")) {
                if ($this->auto_slashes)
                    $value = addslashes($value);
                $sql .= "'$value',";
            }
        }
        $sql = rtrim($sql, ','); // strip off last "extra" comma
        if (!empty($condition))
            $sql .= " WHERE $condition";

        // insert values
        return $this->update_sql($sql);
    }

    function execute_file($file) {

        // executes the SQL commands from an external file.

        if (!file_exists($file)) {
            $this->last_error = "The file $file does not exist.";
            return false;
        }
        $str = file_get_contents($file);
        if (!$str) {
            $this->last_error = "Unable to read the contents of $file.";
            return false;
        }

        $this->last_query = $str;

        // split all the query's into an array
        $sql = explode(';', $str);
        foreach ($sql as $query) {
            if (!empty($query)) {
                $r = mysqli_query($this->db_link, $query);

                if (!$r) {
                    $this->last_error = mysqli_error($this->db_link);
                    return false;
                }
            }
        }
        return true;
    }

    function get_column_type($table, $column) {

        // Gets information about a particular column using the mysqli_fetch_field
        // function.  Returns an array with the field info or false if there is
        // an error.

        $r = mysqli_query($this->db_link, "SELECT $column FROM $table");
        if (!$r) {
            $this->last_error = mysqli_error($this->db_link);
            return false;
        }
        //TODO : ???????
        $ret = mysql_field_type($r, 0);
        if (!$ret) {
            $this->last_error = "Unable to get column information on $table.$column.";
            mysqli_free_result($r);
            return false;
        }
        mysqli_free_result($r);
        return $ret;
    }

    function sql_date_format($value) {

        // Returns the date in a format for input into the database.  You can pass
        // this function a timestamp value such as time() or a string value
        // such as '04/14/2003 5:13 AM'. 

        if (gettype($value) == 'string')
            $value = strtotime($value);
        return date('Y-m-d H:i:s', $value);
    }

    function print_last_error($show_query = true) {

        // Prints the last error to the screen in a nicely formatted error message.
        // If $show_query is true, then the last query that was executed will
        // be displayed aswell.
        ?>
        <div
            style="border: 1px solid red; font-size: 9pt; font-family: monospace; color: red; padding: .5em; margin: 8px; background-color: #FFE2E2">
            <span style="font-weight: bold">db.class.php Error:</span><br><?php echo $this->last_error ?>
        </div>
        <?php
        if ($show_query && (!empty($this->last_query))) {
            $this->print_last_query();
        }
    }

    function print_last_query() {

        // Prints the last query that was executed to the screen in a nicely formatted
        // box.
        ?>
        <div
            style="border: 1px solid blue; font-size: 9pt; font-family: monospace; color: blue; padding: .5em; margin: 8px; background-color: #E6E5FF">
            <span style="font-weight: bold">Last SQL Query:</span><br><?php echo str_replace("\n", '<br>', $this->last_query) ?>
        </div>
        <?php
    }

}
?>
