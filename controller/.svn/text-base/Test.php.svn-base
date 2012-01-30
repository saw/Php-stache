<?php

class Controller_Test extends Controller {
	
	protected function prepareData(){
	    
	    App::getInstance()->setConf('mode', 'prod');
	    
	    for ($i=0; $i < 1000; $i++) { 
	        $str = TemplateParser::parse('test.html', array('headline' => 'This is a headline', 'body' => 'test'));
	    }
	    
		
		$this->data = array('title' => 'This is a test page', 'str' => $str);
		
	}
	
}