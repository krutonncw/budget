<?php
namespace Ncw\Controllers;

use PDO;

class Db {
  // บนเว็บ
  // private $host = "localhost";
  // private $user = "ncw_budget";
  // private $password = "Ncw2563";
  // private $dbName = "ncw_budget";

  // บน XAMPP
  private $host = "localhost";
  private $user = "root";
  private $password = "";
  private $dbName = "ncw_budget";

  // บนเว็บ ncwschool
  // private $host = "localhost";
  // private $user = "ncwschoo_budgetuser";
  // private $password = "nongwit23";
  // private $dbName = "ncwschoo_budget";

  protected $pdo;

  function __construct() {
    $this->pdo = $this->connect();
  }

  protected function connect()
	{
		try {
			$dsn = "mysql:host={$this->host};dbname={$this->dbName};charset=utf8";
			$pdo = new PDO($dsn, $this->user, $this->password);
			$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			//echo "Connected successfully";	
			return $pdo;
		} catch(PDOException $e) {
			echo "Connection failed: " . $e->getMessage();
		}
	}

}
?>