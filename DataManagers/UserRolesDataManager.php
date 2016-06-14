<?php

namespace Gdev\UserManagement\DataManagers;

use Gdev\UserManagement\Repositories\UserRolesRepository;


class UserRolesDataManager {

	public static function InsertUserRole($userRole) {
		return UserRolesRepository::getInstance()->save($userRole);
	}

	public static function UpdateUserRole($userRole) {
		return UserRolesRepository::getInstance()->save($userRole);
	}

	public static function GetUserByEmail($email) {
		return UserRolesRepository::getInstance()->where(['Email' => $email])->first();
	}

	public static function GetUserRoles($userId) {
		return UserRolesRepository::getInstance()->where(['UserId' => $userId])->all();
	}


}