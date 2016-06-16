<?php

namespace Gdev\UserManagement\DataManagers;

use Gdev\UserManagement\Repositories\RolesRepository;

class RolesDataManager {

	public static function GetRoles() {
		return RolesRepository::getInstance()->all();
	}

	public static function InsertRole($model) {
		return RolesRepository::getInstance()->save($model);
	}

	public static function UpdatetRole($model) {
		return RolesRepository::getInstance()->save($model);
	}

	public static function DeleteRole($model) {
		return RolesRepository::getInstance()->delete($model);
	}

	public static function GetRoleById($roleId) {
		return RolesRepository::getInstance()->get($roleId);
	}

}