<?php
namespace Ncw\Models;

use Ncw\Controllers\Db;

class Department extends Db {

  public function getAllDepartments(){
    $sql = "
      SELECT * FROM department ORDER BY dep_id
    ";
    $stmt = $this->pdo->query($sql);
    $data = $stmt->fetchAll();
    return $data;
  }

  public function addDepartment($department){
    $sql = "
      INSERT INTO department (dep_name) VALUES (:dep_name)
    ";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute($department);
    return $this->pdo->lastInsertId();
  }

}
?>