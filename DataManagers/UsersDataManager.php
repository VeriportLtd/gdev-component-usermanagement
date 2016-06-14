<?php

namespace Gdev\UserManagement\DataManagers;

use Gdev\UserManagement\Models\UserAccessToken;
use Gdev\UserManagement\Repositories\PasswordResetLinksRepository;
use Gdev\UserManagement\Repositories\RolePermissionsRepository;
use Gdev\UserManagement\Repositories\RolesRepository;
use Gdev\UserManagement\Repositories\UserAccessTokensRepository;
use Gdev\UserManagement\Repositories\UserRolesRepository;
use Gdev\UserManagement\Repositories\UsersRepository;

class UsersDataManager {

	public static function GetUsers() {
		return UsersRepository::getInstance()->all();
	}

	public static function GetUserById($userId) {
		return UsersRepository::getInstance()->get($userId);
	}

	public static function GetUserByUserName($userName) {
		return UsersRepository::getInstance()->where(['Username' => $userName])->first();
	}

	public static function GetUserByEmail($email) {
		return UsersRepository::getInstance()->where(['Email' => $email])->first();
	}

	public static function InsertUser($model) {
		return UsersRepository::getInstance()->save($model);
	}

	public static function UpdateUser($model) {
		return UsersRepository::getInstance()->save($model);
	}

	public static function DeleteUser($userId){
		return UsersRepository::getInstance()->delete($userId);
	}

}