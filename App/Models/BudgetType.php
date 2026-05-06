<?php
namespace Ncw\Models;

use Ncw\Controllers\Db;

class BudgetType extends Db {

  public function getAllBudgetTypes(){
    $sql = "
      SELECT * FROM budgettype WHERE status = 1 ORDER BY bgt_id
    ";
    $stmt = $this->pdo->query($sql);
    $data = $stmt->fetchAll();
    return $data;
  }

  public function addBudgetType($budgettype){
    $sql = "
      INSERT INTO budgettype (bgt_name) VALUES (:bgt_name)
    ";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute($budgettype);
    return $this->pdo->lastInsertId();
  }

}
?>