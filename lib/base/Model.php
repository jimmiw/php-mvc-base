<?php

/**
 * A base model for handling the database connections
 * @author jimmiw
 * @since 2012-07-02
 */
class Model
{
	protected $_dbh = null;
	protected $_table = "";
	
	public function __construct()
	{
		// parses the settings file
		$settings = parse_ini_file(ROOT_PATH . '/config/settings.ini', true);
		
		// starts the connection to the database
		$this->_dbh = new PDO(
			sprintf(
				"%s:host=%s;dbname=%s",
				$settings['database']['driver'],
				$settings['database']['host'],
				$settings['database']['dbname']
			),
			$settings['database']['user'],
			$settings['database']['password']
		);
		
		$this->init();
	}
	
	public function init()
	{
		
	}
	
	public function fetchOne($id)
	{
		$sql = 'select * from ' . $this->_table;
		$sql .= ' where id = ?';
		
		$statement = $this->_dbh->prepare($sql);
		$statement->execute(array($id));
		
		return $statement->fetch(PDO::FETCH_OBJ);
	}
	
	/*public function fetchAll($where)
	{
		$sql = 'select * from ';
		$sql .= $this->_table;
		$sql .= ' where';
		
		$parameters = array();

		if (is_array($data)) {
			$first = true;
			
			foreach ($where as $key => $value) {
				
				if ($key == null) {
					$sql .= ' ' . $value;
				}
				else {
					$sql .= ' $key = ?';
				}
				
				
				$first = false;
			}
		}
		else {
			$sql .= ' id = ' . $where;
		}
		
		$statement = $this->_dbh->prepare($sql);
		$statement->execute($parameters);
	}*/
}
