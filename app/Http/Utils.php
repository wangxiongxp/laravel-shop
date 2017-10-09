<?php namespace App\Http;

use Countable;
use Symfony\Component\HttpFoundation\File\File;

class Utils {

    /**
     * Validate that a required attribute exists.
     *
     * @param  mixed   $value
     * @return bool
     */
    public static function validateRequired($value)
    {
        if (is_null($value)) {
            return false;
        } elseif (is_string($value) && trim($value) === '') {
            return false;
        } elseif ((is_array($value) || $value instanceof Countable) && count($value) < 1) {
            return false;
        } elseif ($value instanceof File) {
            return (string) $value->getPath() != '';
        }

        return true;
    }

	public static function CreateDir($basedir, $filedir = '',&$return_path='') {
		$dir = $basedir;
		$ctime = time ();
		! is_dir ( $dir ) && @mkdir ( $dir, 0777 );
		if (! empty ( $filedir )) {
			$filedir = str_replace ( array (
					'{y}',
					'{m}',
					'{d}'
			), array (
					date ( 'Y', $ctime ),
					date ( 'm', $ctime ),
					date ( 'd', $ctime )
			), strtolower ( $filedir ) );
			$dirs = explode ( '/', $filedir );
			foreach ( $dirs as $d ) {
				if(!empty ( $d )){
					$dir .= $d . '/';
					$return_path .= $d . '/';
				}
				! is_dir ( $dir ) && @mkdir ( $dir, 0777 );
			}
		}
		return $dir;
	}
	
	public static function CreateGuid($namespace = '')
	{
		static $guid = '';
		$uid = uniqid("", true);
		$data = $namespace;
		$data .= $_SERVER['REQUEST_TIME'];
		$data .= $_SERVER['HTTP_USER_AGENT'];
		//$data .= $_SERVER['LOCAL_ADDR'];
		//$data .= $_SERVER['LOCAL_PORT'];
		$data .= $_SERVER['REMOTE_ADDR'];
		$data .= $_SERVER['REMOTE_PORT'];
		$hash = strtoupper(hash('ripemd128', $uid . $guid . md5($data)));
		$guid = '' .
				substr($hash,  0,  8) .
				'-' .
				substr($hash,  8,  4) .
				'-' .
				substr($hash, 12,  4) .
				'-' .
				substr($hash, 16,  4) .
				'-' .
				substr($hash, 20, 12) .
				'';
		return $guid;
	}
	
	public static function GetIP() {
		if (getenv ( "HTTP_CLIENT_IP" ) && strcasecmp ( getenv ( "HTTP_CLIENT_IP" ), "unknown" ))
			$ip = getenv ( "HTTP_CLIENT_IP" );
		else if (getenv ( "HTTP_X_FORWARDED_FOR" ) && strcasecmp ( getenv ( "HTTP_X_FORWARDED_FOR" ), "unknown" ))
			$ip = getenv ( "HTTP_X_FORWARDED_FOR" );
		else if (getenv ( "REMOTE_ADDR" ) && strcasecmp ( getenv ( "REMOTE_ADDR" ), "unknown" ))
			$ip = getenv ( "REMOTE_ADDR" );
		else if (isset ( $_SERVER ['REMOTE_ADDR'] ) && $_SERVER ['REMOTE_ADDR'] && strcasecmp ( $_SERVER ['REMOTE_ADDR'], "unknown" ))
			$ip = $_SERVER ['REMOTE_ADDR'];
		else
			$ip = "unknown";
		return ($ip);
	}

	public static function GetDatetimeWithUTC() {
		return date ( 'Y-m-d H:i:s' );
	}
	
	public static function GetDateWithUTC() {
		return date ( 'Y-m-d' );
	}

	public static function GetOrderId()
	{
		srand ( ( double ) microtime () * 1000000 );
		$rnd = rand ( 100, 999 );
		$name = date ( "YmdHis", time () ) . $rnd;
		return $name;
	}
	
