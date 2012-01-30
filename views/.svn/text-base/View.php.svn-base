<?php


class View {
	
	protected $viewname;
	
	protected $data;
	
	protected $body;
	
	protected $layout;
	
	protected $isPartial;
	

	
	public function __construct($viewname, $partial = false){
		$this->layout = __DIR__ . '/layout.php';
		$this->viewname = $viewname;
		$this->isPartial = $partial;

		$this->yconf = new stdClass();
		

	}
	
	public function setLayout($path){
		$this->layout = $path;
	}
	
	public function setData($data){
		$this->data = $data;
		$this->yconf->viewdata = $data;
	}
	

	
	public function render(){

        $phpself = Request::getInstance()->uri;
        
		ob_start();
		require(__DIR__ . '/' .$this->viewname . '.php');
		
		$modules = App::getInstance()->getYuiModules();

		$showYuiConf = (count($modules)) > 0 ? true : false;
		$this->body = ob_get_clean() . "\n";

		
		if(!$this->isPartial){
		    
		    $yuiconf = json_encode(App::getInstance()->yconf);
			ob_start();
			
			require($this->layout);
			
			return(ob_get_clean());
		}else{
			return $this->body;
		}
	}
	
}