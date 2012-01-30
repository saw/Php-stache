<?php
/**
 * @
 * @abstract
 */
abstract class Controller {
	
	protected $request;
	protected $data;
	protected $isPartial;
	public $viewName;
	public $dataOnly = false;
	
	/**
	 * 
	 * @param Request $request constructor needs a request object
	 */
	public function __construct(Request $request){
		$this->request = $request;
		
		$this->viewName = str_replace('Controller_', '', get_class($this));
	}
	
	/**
	 * If partial is true the app won't render the layout
	 * @param bool $partial partial or not?
	 */
	public function execute($partial = false){
		$this->isPartial = $partial;
		$this->prepareData();
	}
	
	/**
	 * This is where children will actually get ready to render the view
	 */
	abstract protected function prepareData();
	
	/**
	 * If you pass an optional viewname it will use that rather than look for a view 
	 * with the same name as the class
	 * @param string $viewname
	 * @return string
	 */
	public function getView($viewname = false){
		if(!$viewname){
			$viewname = $this->viewName;
		}
		
		$viewname = strtolower($viewname);
		$view = new View($viewname, $this->isPartial);
		$view->setData($this->data);
		return $view->render();
	}
	
	public function getData(){
	    return $this->data;
	}
	
	/**
	 * Renderview actually echoes it out
	 * @return void
	 */
	public function renderView($viewName = false){
	    if($this->request->fragment == 1){
	        header('Content-type: text/plain');
	        $this->isPartial = true;
	    }
		echo($this->getView($viewName));
	}
	
	/**
	 * 
	 * just get the data in json format
	 */
	public function renderDataView(){
		echo(json_encode($this->data));
	}
	
}