<?php
namespace Ncw\Models;

use Ncw\Controllers\Db;

class Project extends Db
{

  public function getAllProjects()
  {
    $sql = "
      SELECT
        project.pro_id,
        project.pro_name,
        project.dep_id,
        department.dep_name
      FROM project 
        LEFT JOIN department ON project.dep_id = department.dep_id
      ORDER BY pro_id
    ";
    $stmt = $this->pdo->query($sql);
    $data = $stmt->fetchAll();
    return $data;
  }

  public function addProject($project)
  {
    $sql = "
      INSERT INTO project (pro_name,dep_id,create_at) VALUES (:pro_name,:dep_id,'')
    ";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute($project);
    return $this->pdo->lastInsertId();
  }

  // ดึงข้อมูลโครงการตาม pro_id
  public function getProjectById($id)
  {
    $sql = "
      SELECT
        project.pro_id,
        project.pro_name,
        project.dep_id,
        department.dep_name
      FROM project 
        LEFT JOIN department ON project.dep_id = department.dep_id
      WHERE project.pro_id = :pro_id
    ";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute($id);
    $data = $stmt->fetch();
    return $data;
  }

  // อัปเดตข้อมูลโครงการ
  public function updateProject($project)
  {
    $sql = "
      UPDATE project SET pro_name = :pro_name, dep_id = :dep_id WHERE pro_id = :pro_id
    ";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute($project);
    return 1;
  }

  // ลบข้อมูลโครงการ
  public function deleteProject($id)
  {
    $sql = "
      DELETE FROM project WHERE pro_id = :pro_id
    ";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute($id);
    return 1;
  }

  // ดึงข้อมูลสรุปยอดเงินตามโครงการ
  public function getProByGroup()
  {
    $sql = "
    SELECT
      SUM(activity.act_money) AS pro_money,
      SUM(activity.act_balance) AS pro_balance,
      project.pro_id,
      project.pro_name,
      department.dep_name             
    FROM
      activity
      LEFT JOIN project ON activity.pro_id = project.pro_id  
      LEFT JOIN department ON project.dep_id = department.dep_id  
    GROUP BY
      project.pro_id       
    ";

    $stmt = $this->pdo->prepare($sql);
    $stmt->execute();
    $data = $stmt->fetchAll();
    return $data;
  }
}
