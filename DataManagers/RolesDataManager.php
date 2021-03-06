<?php

namespace Gdev\UserManagement\DataManagers;

use Gdev\UserManagement\Repositories\RolesRepository;

class RolesDataManager {

	public static function GetRoles($offset = null, $limit = null) {
		return RolesRepository::getInstance()->all()->with(["Permissions", "UserRoles"])->limit($limit, $offset);
	}

	public static function InsertRole($model) {
		return RolesRepository::getInstance()->save($model);
	}

	public static function UpdatetRole($model) {
		return RolesRepository::getInstance()->save($model);
	}

	public static function DeleteRole($roleId) {
		return RolesRepository::getInstance()->delete(['RoleId' => $roleId]);
	}

	public static function GetRoleById($roleId) {
		return RolesRepository::getInstance()->get($roleId);
	}

}