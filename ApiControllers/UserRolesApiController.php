<?php
/**
 * Created by PhpStorm.
 * User: nikola
 * Date: 9.6.16.
 * Time: 19.19
 */

namespace Gdev\UserManagement\ApiControllers;

use Gdev\UserManagement\DataManagers\UserRolesDataManager;

class UserRolesApiController {

	public static function InsertUserRole($model) {
		return UserRolesDataManager::InsertUserRole($model);
	}

	public static function UpdateUserRole($userRole) {
		return UserRolesDataManager::UpdateUserRole($userRole);
	}

	public static function GetUserByEmail($email) {
		return UserRolesDataManager::GetUserByEmail($email);
	}

}