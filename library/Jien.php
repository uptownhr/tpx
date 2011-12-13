<?php

class Jien {

	/**
	 * gets a singleton of your model object
	 *
	 * @param string $model
	 * @param boolean $new
	 * @return object
	 */
    static function model($model, $new = false){
        $name = 'model_' . $model;
        if(Zend_Registry::isRegistered($name) && $new === false){
			return Zend_Registry::get($name);
        }else{
            $class = 'Application_Model_DbTable_' . $model;
            $obj = new $class;
            Zend_Registry::set($name,$obj);
            return $obj;
        }
    }

    // short to db resource
    static function db(){
		return Zend_Registry::get('db');
	}

	// short to master db resource
	static function masterdb(){
		return Zend_Registry::get('masterdb');
	}

    /**
	 * get date in utc date time or unix ts, plus removes invalid dates
	 * returns in date time
	 *
	 * @param string $str
	 * @return string
	 */
	static function getDateTime($str, $iso = true){
		if($iso){
			$format = "Y-m-d\TH:i:s\Z";
		}else{
			$format = "Y-m-d H:i:s";
		}

		// is date time
		if(strstr($str,'-')){
			if($str == '0000-00-00 00:00:00'){
				$date = '';
			}else{
				$time = strtotime($str);
				$date = date($format,$time);
			}
		}elseif($str == ''){
			$date = '';
		}else{
			// is unix ts
			$date = date($format, $str);
		}
		return $date;
	}

	/**
	 * short hand for outputting pre-formmated struct to page via array or tables
	 *
	 * @param struct $data
	 * @param bool $js
	 */
	static function debug($data, $js=false){

		if($js){
			echo "<script>console.log('" . json_encode($data) . "');</script>";
		}else{
			echo '<pre>';
	  		print_r($data);
	  		echo '</pre>';
		}

	}

	/**
	 * converts arrays into objects
	 *
	 * @param array$array
	 * @return object
	 */
	static function arrayToObject($array = array()) {
	  if (!empty($array)) {
	    $data = false;
	    foreach ($array as $akey => $aval) {
	      $data -> {$akey} = $aval;
	    }
	    return $data;
	  }
	  return false;
	}

	/**
	 * converts multi-dimensional arrray to object
	 *
	 * @param array $a
	 * @return object
	 */
	static function arrayToObjectRecursive($a = array()){
		$b = json_encode($a);
		$c = json_decode($b);//->object
		return $c;
	}

	/**
	 * Orders the associative array by key
	 *
	 * @param array $data
	 * @param string $field
	 * @return array
	 */
	static function arraySort($data, $field, $dir = 'asc'){
	  $code = "return strnatcmp(\$a['$field'], \$b['$field']);";
	  usort($data, create_function('$a,$b', $code));
	  if(strtolower($dir) != 'asc'){
	  	$data = array_reverse($data);
	  }
	  return $data;
	}

	/**
	* Translates a string with underscores into camel case (e.g. first_name -&gt; firstName)
	* @param    string   $str                     String in underscore format
	* @param    bool     $capitalise_first_char   If true, capitalise the first char in $str
	* @return   string                              $str translated into camel caps
	*/
	static function strToCamelCase($str, $capitalise_first_char = false) {
		if($capitalise_first_char) {
		  $str[0] = strtoupper($str[0]);
		}
		$func = create_function('$c', 'return strtoupper($c[1]);');
		return preg_replace_callback('/_([a-z])/', $func, $str);
	}

	static function validateIp($ip){
		return preg_match("/^([1-9]|[1-9][0-9]|1[0-9][0-9]|2[0-4][0-9]|25[0-5])" . "(\.([0-9]|[1-9][0-9]|1[0-9][0-9]|2[0-4][0-9]|25[0-5])){3}$/", $ip);
	}

	static function getClientIp(){
		// get ip
		$ipaddr = '';
		if(isset($_SERVER['HTTP_CLIENT_IP'])){
			$ipaddr = $_SERVER['HTTP_CLIENT_IP'];
		}else if(isset($_SERVER['REMOTE_ADDR'])){
			$ipaddr = $_SERVER['REMOTE_ADDR'];
		}else{
			$ipaddr = '127.0.0.1';
		}
		return $ipaddr;
	}