	public static function DateTimeAdd($datetime, $format, $num) {
		$datetime 	= strtotime($datetime);
		$years 		= gmdate("Y", $datetime);
		$months 	= gmdate("m", $datetime);
		$days 		= gmdate("d", $datetime);
		$hours 		= gmdate("H", $datetime);
		$minutes 	= gmdate("i", $datetime);
		$seconds 	= gmdate("s", $datetime);
		switch($format) {
			case 'y':
				$years = $years + $num; break;
			case 'm':
				$months = $months + $num; break;
			case 'd':
				$days = $days + $num; break;
			case 'h':
				$hours = $hours + $num; break;
			case 'i':
				$minutes = $minutes + $num; break;
			case 's':
				$seconds = $seconds + $num; break;
		}
		return  gmdate('Y-m-d H:i:s',gmmktime($hours,$minutes,$seconds,$months,$days,$years));
	}
	
	public static function DateAdd($date, $format, $num) {
		$datatime = strtotime ( $date );
		$years = gmdate ( "Y", $datatime );
		$months = gmdate ( "m", $datatime );
		$days = gmdate ( "d", $datatime );
		if ($format == 'Y') {
			$years = $years + $num;
		}
		if ($format == 'm') {
			$months = $months + $num;
		}
		if ($format == 'd') {
			$days = $days + $num;
		}
		return gmdate ( 'Y-m-d', gmmktime ( 0, 0, 0, $months, $days, $years ) );
	}
	
	public function GetRndFilename($savename = "")
	{
		if ($savename == "") 		// 如果未设置文件名，则生成一个随机文件名
		{
			srand ( ( double ) microtime () * 1000000 );
			$rnd = rand ( 100, 999 );
			$name = date ( "YmdHis", time () ) . $rnd;
		} else {
			$name = $savename;
		}
		return $name;
	}
	
	public function GetFileExt($filename)
	{
		return strtolower(substr(strrchr($filename,'.'),1,10));
	}

	public static function IsEmpty($val) {
		if (empty ( $val )) {
			return ($val == '0') ? false : true;
		}
		return (trim ( $val ) == "") ? true : false;
	}

	public static function RemoveAttrNull($data)
	{
		$attReturn = array();
		foreach ($data as $key=>$val) {
			if( is_null($val)) continue;
			$attReturn[$key] = $val;
		}
		return $attReturn;
	}

	public static function object_to_array($stdclassobject) {
		$_array = is_object ( $stdclassobject ) ? get_object_vars ( $stdclassobject ) : $stdclassobject;
        $array = array();
		foreach ( $_array as $key => $value ) {
			$value = (is_array ( $value ) || is_object ( $value )) ? Utils::object_to_array ( $value ) : $value;
			$array [$key] = $value;
		}
		return $array;
	}

    public static function GetDomain() {
        $my_url = (! empty ( $_SERVER ['HTTP_HOST'] )) ? strtolower ( $_SERVER ['HTTP_HOST'] ) : ((! empty ( $_SERVER ['SERVER_NAME'] )) ? $_SERVER ['SERVER_NAME'] : getenv ( "SERVER_NAME" ));

        if(isset($_SERVER ['HTTPS']) && strtoupper($_SERVER ['HTTPS']) == 'ON'){
            $my_url = 'https://' . $my_url;
            if ($_SERVER ['SERVER_PORT'] !== '443') {
                if (stripos ( $my_url, ':' . $_SERVER ['SERVER_PORT'] ) === false) {
                    $my_url .= ':' . $_SERVER ['SERVER_PORT'];
                }
            }
        }else{
            $my_url = 'http://' . $my_url;
            if ($_SERVER ['SERVER_PORT'] !== '80') {
                if (stripos ( $my_url, ':' . $_SERVER ['SERVER_PORT'] ) === false) {
                    $my_url .= ':' . $_SERVER ['SERVER_PORT'];
                }
            }
        }

        return $my_url;
    }
}
