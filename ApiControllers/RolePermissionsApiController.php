<?php
/**
 * Created by PhpStorm.
 * User: nikola
 * Date: 9.6.16.
 * Time: 19.19
 */

namespace Gdev\UserManagement\ApiControllers;

use Gdev\UserManagement\DataManagers\RolePermissionsDataManager;

class RolePermissionsApiController {

	public static function GetRolesPermissions() {
		return RolePermissionsDataManager::GetRolesPermissions();
	}

	public static function GetRolePermissions($userId) {
		return RolePermissionsDataManager::GetRolePermissions($userId);
	}

	public static function InsertRolesPermission($model) {
		return RolePermissionsDataManager::InsertRolesPermission($model);
	}

	public static function UpdateRolesPermission($model) {
		return RolePermissionsDataManager::InsertRolesPermission($model);
	}

	public static function DeleteRolesPermission($id) {
		return RolePermissionsDataManager::InsertRolesPermission($id);
	}

}