	static function dateSince($since) {

    	// if passed as datetime
    	if(strstr($since, '-')){
    		$since = strtotime($since);
    	}

    	$since = time() - $since;

	    $chunks = array(
	        array(60 * 60 * 24 * 365 , 'year'),
	        array(60 * 60 * 24 * 30 , 'month'),
	        array(60 * 60 * 24 * 7, 'week'),
	        array(60 * 60 * 24 , 'day'),
	        array(60 * 60 , 'hour'),
	        array(60 , 'minute'),
	        array(1 , 'second')
	    );

	    for ($i = 0, $j = count($chunks); $i < $j; $i++) {
	        $seconds = $chunks[$i][0];
	        $name = $chunks[$i][1];
	        if (($count = floor($since / $seconds)) != 0) {
	            break;
	        }
	    }

	    $print = ($count == 1) ? '1 '.$name : "$count {$name}s";
	    return $print . ' ago';
	}

	static function dateTo($future){
	   	// if passed as datetime
    	if(strstr($future, '-')||strstr($future, '/')){
    		$future = strtotime($future);
    	}
		// Common time periods as an array of arrays
		$periods = array(
			array(60 * 60 * 24 * 365 , 'year'),
			array(60 * 60 * 24 * 30 , 'month'),
			array(60 * 60 * 24 * 7, 'week'),
			array(60 * 60 * 24 , 'day'),
			array(60 * 60 , 'hour'),
			array(60 , 'minute'),
		);
		$today = time();
		$since = $future - $today; // Find the difference of time between now and the future
		// Loop around the periods, starting with the biggest
		for ($i = 0, $j = count($periods); $i < $j; $i++){
			$seconds = $periods[$i][0];
			$name = $periods[$i][1];

		 	// Find the biggest whole period
		 	if (($count = floor($since / $seconds)) != 0){
		 		break;
			}
		}
		$print = ($count == 1) ? '1 '.$name : "$count {$name}s";
			if ($i + 1 < $j){
			// Retrieving the second relevant period
			$seconds2 = $periods[$i + 1][0];
			$name2 = $periods[$i + 1][1];
			// Only show it if it's greater than 0
			if (($count2 = floor(($since - ($seconds * $count)) / $seconds2)) != 0){
				$print .= ($count2 == 1) ? ', 1 '.$name2 : ", $count2 {$name2}s";
		 	}
		}
		return $print;
	}

