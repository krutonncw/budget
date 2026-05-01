<?php
namespace Ncw\Controllers;

use PDO;

class Db {
  // บนเว็บ
  // private $host = "localhost";
  // private $user = "na_budget";
  // private $password = "Na2569";
  // private $dbName = "na_budget";

  // บน XAMPP
  private $host = "localhost";
  private $user = "root";
  private $password = "";
  private $dbName = "na_budget";

  // บนเว็บ ncwschool
  // private $host = "localhost";
  // private $user = "ncwschoo_budgetuser";
  // private $password = "nongwit23";
  // private $dbName = "ncwschoo_budget";

  // // บนเว็บ theskru
  // private $host = "localhost";
  // private $user = "theskruc_naacth";
  // private $password = "na@budget";
  // private $dbName = "theskruc_nabudget";

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