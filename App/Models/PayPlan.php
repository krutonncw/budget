<?php

namespace Ncw\Models;

use Ncw\Controllers\Db;

class PayPlan extends Db
{
  //ดูการขอใช้เงินทุกใบคำขอ
  public function getAllPayPlans()
  {
    $sql = "
      SELECT
        payplan.pay_id,
        activity.act_name,        
        payplan.pay_order,
        payplan.pay_money,
        payplan.pay_user,
        payplan.pay_objective,
        payplan.pay_date,
        payplan.pay_step,
        payplan.pay_bill,
        budgettype.bgt_name
      FROM payplan 
        LEFT JOIN activity ON payplan.act_id = activity.act_id
        LEFT JOIN budgettype ON activity.bgt_id = budgettype.bgt_id
      ORDER BY 
        payplan.pay_order DESC
    ";
    $stmt = $this->pdo->query($sql);
    $data = $stmt->fetchAll();
    return $data;
  }

  //ดูการขอใช้เงินทุกใบคำขอ ตามกิจกรรม
  public function getPayPlanByActID($act_id)
  {
    $sql = "
      SELECT
        payplan.pay_id,
        activity.act_name, 
        activity.act_money,       
        payplan.pay_order,
        payplan.pay_money,
        payplan.pay_user,
        payplan.pay_objective,
        payplan.pay_date,
        payplan.pay_step,
        budgettype.bgt_name
      FROM payplan 
        LEFT JOIN activity ON payplan.act_id = activity.act_id
        LEFT JOIN budgettype ON activity.bgt_id = budgettype.bgt_id
      WHERE
        payplan.act_id = :act_id
      ORDER BY 
        payplan.pay_order DESC
    ";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute($act_id);
    $data = $stmt->fetchAll();
    return $data;
  }

  //เพิ่มรายการใบคำขอ
  public function addPayPlan($payplan)
  {
    $sql = "
      INSERT INTO payplan (
        act_id,
        pay_order,
        dep_order,
        pay_money,
        pay_user,
        pay_type,
        pay_objective,
        pay_date,
        person_id,
        pay_step)      
      VALUES (
        :act_id,
        :pay_order,
        :dep_order,
        :pay_money,
        :pay_user,
        :pay_type,
        :pay_objective,
        :pay_date,
        :person_id,
        1)  
    ";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute($payplan);
    return $this->pdo->lastInsertId();
  }

  //เรียกดูรายละเอียดใบคำขอ
  public function getPayOrdByPO($pay_order)
  {
    $sql = "
    SELECT
      payplan.pay_order,
      payplan.pay_money,
      payplan.pay_user,
      payplan.pay_objective,
      payplan.pay_date,
      payplan.pay_step,
      activity.act_id,
      activity.act_name,
      project.pro_name,
      department.dep_name,
      budgettype.bgt_name,
      persons.firstname,
      persons.lastname
    FROM payplan 
      LEFT JOIN activity ON payplan.act_id = activity.act_id
      LEFT JOIN project ON activity.pro_id = project.pro_id
      LEFT JOIN department ON project.dep_id = department.dep_id
      LEFT JOIN budgettype ON activity.bgt_id = budgettype.bgt_id
      LEFT JOIN persons ON payplan.person_id = persons.id
    WHERE 
      payplan.pay_order = :pay_order
    ";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute($pay_order);
    $data = $stmt->fetch();
    return $data;
  }

  //เรียก step ออกมา
  public function getPayStepByID($pay_order)
  {
    $sql = "
    SELECT
      payplan.pay_order,
      activity.act_name,
      payplan.pay_step 
    FROM
      payplan  
      LEFT JOIN activity ON payplan.act_id = activity.act_id
    WHERE
      payplan.pay_order = :pay_order
    ";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute($pay_order);
    $data = $stmt->fetch();
    return $data;
  }

  //update step
  public function updatePayStep($step)
  {
    $sql = "
    UPDATE 
      payplan 
    SET
      pay_step = :pay_step 
    WHERE 
      pay_order = :pay_order
    ";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute($step);
    return 1;
  }

  //ใช้เฉพาะกิจ
  // ดึงค่าเลขครอดสุดท้ายมาแสดง
  public function getLastPayOrder()
  {
    $sql = "
      SELECT
          pay_order       
      FROM
          payplan            
      ORDER BY
          payplan.pay_id
      DESC LIMIT 1       
      ";

    $stmt = $this->pdo->prepare($sql);
    $stmt->execute();
    $data = $stmt->fetch();
    return $data;
  }

  // ดึงข้อมูลไปสร้าง reportPayOrder
  public function getPayOrderToReport($pay_order)
  {
    $sql = "
    SELECT
      payplan.pay_order,
      payplan.dep_order,
      payplan.pay_money,
      payplan.pay_user,
      payplan.pay_type,
      payplan.pay_objective,
      payplan.pay_date,
      payplan.person_id,
      activity.act_id, 
      activity.act_name, 
      activity.pro_id, 
      activity.act_money,
      activity.act_balance,
      project.pro_code,
      project.pro_name,
      project.pro_user,
      project.dep_id,
      department.dep_name,
      department.dep_user,
      department.dep_pos,
      management.man_name,
      management.man_user,
      management.man_pos,
      budgettype.bgt_name
    FROM payplan 
      LEFT JOIN activity ON payplan.act_id = activity.act_id
      LEFT JOIN project ON activity.pro_id = project.pro_id
      LEFT JOIN department ON payplan.dep_order = department.dep_id
      LEFT JOIN management ON department.man_id = management.man_id
      LEFT JOIN budgettype ON activity.bgt_id = budgettype.bgt_id
    WHERE 
      payplan.pay_order = :pay_order
    ";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute($pay_order);
    $data = $stmt->fetch();
    return $data;
  }

