<?php
namespace Ncw\Models;

use Ncw\Controllers\Db;

class Ref extends Db {

	public function getRefsAll() {
		$sql = "
			SELECT
				refs.id,
				refs.title
			FROM 
				refs
			ORDER BY
				id
		";
		$stmt = $this->pdo->query($sql);
		$data = $stmt->fetchAll();
		return $data;
	}

	public function getRefByGroup($group_id) {
		$sql = "
		SELECT
			refs.ref_id,
			refs.title
		FROM 
			refs
		WHERE 
			refs.ref_group_id = :ref_group_id
		";
		$stmt = $this->pdo->prepare($sql);
    $stmt->execute($group_id);
    $data = $stmt->fetchAll();
    return $data;
	}

	public function getRefTitleByID($ID) {
		$sql = "
		SELECT
			refs.title
		FROM 
			refs
		WHERE 
			refs.ref_group_id = :ref_group_id AND refs.ref_id = :ref_id
		";
		$stmt = $this->pdo->prepare($sql);
    $stmt->execute($ID);
    $data = $stmt->fetchAll();
    return $data[0];
	}


}
