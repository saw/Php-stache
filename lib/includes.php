<?php


require(__DIR__ . '/../fe_config/01_init_config.php');
require(__DIR__ . '/../controller/Controller.php');


function __autoload($className){
	
 	//has a directory
	if(preg_match("/([A-Z][a-zA-Z0-9]+)_([A-Z][A-Za-z]+)/", $className, $matches)){
		$dir = strtolower($matches[1]);
		$class = $matches[2];
		require(__DIR__ . '/../' . "$dir/$class". '.php');
	}else if($className == 'View'){
	    require(__DIR__ . '/../views/View.php');
	}else{
		require(__DIR__ . '/' . $className . '.php');
	}
}

?>