  //สรุปจ่ายทั้งหมดเอาไปใช้ในกราฟ
  //สรุปรายเดือน เพื่อส่งให้ json
  public function getPayGraph()
  {
    $sql = "
    SELECT
      SUM(payplan.pay_money) AS sum       
    FROM
      payplan
    ";

    $stmt = $this->pdo->prepare($sql);
    $stmt->execute();
    $data = $stmt->fetch();
    return $data;
  }

  public function getGroupByType($type)
  {
    $sql = "
    SELECT
      SUM(payplan.pay_money) AS sum            
    FROM
      payplan
      LEFT JOIN activity ON payplan.act_id = activity.act_id
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

  //ลองแปลงจาก getGroupByType
    //รวมเงินจากรายการที่เบิกแต่ละประเภทงบประมาณ
  public function getSumPayMoneyGroupByBgt($type)
  {
    $sql = "
    SELECT
      SUM(payplan.pay_money) AS sumPayMoney           
    FROM
      payplan
      LEFT JOIN activity ON payplan.act_id = activity.act_id
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
    //รวมเงินจากรายการที่เบิกแต่ละประเภทงบประมาณ เฉพาะสถานะ 5(พิมพ์เช็คแล้ว)
  public function getSumPayMoneyGroupStepByBgt($type)
  {
    $sql = "
    SELECT
      SUM(payplan.pay_money) AS sumPayMoneyStep           
    FROM
      payplan
      LEFT JOIN activity ON payplan.act_id = activity.act_id
    WHERE
      activity.bgt_id = :bgt_id AND payplan.pay_step = 5
    GROUP BY
      activity.bgt_id        
    ";

    $stmt = $this->pdo->prepare($sql);
    $stmt->execute($type);
    $data = $stmt->fetch();
    return $data;
  }

  //เปลี่ยนยอดเงินที่ขอเบิก
  public function editPayMoney($ID)
  {
    $sql = "
  UPDATE 
    payplan
  SET
    pay_money = :pay_money
  WHERE
    pay_order = :pay_order
  ";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute($ID);
    return 1;
  }

  //เปลี่ยนยอดเงินที่จ่าย
  public function editPayBill($ID)
  {
    $sql = "
  UPDATE 
    payplan
  SET
    pay_step = :pay_step,
    pay_bill = :pay_bill
  WHERE
    pay_order = :pay_order
  ";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute($ID);
    return 1;
  }

  //แก้ไขรายละเอียดใบคำขอ (กลุ่ม ชื่อ วันที่)
  public function editPayPlan($pay_order)
  {
    $sql = "
      UPDATE
        payplan
      SET
        dep_order = :dep_order,
        pay_type = :pay_type,
        pay_user = :pay_user,
        pay_objective = :pay_objective,
        pay_date = :pay_date,
        person_id = :person_id
      WHERE
        pay_order = :pay_order 
    ";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute($pay_order);
    return 1;
  }

  //รวมยอดเงินจากใบเบิก แต่ละกิจกรรม
  public function getSumPayMoneyByAct($act_id)
  {
    $sql = "
    SELECT
      SUM(payplan.pay_money) AS sumPayMoneyAct           
    FROM
      payplan
      LEFT JOIN activity ON payplan.act_id = activity.act_id
    WHERE
      activity.act_id = :act_id     
    ";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute($act_id);
    $data = $stmt->fetch();
    return $data;
  }

  //รวมยอดเงินจากใบเบิก แต่ละโครงการ
  public function getSumPayMoneyByPro($pro_id)
  {
    $sql = "
    SELECT
      SUM(payplan.pay_money) AS sumPayMoneyPro           
    FROM
      payplan
      LEFT JOIN activity ON payplan.act_id = activity.act_id
    WHERE
      activity.pro_id = :pro_id     
    ";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute($pro_id);
    $data = $stmt->fetch();
    return $data;
  }

  //ดูการขอใช้เงินทุกใบคำขอ
  public function getPayPlanToExcel()
  {
    $sql = "
      SELECT
        payplan.pay_id,
        payplan.pay_order,
        activity.act_name,        
        project.pro_id,        
        project.dep_id,        
        payplan.pay_money,
        payplan.pay_user,
        payplan.pay_objective,
        payplan.pay_date,
        payplan.pay_step,
        payplan.pay_bill,
        budgettype.bgt_name
      FROM payplan 
        LEFT JOIN activity ON payplan.act_id = activity.act_id
        LEFT JOIN budgettype ON activity.bgt_id = budgettype.bgt_id
        LEFT JOIN project ON activity.pro_id = project.pro_id
        LEFT JOIN department ON project.pro_id = department.dep_id
      ORDER BY 
        payplan.pay_order DESC
    ";
    $stmt = $this->pdo->query($sql);
    $data = $stmt->fetchAll();
    return $data;
  }


}
