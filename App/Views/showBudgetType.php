<?php
require $_SERVER['DOCUMENT_ROOT'] . "/budget/vendor/autoload.php";

use Ncw\Models\BudgetType;
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>
  <table>
    <thead>
      <tr>
        <th>ลำดับ</th>
        <th>ประเภทงบประมาณ</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $budgettypeObj = new BudgetType();
      $budgettypes = $budgettypeObj->getAllBudgetTypes();
      foreach ($budgettypes as $budgettype) {
        echo "
        <tr>
          <td>{$budgettype['bgt_id']}</td>
          <td>{$budgettype['bgt_name']}</td>
        </tr>
        ";
      }
      ?>
    </tbody>
  </table>
</body>

</html>