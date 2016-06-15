<?php

namespace Gdev\UserManagement\DataManagers;

use Gdev\UserManagement\Repositories\RolesRepository;

class RolesDataManager {

	public static function GetRoles() {
		return RolesRepository::getInstance()->all();
	}

}