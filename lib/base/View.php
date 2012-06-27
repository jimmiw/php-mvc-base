<?php

/**
 * A class for handling the view logic of the system
 *
 * @author jimmiw
 * @since 2012-06-27
 */
class View
{
	// used for holding the content of the view script
	protected $_content = "";
	// the standard layout
	protected $_layout = 'layout';
	// initializes the data array
	protected $_data = array();
	

	/**
	 * Renders the view script, and stores the output
	 */
	protected function _renderViewScript($viewScript)
	{
		// starts the output buffer
		ob_start();
		
		// includes the view script
		include(ABSPATH . 'app/views/scripts/' . $viewScript);
		
		// returns the content of the output buffer
		$this->_content = ob_get_clean();
	}
	
	/**
	 * Fetches the content of the current view script
	 */
	public function content()
	{
		return $this->_content;
	}
	
	/**
	 * Renders the current view.
	 */
	public function render($viewScript)
	{
		// renders the view script
		$this->_renderViewScript($viewScript);
		
		// includes the current view, which uses the "$this->content()" to output the 
		// view script that was just rendered
		include(ABSPATH . 'app/views/layouts/' . $this->_getLayout() . '.phtml');
	}
	
	protected function _getLayout()
	{
		return $this->_layout;
	}
	
	public function setLayout($layout)
	{
		$this->_layout = $layout;
	}
	
	/**
	 * stores the given data on the given key
	 * @param string $key the key to store the data under
	 * @param mixed $value the value to store
	 */
	public function __set($key, $value)
	{
		// stores the data
		$this->_data[$key] = $value;
	}
	
	/**
	 * Returns the data if it exists, else nul
	 * @param string $key the data to look for
	 * @return mixed the data found or null
	 */
	public function __get($key)
	{
		if (array_key_exists($key, $this->_data)) {
			return $this->_data[$key];
		}
		
		return null;
	}
}
