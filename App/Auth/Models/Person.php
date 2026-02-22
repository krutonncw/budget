<?php

namespace Ncw\Auth\Models;

use Ncw\Controllers\Db;

class Person extends Db
{

	public function getAllPersons()
	{
		$sql = "
		SELECT
			persons.id,
			persons.firstname,
			persons.lastname,
			persons.dob,
			persons.salary,
			persons.avatar,
			refs.title AS gender,
			department.dep_name AS dep_name,
			users.username,
			users.password
		FROM 
			persons
			LEFT JOIN refs ON persons.gender_id = refs.id
			LEFT JOIN department ON persons.dep_id = department.dep_id	
			LEFT JOIN users ON persons.id = users.person_id	
		ORDER BY
			persons.id
			DESC
		";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute();
		$data = $stmt->fetchAll();
		return $data;
	}

	public function addPerson($person)
	{
		$sql = "
		INSERT INTO persons (
		  firstname,
		  lastname,
		  dob,
		  gender_id,
		  dep_id,
		  salary,
		  avatar)
	  VALUE (
      	  :firstname,
		  :lastname,
		  :dob,
		  :gender_id,
		  :dep_id,
		  :salary,
		  :avatar)
		";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute($person);
		return 1;
	}

	public function updatePerson($person)
	{
		$sql = "
		UPDATE 
			persons 
		SET
			firstname = :firstname, 
			lastname = :lastname, 
			gender_id = :gender_id, 
			dep_id = :dep_id, 
			avatar = :avatar				
		WHERE 
			id = :id
		";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute($person);
		return 1;
	}

	public function deletePerson($id)
	{
		$sql = "
			DELETE FROM persons WHERE id = ?
		";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute([$id]);
		return 1;
	}

	public function getPersonById($id)
	{
		$sql = "
		SELECT
			persons.id,
			persons.firstname,
			persons.lastname,
			persons.dob,
			persons.salary,
			persons.gender_id,
			persons.avatar,
			persons.dep_id,
			refs.title AS gender,
			department.dep_name AS dep_name,
			users.username
		FROM 
			persons
			LEFT JOIN refs ON persons.gender_id = refs.id
			LEFT JOIN department ON persons.dep_id = department.dep_id
			LEFT JOIN users ON persons.id = users.person_id
		WHERE 
			persons.id = ?
		";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute([$id]);
		$data = $stmt->fetchAll();
		return $data[0];
	}

	//ใช้เฉพาะกิจ
	// ดึงค่าเลขครอดสุดท้ายมาแสดง
	public function getLastPersonId()
	{
		$sql = "
		SELECT
				id     
		FROM
				persons       
		ORDER BY
				persons.id
		DESC LIMIT 1       
		";

		$stmt = $this->pdo->prepare($sql);
		$stmt->execute();
		$data = $stmt->fetch();
		return $data;
	}
}
