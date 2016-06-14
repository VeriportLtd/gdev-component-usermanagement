<?php
/**
 * Created by PhpStorm.
 * User: nikola
 * Date: 9.6.16.
 * Time: 19.19
 */

namespace Gdev\UserManagement\ApiControllers;

use Business\Security\Users;
use Gdev\UserManagement\DataManagers\UsersDataManager;

class UsersApiController {

	public static function GetUsers() {
		return UsersDataManager::GetUsers();
	}

	public static function GetUserById($userId) {
		return UsersDataManager::GetUserById($userId);
	}

	public static function GetUserByUserName($userName) {
		return UsersDataManager::GetUserByUserName($userName);
	}


	public static function InsertUser($model) {
		return UsersDataManager::InsertUser($model);
	}

	public static function UpdateUser($model) {
		return UsersDataManager::UpdateUser($model);
	}

	public static function DeleteUser($userId){
		return UsersDataManager::DeleteUser($userId);
	}

	public static function GetUserByEmail($email) {
		return UsersDataManager::GetUserByEmail($email);
	}

	public static function Login($email = null, $password = null, $token = null) {
		if ($token == null) {
			return Users::Login($email, $password);
		} else {
			return Users::LoginWithToken($token);
		}
	}


}