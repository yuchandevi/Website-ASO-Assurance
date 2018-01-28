<?php
	/**
	* 
	*/

	//Class Koneksi Database
	class Database
	{
		//properti
		 private $db_Host;
		 private $db_User;
		 private $db_Pass;
		 private $db_Name;

		//constructor
		function __construct($host, $user, $pass, $name)
		{
			# code...
			$this->db_Host = $host;
			$this->db_User = $user;
			$this->db_Pass = $pass;
			$this->db_Name = $name;
		}

		//connect sql
		function connectMySQL(){
			mysql_connect($this->db_Host, $this->db_User, $this->db_Pass);
			mysql_select_db($this->db_Name);
		}



	}
?>