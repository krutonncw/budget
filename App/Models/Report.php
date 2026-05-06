<?php

namespace Ncw\Models;

use Ncw\Controllers\Db;

class Report extends Db
{
  //ดูโครงการทั้งหมด เพื่อเอาไปแสดงในรายงานสรุปการใช้งบประมาณ
  public function getAllProjects()
  {
    $sql = "
      SELECT
       project.*,
       department.dep_name
      FROM project 
       LEFT JOIN department ON project.dep_id = department.dep_id
       LEFT JOIN management ON department.man_id = management.man_id
      ORDER BY 
        project.pro_id ASC
    ";
    $stmt = $this->pdo->query($sql);
    $data = $stmt->fetchAll();
    // print_r($data);exit;
    return $data;
  }

  //ดูกิจกรรม จากโครงการ เพื่อเอาไปแสดงในรายงานสรุปการใช้งบประมาณ
  public function getAllActivity($pro_id)
  {
    $sql = "
      SELECT
       activity.*,
        budgettype.bgt_name
      FROM activity
      JOIN budgettype ON activity.bgt_id = budgettype.bgt_id  
      WHERE
        activity.pro_id = :pro_id    
      ORDER BY 
        activity.act_id ASC
    ";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute(['pro_id' => $pro_id]);
    // $stmt->execute($pro_id);
    $data = $stmt->fetchAll();
    return $data;
  }

  //ดูเงินแต่ละประเภท ได้งบประมาณเท่าไหร่ คงเหลือเท่าไหร่ เพื่อเอาไปแสดงในรายงานสรุปการใช้งบประมาณ
  public function getAllBudgetTypes()
  {
    $sql = "
      SELECT
       budgettype.*
      FROM budgettype 
      wHERE
        budgettype.status = 1
      ORDER BY 
        budgettype.bgt_id ASC
    ";
    $stmt = $this->pdo->query($sql);
    $data = $stmt->fetchAll();
    return $data;
  }

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

  //รายงานสรุปการใช้งบประมาณ แสดงโครงการ กิจกรรม ประเภทงบประมาณ เงินที่จัดสรร เงินที่เบิกแล้ว และเงินคงเหลือ ใช้ในหน้า reportActionPlan.php
  public function getActionPlanReport()
  {
    $sql = "SELECT 
                project.pro_id, 
                project.pro_name, 
                project.pro_code, 
                department.dep_name, 
                activity.act_id, 
                activity.act_name, 
                activity.act_money, 
                activity.act_balance, 
                budgettype.bgt_name, 
                CONCAT(persons.firstname, ' ', persons.lastname) AS act_responsible, 
                COALESCE(payment.total_spent, 0) AS spent, 
                COALESCE(activity.act_balance, activity.act_money - COALESCE(payment.total_spent, 0)) AS remaining
            FROM activity
            LEFT JOIN project ON activity.pro_id = project.pro_id
            LEFT JOIN department ON project.dep_id = department.dep_id
            LEFT JOIN budgettype ON activity.bgt_id = budgettype.bgt_id
            LEFT JOIN persons ON activity.create_by = persons.id
            -- ใช้ Subquery ร่วมกับ Group By เพียงครั้งเดียวแล้วค่อยนำมา Join
            LEFT JOIN (
                SELECT act_id, SUM(pay_money) AS total_spent 
                FROM payplan 
                GROUP BY act_id
            ) AS payment ON activity.act_id = payment.act_id
            ORDER BY project.pro_id, activity.act_id";

    $stmt = $this->pdo->query($sql);
    // แนะนำให้ใช้ FETCH_ASSOC เพื่อลดขนาดของ Array ผลลัพธ์ลงครึ่งหนึ่ง
    return $stmt->fetchAll();
  }

  // public function getActionPlanReport()
  // {
  //   $sql = "
  //     SELECT
  //       project.pro_id,
  //       project.pro_name,
  //       project.pro_code,
  //       department.dep_name,
  //       activity.act_id,
  //       activity.act_name,
  //       activity.act_money,
  //       activity.act_balance,
  //       budgettype.bgt_name,
  //       CONCAT(persons.firstname, ' ', persons.lastname) AS act_responsible,
  //       COALESCE(
  //         (SELECT SUM(pay_money) FROM payplan WHERE act_id = activity.act_id),
  //         0
  //       ) AS spent,
  //       COALESCE(
  //         activity.act_balance,
  //         activity.act_money - COALESCE((SELECT SUM(pay_money) FROM payplan WHERE act_id = activity.act_id), 0)
  //       ) AS remaining
  //     FROM activity
  //       LEFT JOIN project ON activity.pro_id = project.pro_id
  //       LEFT JOIN department ON project.dep_id = department.dep_id
  //       LEFT JOIN budgettype ON activity.bgt_id = budgettype.bgt_id
  //       LEFT JOIN persons ON activity.create_by = persons.id
  //     ORDER BY project.pro_id, activity.act_id
  //   ";

  //   $stmt = $this->pdo->query($sql);
  //   $data = $stmt->fetchAll();
  //   return $data;
  // }
}
