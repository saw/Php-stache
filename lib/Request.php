<?php
//this will take the url and query string, post body, cookies, etc and turn it into someting useful for controllers, without
//depending on superglobals and whatnot

//also makes sure that values are either set or false, because typing array_key_exists is
//irritating

class Request {
	
	private static $instance;
	
	protected $extras;
	
	
	private function __construct(){
	    $this->extras = array();

	}
	
	//this is so I can tweak this to support different path styles, filtering whatever
	public function __get($key){
	    
	    if($key == 'queryString'){
	        return $_SERVER['QUERY_STRING'];
	    }
	    
		if(array_key_exists($key, $_REQUEST)){
			return $_REQUEST[$key];
			
		}else if(array_key_exists($key, $this->extras)){
		    
	        return $this->extras[$key];
	    }else{
			return false;
		}
		
	}
	
	public function flushHead() {
		ob_start();
		require(__DIR__ . '/../views/flushable.php');
		echo ob_get_clean();
		flush();
	}
	
	public function __set($key, $value) {
	    $this->extras[$key] = $value;
	}
	
	public static function getInstance(){
		if (!isset(self::$instance)){
			$thisClass = __CLASS__;
			self::$instance = new $thisClass;
		}
		
		return self::$instance;
	}
	
}