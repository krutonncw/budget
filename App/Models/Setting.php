<?php

namespace Ncw\Models;

use Ncw\Controllers\Db;

class Setting extends Db
{
	public function getSetting()
	{
		$sql = "
		SELECT
		  setting.set_id,
		  setting.sys_name,
		  setting.school_name,
		  setting.logo_url,
		  setting.title_name,
		  setting.year_name,
		  setting.dir_name,
		  setting.man_name,
		  setting.plan_name,
		  setting.menu_project,
		  setting.menu_activity,
		  setting.menu_payplan
	  FROM 
	  	  setting 
	  WHERE
		  setting.set_id = 1
		";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute();
		$data = $stmt->fetch();
		return $data;
	}	

	public function updateSetting($setting)
	{
		$setParts = [];
		$params = [];
		foreach ($setting as $key => $value) {
			if ($key !== 'set_id') {
				$setParts[] = "$key = :$key";
				$params[":$key"] = $value;
			}
		}
		$params[':set_id'] = $setting['set_id'];
		$sql = "UPDATE setting SET " . implode(', ', $setParts) . " WHERE set_id = :set_id";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute($params);
		if ($stmt) {
			return 1;
		} else {
			return 0;
		}
	}

}