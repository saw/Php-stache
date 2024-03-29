<?php

function moduleSort($a, $b){
    if($a->order == $b->order){
        return 0;
    }
    
    return ($a->order < $b->order ? -1 :1);
}


/**
 * 
 * This is a singleton class that is the main controller
 * for the deploy application.
 */
class App {
	
	private static $instance;
	
	/**
	 * The yconf property contains an array representing the yui conf object in js
	 */
	public $yconf;
	
	protected $modules = array();
	
	protected $conf = array();
	
	private $handlers = Array('POST' => Array(), 'GET' => Array());
	
	/**
	  * Get everything ready to go, including yui
	  */
	private function __construct(){
	    
	    $this->yconf = array('debug' => true, 'useBrowserConsole' => true, 'filter' => 'raw');

	}
	
	public static function getInstance(){
		if (!isset(self::$instance)){
			$thisClass = __CLASS__;
			self::$instance = new $thisClass;
		}
		
		return self::$instance;
	}
	
	public function setConf($key, $value){
	    $this->conf[$key] = $value;
	}
	
	public function getConf($key){
	    if(array_key_exists($key, $this->conf)){
	        return $this->conf[$key];
	    }else{
	        return false;
	    }
	}
	
	protected function handlePath($path, $method, $controller){

	    
		if(isset($this->handlers[$method])){
			if(!isset($this->handlers[$method][$path])){
			    
				$this->handlers[$method][$path] = array('controller' => $controller);
				
			}else{
				throw new Exception('Handler already defined for '. $path . "\n");
			}
		}
	}
	
	public function post($path, $controller){
		$this->handlePath($path, 'POST', $controller);
	}
	
	public function get($path, $controller){
		$this->handlePath($path, 'GET', $controller);
	}
	
	public function request($path, $controller){
	    $this->post($path, $controller);
	    $this->get($path, $controller);
	}
	
	public function addYuiModule(YuiModule $module){
	    $this->modules[] = $module;
	}
	
	
	public function getYuiModules(){
	    usort($this->modules, 'moduleSort');
	    return $this->modules;
	}
	
	/**
	 * this method is a nice way of saying "we are done with config, lets parse handle the request"
	 */
	public function listen(){
		$url = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		
		$parsed = parse_url($url);

		$uri = $parsed['path'];
		$method = $_SERVER['REQUEST_METHOD'];

		if(isset($this->handlers[$method]) && isset($this->handlers[$method][$uri])){
			
			$request = Request::getInstance();
			$request->uri = $uri;
			$request->conf = $this->conf;
					
			if(class_exists($this->handlers[$method][$uri]['controller'])){
                
				$handler = new $this->handlers[$method][$uri]['controller']($request);
				if(is_a($handler, 'Controller')){
				    
				    
					$handler->execute();
					if($request->data || $handler->dataOnly){
						header('Content-type: application/json');
						$handler->renderDataView();
					}else{
						$handler->renderView();
					}
					
				}else{
					throw new Exception('Handler must be a Controller');
				}
			}else{
				throw new Exception('Class not found');
			}

		}else{
			header('HTTP/1.1 404 Not Found');

			$v404 = new View('e404');
			$v404->setData(array('title'=> '404!'));
			$v404->render();
            echo($v404->render());
		}
	}
	
}