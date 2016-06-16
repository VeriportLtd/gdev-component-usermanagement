<?php
/**
 * Created by PhpStorm.
 * User: nikola
 * Date: 9.6.16.
 * Time: 19.19
 */

namespace Gdev\UserManagement\ApiControllers;

use Gdev\UserManagement\DataManagers\RolePermissionsDataManager;
use Gdev\UserManagement\Models\RolePermission;

class RolePermissionsApiController {

	public static function GetRolesPermissions() {
		return RolePermissionsDataManager::GetRolesPermissions();
	}

	/**
	 * @param $roleId
	 * @return RolePermission
	 */
	public static function GetRolePermissions($roleId) {
		return RolePermissionsDataManager::GetRolePermissions($roleId);
	}

	public static function InsertRolesPermission($model) {
		return RolePermissionsDataManager::InsertRolesPermission($model);
	}

	public static function UpdateRolesPermission($model) {
		return RolePermissionsDataManager::InsertRolesPermission($model);
	}

	public static function DeleteRolesPermission($id) {
		return RolePermissionsDataManager::DeleteRolesPermission($id);
	}

}