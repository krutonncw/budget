<?php

namespace Ncw\Models;

use Ncw\Controllers\Db;

class Activity extends Db
{

  public function getAllActivitys()
  {
    $sql = "
      SELECT
        activity.act_id,
        activity.act_name,        
        activity.act_money,
        activity.act_balance,
        activity.pro_id,
        activity.bgt_id,
        activity.create_by,
        project.pro_name,
        budgettype.bgt_name,
        department.dep_name
      FROM activity 
        LEFT JOIN project ON activity.pro_id = project.pro_id
        LEFT JOIN budgettype ON activity.bgt_id = budgettype.bgt_id
        LEFT JOIN department ON project.dep_id = department.dep_id
      ORDER BY 
        act_id
    ";
    $stmt = $this->pdo->query($sql);
    $data = $stmt->fetchAll();
    return $data;
  }

  public function addActivity($activity)
  {
    $sql = "
      INSERT INTO activity (
        act_name,
        pro_id,
        bgt_id,
        act_money,
        act_balance,
        create_by) 
      VALUES (
        :act_name,
        :pro_id,
        :bgt_id,
        :act_money,
        :act_money,
        :create_by)
    ";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute($activity);
    return $this->pdo->lastInsertId();
  }

  // อัปเดตข้อมูลกิจกรรม
  public function updateActivity($data)
  {
    $sql = "
      UPDATE activity SET
        act_name = :act_name,
        pro_id = :pro_id,
        bgt_id = :bgt_id,
        act_money = :act_money
      WHERE act_id = :act_id
    ";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute($data);
    return 1;
  }

  // ลบกิจกรรม
  public function deleteActivity($id)
  {
    $sql = "
      DELETE FROM activity WHERE act_id = :act_id
    ";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute($id);
    return 1;
  }

  //เรียกดูชื่อกิจกรรมด้วยเลขรหัส
  public function getActivityById($act_id)
  {
    $sql = "
      SELECT
        activity.act_id,
        activity.act_name,
        activity.pro_id,
        activity.bgt_id,
        activity.act_money,
        activity.act_balance,
        project.pro_name,
        project.pro_user,
        budgettype.bgt_name,
        department.dep_name,
        management.man_user,
        management.man_pos
      FROM 
        activity
        LEFT JOIN project ON activity.pro_id = project.pro_id
        LEFT JOIN budgettype ON activity.bgt_id = budgettype.bgt_id
        LEFT JOIN department ON project.dep_id = department.dep_id
        LEFT JOIN management ON project.man_id = management.man_id
      WHERE 
        activity.act_id = :act_id
    ";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute($act_id);
    $data = $stmt->fetch();
    return $data;
  }

  //เรียกดูยอดเงินคงเหลือกิจกรรม
  public function getActBalById($act_id)
  {
    $sql = "
      SELECT
        activity.act_id,
        activity.act_balance 
      FROM
        activity  
      WHERE
        activity.act_id = :act_id 
    ";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute($act_id);
    $data = $stmt->fetch();
    return $data;
  }

  //อัปเดทยอดเงินคงเหลือกิจกรรม
  public function updateActBal($payplan)
  {
    $sql = "
    UPDATE
      activity
    SET
      act_balance = :pay_money
    WHERE
      act_id = :act_id 
  ";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute($payplan);
    return 1;
  }

  //เรียกดู รายกิจกรรม ด้วยรหัสกลุ่ม
  public function getActByDep($dep_id)
  {
    $sql = "
      SELECT
          activity.act_name,
          activity.act_id,
          activity.act_money,
          activity.act_balance,
          project.pro_name,
          budgettype.bgt_name,
          department.dep_name
      FROM
          activity
          LEFT JOIN project ON activity.pro_id = project.pro_id
          LEFT JOIN budgettype ON activity.bgt_id = budgettype.bgt_id
          LEFT JOIN department ON project.dep_id = department.dep_id
      WHERE
          project.dep_id = :dep_id
      GROUP BY
          activity.act_id
  ";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute($dep_id);
    $data = $stmt->fetchAll();
    return $data;
  }

  //เรียกดู งบประมาณกิจกรรมและรหัสโครงการ ด้วย 
  public function getDepIdByActId($act_id)
  {
    $sql = "
      SELECT
          activity.act_id,
          activity.act_money,
          activity.act_balance,
          project.pro_name,
          department.dep_id,
          department.dep_name
      FROM
          activity
          LEFT JOIN project ON activity.pro_id = project.pro_id
          LEFT JOIN department ON project.dep_id = department.dep_id
      WHERE
          activity.act_id = :act_id
  ";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute($act_id);
    $data = $stmt->fetchAll();
    return $data;
  }

  //รวมยอดตามประเภทงบประมาณ
  ////อ่านมาเฉพาะกิจ เอาแต่ field pay_order
  public function getGroupByType($type)
  {
    $sql = "
      SELECT
          SUM(activity.act_money) AS sum            
      FROM
          activity
      WHERE
          activity.bgt_id = :type
      GROUP BY
          activity.bgt_id        
      ";

    $stmt = $this->pdo->prepare($sql);
    $stmt->execute($type);
    $data = $stmt->fetch();
    return $data;
  }

  ///ลองแปลงจาก getGroupByType
  //รวมเงินจากรายการที่เบิกของแต่ละกิจกรรม แต่ละประเภทงบประมาณ
  public function getSumActMoneyGroupByBgt($type)
  {
    $sql = "
      SELECT
          SUM(activity.act_money) AS sumActMoney        
      FROM
          activity
      WHERE
          activity.bgt_id = :bgt_id
      GROUP BY
          activity.bgt_id       
      ";

    $stmt = $this->pdo->prepare($sql);
    $stmt->execute($type);
    $data = $stmt->fetch();
    return $data;
  }

  public function getSumActBalanceGroupByBgt($type)
  {
    $sql = "
      SELECT
          SUM(activity.act_balance) AS sumActBalance        
      FROM
          activity
      WHERE
          activity.bgt_id = :bgt_id
      GROUP BY
          activity.bgt_id       
      ";

    $stmt = $this->pdo->prepare($sql);
    $stmt->execute($type);
    $data = $stmt->fetch();
    return $data;
  }

  public function getActDepID($id)
  {
    $sql = "
        SELECT
            activity.act_name,
            activity.act_id,
            activity.act_money,
            activity.act_balance,
            project.pro_name,
            department.dep_name
        FROM
            activity
            LEFT JOIN project ON activity.pro_id = project.pro_id
            LEFT JOIN department ON project.dep_id = department.dep_id
        WHERE
            project.dep_id = :id
        GROUP BY
            activity.act_id
    ";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute($id);
    $data = $stmt->fetchAll();
    return $data;
  }

  //เรียกดูกิจกรรมตามรหัสโครงการ
  public function getActivitiesByPro($pro_id)
  {
    $sql = "
      SELECT
        activity.act_id,
        activity.act_name,
        activity.act_money,
        activity.act_balance,
        activity.pro_id,
        activity.bgt_id,
        activity.create_by,
        project.pro_name,
        budgettype.bgt_name,
        department.dep_name
      FROM activity
        LEFT JOIN project ON activity.pro_id = project.pro_id
        LEFT JOIN budgettype ON activity.bgt_id = budgettype.bgt_id
        LEFT JOIN department ON project.dep_id = department.dep_id
      WHERE activity.pro_id = :pro_id
      ORDER BY
        act_id
    ";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute($pro_id);
    $data = $stmt->fetchAll();
    return $data;
  }

}
