<?php
/**
 * Created by PhpStorm.
 * User: nikola
 * Date: 9.6.16.
 * Time: 19.19
 */

namespace Gdev\UserManagement\ApiControllers;

use Gdev\UserManagement\DataManagers\RolesDataManager;

class RolesApiController {

	public static function GetRoles() {
		return RolesDataManager::GetRoles();
	}

	public static function InsertRole($model) {
		return RolesDataManager::InsertRole($model);
	}

	public static function UpdatetRole($model) {
		return RolesDataManager::UpdatetRole($model);
	}

	public static function DeleteRole($roleId) {
		return RolesDataManager::DeleteRole($roleId);
	}

	public static function GetRoleById($roleId) {
		return RolesDataManager::GetRoleById($roleId);
	}


}