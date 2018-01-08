<?php

require_once 'database.php';
require_once 'webconfig.php';

class database_wcc extends database {
	public $debugLevel = 0;
        public $datasource = 'datasource';
        protected $webconfMgr;
        
	/*   debugMessage format definitions
	 * 		0: debug output does not includes class name, functon name, and title, message are shown in same line.
	 * 		1: debug output includes class name, functon name, and title, message are shown in seperate line.
	 * 		2: debug output includes class name, functon name, and title, message are shown in same line.
	 */
	const DEBUG_SIMPLE_1LINES = 0;
	const DEBUG_FULLPATH_1LINES = 1;
	const DEBUG_FULLPATH_2LINES = 2;
	
	function __construct($datasource='datasource', $debugLevel=0) {
		if (!empty($datasource)) {
                    $this->datasource = $datasource;
		}
                    
		if (isset($debugLevel)) {
			$this->debugLevel = $debugLevel;
		}
		
		$this->webconfMgr = webconfig::getInstance();

		$this->host = $this->webconfMgr->getWebconfig ($this->datasource, 'host');
		$this->username = $this->webconfMgr->getWebconfig ($this->datasource, 'username'); 
		$this->password = $this->webconfMgr->getWebconfig ($this->datasource, 'password');
		$this->database = $this->webconfMgr->getWebconfig ($this->datasource, 'database');
                
                $this->connect ();
//                $this->select('set names utf8;');
                $this->db_link->set_charset('utf8');
	}
	
	/*
	 * Format: see above constant definitions.
	 *     
	 */
	function debugMessage ($debugLevel, $title, $message, $format=0) {
		if ($this->debugLevel >= $debugLevel) {
			$strDebugMsg = '<p>[DEBUG] ';
			
			if ($format == self::DEBUG_FULLPATH_1LINES || $format == self::DEBUG_FULLPATH_2LINES) {
				$backtrace = debug_backtrace();
				
				$callerClass = $backtrace[1]['class'];
				$callerFunction = $backtrace[1]['function'];
				$callerLine = ' [Line ' . $backtrace[1]['line'];
				$callerFile = '; File: ' . $backtrace[1]['file'] . ']';
			
				$strDebugMsg .= $callerClass . '->' . $callerFunction . "() ";
			} 
			
			if (strtolower($title) == 'error') {
				$strDebugMsg .= '<font color="red">' . $title . '</font>: ';
			} else {
				$strDebugMsg .= $title . ': ';
			}
			
			if ($format == self::DEBUG_FULLPATH_2LINES) {
				$strDebugMsg .= "\n<br />\n";
			}
			  
			echo $strDebugMsg . nl2br($message) . "\n</p>\n";
		}
	}
	
	protected function filterField ($fieldName, $dataType) {
		//TODO
	}
	
	protected function addSQLFilter ($strSQLWhere, $newFilter, $operator='AND') {
		if ($operator == 'AND' || $operator == 'OR') {
			if (strlen($strSQLWhere) > 0) {
				$strSQLWhere .= ' ' . $operator . ' ' . $newFilter;
			} else {
				$strSQLWhere .= $newFilter;			
			}
		}
		
		$this->debugMessage (1, 'SQL', $strSQLWhere, self::DEBUG_FULLPATH_2LINES);
		
		return $strSQLWhere;
	}
	
	
	
	/*
	 * $debugLevel: lower integer to trigger debug output.
	 * 
	 */
	function selectArray($strSQL, $debugLevel=1) {
		if (strlen($strSQL) <=10) {
			$this->last_error = 'Empty SQL statement.';
			$this->debugMessage (0, 'Error', $this->last_error, self::DEBUG_FULLPATH_2LINES);
			return false;
		}
		
		$this->debugMessage ($debugLevel, 'SQL', $strSQL, self::DEBUG_FULLPATH_2LINES);
		
		$result = $this->select ($strSQL); 

		if ($result == false) {
			$this->debugMessage (0, 'SQL', $strSQL, self::DEBUG_FULLPATH_2LINES);
			$this->debugMessage (0, 'Error', $this->last_error, self::DEBUG_FULLPATH_2LINES);
			return false;
		}
		
		$arrResult = array();
		
		while ( $row = mysqli_fetch_assoc( $result ) ) {
			$arrResult[] = $row;
		}
		
		mysqli_free_result($result);
		
		return $arrResult;		
	}


	
	/*
	 * Note: In SQL statement, first field is key, second field is value
	 * 
	 * $debugLevel: lower integer to trigger debug output.
	 * 
	 */
	function selectKeyValueArray($strSQL, $debugLevel) {
		if (strlen($strSQL) <=10) {
			$this->last_error = 'Empty SQL statement.';
			$this->debugMessage (0, 'Error', $this->last_error, self::DEBUG_FULLPATH_2LINES);
			return false;
		}
		
		$this->debugMessage ($debugLevel, 'SQL', $strSQL, self::DEBUG_FULLPATH_2LINES);
		
		$result = $this->select ($strSQL); 

		if ($result == false) {
			$this->debugMessage (0, 'Error', $this->last_error, self::DEBUG_FULLPATH_2LINES);
			return false;
		}
		
		$arrResult = array();
		
		while ( $row = mysqli_fetch_row( $result ) ) {
			$arrResult[$row[0]] = $row[1];
		}
		
		mysqli_free_result($result);
		
		return $arrResult;		
	}
	
	
	
	
	/*
	 *  Input: SQL, count(*) as number must be included. For example: 
	 *  		$strSQL = "SELECT count(*) as number FROM tbl_user;";
	 *         fieldName, default is 'number', but can be different name which is defined in $strSQL.
	 */
	function getTotalNumber($strSQL, $fieldName = 'number') {
		$this->debugMessage (1, 'SQL', $strSQL, self::DEBUG_FULLPATH_2LINES);
		
		$result = $this->selectArray ( $strSQL, 1);
		if (is_array($result) ) {
			$row = $result[0];
			$number = isset($row[$fieldName]) ? (int)$row[$fieldName] : (int)$row[0];
			return $number;
		} else {
			$this->debugMessage (1, 'Error', $this->last_error, self::DEBUG_FULLPATH_2LINES);
			return false;
		}
	}
}

?>