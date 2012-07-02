<?php

class Request
{
	/**
	 * Tests if the current request is a POST request
	 * @return boolean
	 */
	public function isPost()
	{
		return ($_SERVER['REQUEST_METHOD'] == 'POST' ? true : false);
	}
	
	/**
	 * Tests if the current request is a GET request
	 * @return boolean
	 */
	protected function _isGet()
	{
		return ($_SERVER['REQUEST_METHOD'] == 'GET' ? true : false);
	}
	
	/**
	 * fetches the given parameter data.
	 * @param string $key the key to look for.
	 * @param mixed $default the default value to return, if the given parameter is not set.
	 */
	public function getParam($key, $default = null)
	{
		if ($this->isPost()) {
			if(isset($_POST[$key])) {
				return $_POST[$key];
			}
		}
		else if ($this->_isGet()) {
			if(isset($_GET[$key])) {
				return $_GET[$key];
			}
		}
			
		return $default;
	}
}
