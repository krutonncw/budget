<?php

namespace Ncw\Auth\Models;

use Ncw\Controllers\Db;

class User extends Db
{
  public function getAllUsers()
  {
    $sql = "
		SELECT
		  users.id,
		  users.person_id,
		  users.username,
		  users.email,
		  users.password,
		  users.role
	  FROM users
	  ORDER BY
		  users.id
	  	DESC
		";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute();
    $data = $stmt->fetchAll();
    return $data;
  }

  protected function checkEmail($email)
  {
    $sql = "
			SELECT 
				email 	
			FROM
				users
			WHERE
				email = :email
		";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindParam("email", $email);
    $stmt->execute();
    $row = $stmt->rowCount();
    print("row=" . $row);
    if ($row > 0) {
      return 1;
    } else {
      return 0;
    }
  }

	public function createUser($user)
	{
		$check = $this->checkEmail($user['email']);
		if ($check == 1) {
			return 0;
			exit;
		} else {
			$user['password'] = password_hash($user['password'], PASSWORD_DEFAULT);

			$sql = "
			INSERT INTO users (
				person_id,
				username,
				email,
				password
			) VALUES (
				:person_id,
				:username,
				:email,
				:password				
			)
		";
			$stmt = $this->pdo->prepare($sql);
			$stmt->execute($user);

			//ประกาศ seesion เพื่อการ login
			// session_start();
			// $id = $this->pdo->lastInsertId();
			// $_SESSION['id'] = $user['person_id'];
			// $_SESSION['username'] = $user['username'];
			// $_SESSION['email'] = $user['email'];
			// $_SESSION['role'] = 4; //สถานะเริ่มสมัครรออนุมัติ
			// $_SESSION['login'] = 1;

			return 1;
		}
	}

	public function checkUser($user)
	{
		$sql = "
			SELECT
				id,
				person_id,
				username,
				email,
				role,
				password
			FROM
				users
			WHERE 
				users.username = ?
			";
			$stmt = $this->pdo->prepare($sql);
			$stmt->execute([$user['username']]);
			$data = $stmt->fetchAll();
			$userDB = $data[0];

		if (password_verify($user['password'], $userDB['password'])) {
			session_start();
			$_SESSION['id'] = $userDB['person_id'];
			$_SESSION['username'] = $userDB['username'];
			$_SESSION['email'] = $userDB['email'];
			$_SESSION['role'] = $userDB['role'];
			$_SESSION['login'] = 1;

			return 1;
		} else {
			return 0;
		}
	}

  public function getUserById($id)
	{
		$sql = "
			SELECT
				id,
				person_id,
				username,
				email,
				role,
				password
			FROM
				users
			WHERE
				users.person_id = ?
		";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute([$id]);//ถ้าผูกค่าด้วยเครื่องหมาย ? ให้ใส่ค่าแบบ array คือใส่ เครื่องหมาย [ตัวแปร]
		$data = $stmt->fetch();
		return $data;
	}

  public function deleteUser($id)
	{
		$sql = "
			DELETE FROM users WHERE person_id = ?
		";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute([$id]);
		return 1;
	}

  public function updateRoleUser($user)
	{
		unset($user['action']); //ตัดตัวแปร action ออกไม่ได้ใช้เนื่องจากเราส่งมาทั้งหมดของ GET ไม่ได้แยก
		$sql = "
			UPDATE users SET
			role = :role 
			WHERE person_id = :id
		";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute($user);
		if ($stmt) {
			return 1;
		} else {
			return 0;
		}
	}

	public function updateUsername($user)
	{
		$sql = "
			UPDATE users SET
			username = :username
			WHERE person_id = :id
		";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute($user);
		if ($stmt) {
			return 1;
		} else {
			return 0;
		}
	}

  public function updatePassword($user)
	{
		//เข้ารหัสผ่านก่อน
		$user['password'] = password_hash($user['password'], PASSWORD_DEFAULT);
		$sql = "
			UPDATE users SET
			password = :password 
			WHERE id = :id
		";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute($user);
		if ($stmt) {
			return 1;
		} else {
			return 0;
		}
	}

}
