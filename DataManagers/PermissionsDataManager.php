<?php

namespace Gdev\UserManagement\DataManagers;

use Gdev\UserManagement\Repositories\PermissionsRepository;

class PermissionsDataManager {

	public static function GetPermissions() {
		return PermissionsRepository::getInstance()->all();
	}

	public static function GetPermissionById($permissionId) {
		return PermissionsRepository::getInstance()->get($permissionId);
	}

	public static function InsertPermission($model) {
		return PermissionsRepository::getInstance()->save($model);
	}

	public static function UpdatetPermission($model) {
		return PermissionsRepository::getInstance()->save($model);
	}

	public static function DeletePermission($permissionId) {
		return PermissionsRepository::getInstance()->delete($permissionId);
	}

}