	static function encrypt($string, $key = SALT){
		return base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $string, MCRYPT_MODE_CBC, md5(md5($key))));
	}

	static function decrypt($string, $key = SALT){
		return rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode($string), MCRYPT_MODE_CBC, md5(md5($key))), "\0");
	}

	static function getCurrentUrl(){
		return 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
	}

	static function getFriendlyUrl($str){
		return str_replace(" ", "-", $str);
	}

	static function englishNumber($number){
		// Validate and translate our input
	    if ( is_numeric($number)){

	        // Get the last two digits (only once)
	        $n = $number % 100;

	    }
	    else {
	        // If the last two characters are numbers
	        if ( preg_match( '/[0-9]?[0-9]$/', $number, $matches )){

	            // Return the last one or two digits
	            $n = array_pop($matches);
	        }
	        else {

	            // Return the string, we can add a suffix to it
	            return $number;
	        }
	    }

	    $number = number_format($number);

	    // Skip the switch for as many numbers as possible.
	    if ( $n > 3 && $n < 21 )
	        return $number . 'th';

	    // Determine the suffix for numbers ending in 1, 2 or 3, otherwise add a 'th'
	    switch ( $n % 10 ){
	        case '1': return $number . 'st';
	        case '2': return $number . 'nd';
	        case '3': return $number . 'rd';
	        default:  return $number . 'th';
	    }
    }

    static function csvEncode($data){
    	if(is_array($data)){
    		return implode(',', $data);
    	}
    }

    static function csvDecode($data){
    	return explode(",", $data);
    }

    static public function objectToArray(stdClass $Class){
        # Typecast to (array) automatically converts stdClass -> array.
        $Class = (array)$Class;

        # Iterate through the former properties looking for any stdClass properties.
        # Recursively apply (array).
        foreach($Class as $key => $value){
            if(is_object($value)&&get_class($value)==='stdClass'){
                $Class[$key] = self::objectToArray($value);
            }
        }
        return $Class;
    }

    static function session($key='',$value=''){
    	$res = array();
    	if($key!=''){
    		if($value!=''){
    			$_SESSION[$key] = $value;
    		}
    		if(isset($_SESSION[$key])){
    			$res = $_SESSION[$key];
    		}else{
    			$res = '';
    		}
    	}else{
    		$res = $_SESSION;
    	}
    	if(empty($res)) $res = '';
    	return $res;
    }

    static function curl($url, $method, $params = array()){
    	$client = new Zend_Http_Client($url);
    	if(strtoupper($method) == "POST"){
    		$client->setParameterPost($params);
    	}else{
    		$client->setParameterGet($params);
    	}
    	$response = $client->request($method);
    	return $response->getBody();
    }

    static function errorLog($data){
		error_log(str_replace("\t", "", str_replace("\n", " ", var_export($data,true))));
	}

	static function outputDbProfiler(){
		$db = Zend_Registry::get('db');
		if($db){
		    $profiler = $db->getProfiler();
		    $totalTime    = $profiler->getTotalElapsedSecs();
		    $queryCount   = $profiler->getTotalNumQueries();
		    $longestTime  = 0;
		    $longestQuery = null;
		    foreach ($profiler->getQueryProfiles() as $query) {
		            $queries .= $query->getQuery() . "\n" . "({$query->getElapsedSecs()} seconds)" . "\n\n";
		        if ($query->getElapsedSecs() > $longestTime) {
		            $longestTime  = $query->getElapsedSecs();
		            $longestQuery = $query->getQuery();
		        }
		    }
		    echo '<!--slave
		    Executed ' . $queryCount . ' queries in ' . $totalTime . ' seconds' . "\n";
		    echo 'Average query length: ' . $totalTime / $queryCount . ' seconds' . "\n";
		    echo 'Queries per second: ' . $queryCount / $totalTime . "\n";
		    echo 'Longest query length: ' . $longestTime . "\n";
		    echo "Longest query: \n" . $longestQuery . "\n";
		    echo "Total queries: \n" . $queries;
		    echo "-->";
		}

		$db = Zend_Registry::get('masterdb');
		if($db){

			$queries = '';
		    $profiler = $db->getProfiler();
		    $totalTime    = $profiler->getTotalElapsedSecs();
		    $queryCount   = $profiler->getTotalNumQueries();
		    $longestTime  = 0;
		    $longestQuery = null;
		    foreach ($profiler->getQueryProfiles() as $query) {
		            $queries .= $query->getQuery() . "\n" . "({$query->getElapsedSecs()} seconds)" . "\n\n";
		        if ($query->getElapsedSecs() > $longestTime) {
		            $longestTime  = $query->getElapsedSecs();
		            $longestQuery = $query->getQuery();
		        }
		    }
		    echo '<!--master
		    Executed ' . $queryCount . ' queries in ' . $totalTime . ' seconds' . "\n";
		    echo 'Average query length: ' . $totalTime / $queryCount . ' seconds' . "\n";
		    echo 'Queries per second: ' . $queryCount / $totalTime . "\n";
		    echo 'Longest query length: ' . $longestTime . "\n";
		    echo "Longest query: \n" . $longestQuery . "\n";
		    echo "Total queries: \n" . $queries;
		    echo "-->";
		}

	}

	public static function auth(){
		$auth = Zend_Auth::getInstance();
		return $auth;
	}

	public static function outputResult($code, $result, $msg = ''){

		switch($code){

			case 200:
				$text = 'ok';
				break;

			case 400:
				$text = 'bad request';
				break;

			case 401:
				$text = 'unauthorized';
				break;

			case 403:
				$text = 'forbidden';
				break;

			case 404:
				$text = 'not found';
				break;

			case 405:
				$text = 'not allowed';
				break;

			default:
				$text = 'internal server error';
				break;

		}

		$res = array(
			"status"	=>	array(
				"code"	=>	$code,
				"text"	=>	$text,
				"message"	=> $msg,
			),
			"result"	=>	$result,
		);

		return $res;
	}

	// parses filter string query
	public static function parseStrQuery($str = ''){
		$filters = array();
		if($str != ''){
			$xFilters = explode("|", $str);
			foreach($xFilters AS $f){
				$x = explode(":", $f);
				$filters[$x[0]] = $x[1];
			}
		}
		return $filters;
	}

	public function sanitize($str){
		//$str = htmlspecialchars($str);
        //$str = mysql_escape_string($str);
        return $str;
	}

	public function sanitizeArray($arr = array()){
		if(!empty($arr)){
			foreach($arr AS $key=>$value){
				if($value){
					$arr[$key] = self::sanitize($value);
				}
			}
		}
		return $arr;
	}
	
	static function send_mail($to = array(), $subject, $body, $from = array( 'name'=>'TPX', 'address'=>'info@tpx.com')){
		$mail = new Zend_Mail();
		$mail->setBodyText($body);
		$mail->setFrom( $from['address'], $from['name'] );
		foreach($to as $email){
			$mail->addTo($email);	
		}
		$mail->setSubject($subject);
		$mail->send();
	}

}