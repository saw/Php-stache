<?php

class Controller_Index extends Controller {
	
	protected function prepareData(){
		
		$this->data = array('title' => 'Welcome to deploy town!');
		$this->request->flushHead();
		$queryParam = $this->request->foo;
	}
	
	
	
}