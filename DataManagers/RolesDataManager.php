<?php

namespace Gdev\UserManagement\DataManagers;

use Gdev\UserManagement\Repositories\RolesRepository;

class RolesDataManager {

	public static function GetRoles($userId) {
		return RolesRepository::getInstance()->where(['UserId' => $userId])->all();
	}


}