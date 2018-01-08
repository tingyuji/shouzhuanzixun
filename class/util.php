<?php

class util {

    /**
     * Note: other encoding: CP936, BIG5, UTF-16LE
     * 
     * @param type $str
     * @return type
     */
    static function getUTF8string($str) {
        $encoding = mb_detect_encoding($str, array('UTF-8', 'GBK', 'GB2312', 'ASCII'));
        if ($encoding != 'UTF-8') {
            $strNew = mb_convert_encoding($str, 'UTF-8', 'GBK');
        } else {
            $strNew = $str;
        }
        return $strNew;
    }

    static function getUTF8StringExcel($str) {
        return mb_convert_encoding($str, 'UTF-16LE', 'UTF-8');
    }
    
    static function getGBKstring($str) {
        $encoding = mb_detect_encoding($str, array('UTF-8', 'GBK', 'GB2312', 'ASCII'));
        if ($encoding != 'GBK') {
            $strNew = mb_convert_encoding($str, 'GBK', 'UTF-8');
        } else {
            $strNew = $str;
        }
        return $strNew;
    }
    
    static function removeBOM($buffer) {
        return str_replace("\xef\xbb\xbf", '', $buffer);
    }

    /**
     * 
     * @param type $diff, time in seconds 
     * @return array, includes time pieces (days, hours, minutes, seconds
     */
    static function getTimePieces($diff) {
        if ($days = intval((floor($diff / 86400))))
            $diff = $diff % 86400;

        if ($hours = intval((floor($diff / 3600))))
            $diff = $diff % 3600;

        if ($minutes = intval((floor($diff / 60))))
            $diff = $diff % 60;

        $diff = intval($diff);

        return( array('days' => $days, 'hours' => $hours, 'minutes' => $minutes, 'seconds' => $diff) );
    }

    static function getTimeDiff($startTime, $endTime) {
        $diff = $endTime - $startTime;

        return self::getTimePieces($diff);
    }

    static function time2string($time) {
        if (!is_array($time)) {
            $arrTime = self::getTimePieces($time);
        } else {
            $arrTime = $time;
        }

        $str = $arrTime['days'] > 0 ? $arrTime['days'] . '天 ' : ' ';
        $str .= $arrTime['hours'] > 0 ? $arrTime['hours'] . ':' : '00:';
        $str .= $arrTime['minutes'] > 0 ? sprintf("%02d", $arrTime['minutes']) . ':' : '00:';
        $str .= $arrTime['seconds'] > 0 ? sprintf("%02d", $arrTime['seconds']) : '00';
        return $str;
    }

    /**
     * 
     * @param type $path, passed by reference, therefore, no need to return new value.
     */
    static function appendDirSeparator(&$path) {
        $path = preg_replace('/(.*?[^\/])$/', '$1/', $path);
    }

    /**
     * 
     * @return float, time with milliseconds,  
     */
    static function microtime_float() {
        list($usec, $sec) = explode(" ", microtime());
        return ((float) $usec + (float) $sec);
    }

    static function get_full_url() {
        $https = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';
        return
                ($https ? 'https://' : 'http://') .
                (!empty($_SERVER['REMOTE_USER']) ? $_SERVER['REMOTE_USER'] . '@' : '') .
                (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : ($_SERVER['SERVER_NAME'] .
                        ($https && $_SERVER['SERVER_PORT'] === 443 ||
                        $_SERVER['SERVER_PORT'] === 80 ? '' : ':' . $_SERVER['SERVER_PORT']))) .
                substr($_SERVER['SCRIPT_NAME'], 0, strrpos($_SERVER['SCRIPT_NAME'], '/'));
    }

    static function get_parent_url() {
        $https = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';
        return
                ($https ? 'https://' : 'http://') .
                (!empty($_SERVER['REMOTE_USER']) ? $_SERVER['REMOTE_USER'] . '@' : '') .
                (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : ($_SERVER['SERVER_NAME'] .
                        ($https && $_SERVER['SERVER_PORT'] === 443 ||
                        $_SERVER['SERVER_PORT'] === 80 ? '' : ':' . $_SERVER['SERVER_PORT'])));
    }
    
    static function getAbusoluteRootPath () {
        $dir = dirname($_SERVER['SCRIPT_NAME']);
        $dir = str_replace("/", "\/", $dir);
        $curPath = str_replace (DIRECTORY_SEPARATOR, '/', realpath("./"));
        return preg_replace("/{$dir}$/", "", $curPath);
    }

}

?>
