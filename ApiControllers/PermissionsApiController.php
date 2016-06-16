<?php
/**
 * Created by PhpStorm.
 * User: nikola
 * Date: 9.6.16.
 * Time: 19.19
 */

namespace Gdev\UserManagement\ApiControllers;

use Gdev\UserManagement\DataManagers\PermissionsDataManager;

class PermissionsApiController {

	public static function GetPermissions() {
		return PermissionsDataManager::GetPermissions();
	}

	public static function InsertRole($model) {
		return PermissionsDataManager::InsertPermission($model);
	}

	public static function UpdatetRole($model) {
		return PermissionsDataManager::UpdatetPermission($model);
	}

	public static function GetPermissionById($permissionId) {
		return PermissionsDataManager::GetPermissionById($permissionId);
	}

	public static function DeletePermission($permissionId) {
		return PermissionsDataManager::DeletePermission($permissionId);
	}

}