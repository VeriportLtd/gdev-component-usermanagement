<?php

namespace Gdev\UserManagement\DataManagers;

use Gdev\UserManagement\Models\RolePermission;
use Gdev\UserManagement\Repositories\RolePermissionsRepository;

class RolePermissionsDataManager {

	public static function GetRolesPermissions() {
		return RolePermissionsRepository::getInstance()->all();
	}

	public static function InsertRolesPermission($model) {
		return RolePermissionsRepository::getInstance()->save($model);
	}

	public static function UpdateRolesPermission($model) {
		return RolePermissionsRepository::getInstance()->save($model);
	}

	public static function DeleteRolesPermission($id) {
		return RolePermissionsRepository::getInstance()->delete($id);
	}

	/**
	 * @param $roleId
	 * @return RolePermission
	 */
	public static function GetRolePermissions($roleId) {
		return RolePermissionsRepository::getInstance()->where(['RoleId' => $roleId])->all();
	}

}