<?php

/**
 * The base controller of the CMS
 * @author jimmiw
 * @since 2012-06-26
 */
class Controller
{
	// defines the standard layout to use
	protected $_layout = 'layout';
	// defines the view
	public $view = null;
	
	/**
	 * initializes various things in the controller
	 */
	public function init()
	{
		$this->view = new View();
	}
	
	/**
	 * Sets a new layout to use
	 * @param string $layout the new layout to use
	 */
	public function setLayout($layout)
	{
		$this->_layout = $layout;
	}
	
	/**
	 * These filters are run BEFORE the action is run
	 */
	public function beforeFilters()
	{
		
	}
	
	/**
	 * These filters are run AFTER the action is run
	 */
	public function afterFilters()
	{
		
	}
	
	/**
	 * The main entry point into the controller execution path. The parameter 
	 * taken is the action to execute.
	 * @param string $action the action to execute
	 * @throws Exception 
	 */
	public function execute($action = 'index')
	{
		// initializes the controller
		$this->init();
		
		// executes the before filters
		$this->beforeFilters();
		
		// adds the action suffix to the function to call
		$actionToCall = $action.'Action';
		
		// executes the action
		$this->$actionToCall();
		
		// executes the after filterss
		$this->afterFilters();
		
		// renders the view
		$this->view->render($this->_getViewScript($action));
	}
	
	protected function _getViewScript($action)
	{
		// fetches the current controller executed
		$controller = get_class($this);
		// removes the "Controller" part and adds the action name to the path
		$script = strtolower(substr($controller, 0, -10) . '/' . $action . '.phtml');
		// returns the script to render
		return $script;
	}
}
