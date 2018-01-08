<?php
/**
 *    WebConfig
 */
require_once 'util.php';
final class webconfig {
	private static $config_file = "/conf/webconfig.ini";
	private static $config_dev_file = "./conf/webconfig_dev.ini";
	private static $config;
	private static $instance;
	
	private function __construct() {
	}

	public function __clone() {
		// remove 
		trigger_error ('Clone is not allowed', E_USER_ERROR);
	}

	final public static function getInstance() {
		if (empty(self::$instance)) {
			// create an instance
			self::$instance = new webconfig();
			
                        $rootDir = util::getAbusoluteRootPath();
			// Load config from config file
			$config_main = parse_ini_file ( $rootDir . self::$config_file, true );
			self::$config = $config_main;
			
			if (file_exists($rootDir . self::$config_dev_file)) {
				$config_dev = parse_ini_file ( $rootDir . self::$config_dev_file, true );
				
				$config_new = self::mergeIni($config_main, $config_dev);
				self::$config = $config_new;
			} 
		}
		
		return self::$instance;
	}
	
	public function getWebconfig($section = null, $key = null) {
		
		if ($section !== null) {
			if ($key !== null) {
				if (isset ( self::$config [$section][$key] )) {
					return self::$config [$section][$key];
				} else {
//					throw new Exception ( "Unknown key '$section'.'$key' in configuration" );
					return null;
				}
			} else {
				if (isset ( self::$config[$section] )) {
					return self::$config[$section];
				} else {
					return null;
				}
			}
		} else {
			return self::$config;
		}
	}

	public function showConfig() {
		echo "<pre>";
		print_r (self::$config);
		echo "</pre>";
	}
	/*
	 * Merge two ini files to allow the development config to override the settings through the use of a dev INI file.
	 * 
	 */
	private static function mergeIni($config_ini, $custom_ini) {
		foreach ( $custom_ini as $k => $v ) {
			if (is_array ( $v )) {
				$config_ini [$k] = self::mergeIni ( $config_ini [$k], $custom_ini [$k] );
			} else {
				$config_ini [$k] = $v;
			}
		}
		
		return $config_ini;
	}
        
	public static function getWebconfig1($section = null, $key = null) {
            if (empty(self::$instance)) {
                self::getInstance();
            }

            if ($section !== null) {
                    if ($key !== null) {
                            if (isset ( self::$config [$section][$key] )) {
                                    return self::$config [$section][$key];
                            } else {
//					throw new Exception ( "Unknown key '$section'.'$key' in configuration" );
                                    return null;
                            }
                    } else {
                            if (isset ( self::$config[$section] )) {
                                    return self::$config[$section];
                            } else {
                                    return null;
                            }
                    }
            } else {
                    return self::$config;
            }
	}                
}

?>