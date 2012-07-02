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
	// defines the request
	protected $_request = null;
	
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
		// no standard filers
	}
	
	/**
	 * These filters are run AFTER the action is run
	 */
	public function afterFilters()
	{
		// no standard filers
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
	
	/**
	 * fetches the view script for the given action
	 * @param string $action
	 * @return string the path to the view script
	 */
	protected function _getViewScript($action)
	{
		// fetches the current controller executed
		$controller = get_class($this);
		// removes the "Controller" part and adds the action name to the path
		$script = strtolower(substr($controller, 0, -10) . '/' . $action . '.phtml');
		// returns the script to render
		return $script;
	}
	
	/**
	 * The base url is used if the application is located in a subfolder. Use
	 * this function when linking to things.
	 * @return string the baseUrl for the application.
	 */
	protected function _baseUrl()
	{
		return WEB_ROOT;
	}
	
	/**
	 * Fetches the current request
	 * @return Request
	 */
	public function getRequest()
	{
		// initializes the request object
		if ($this->_request == null) {
			$this->_request = new Request();
		}
		
		return $this->_request;
	}
	
	/**
	 * A way to access the current request parameters
	 * @param string $key the key to look for
	 * @param mixed $default the default value, else null
	 * @return mixed
	 */
	protected function _getParam($key, $default = null)
	{
		return $this->getRequest()->getParam($key, $default);
	}
}
