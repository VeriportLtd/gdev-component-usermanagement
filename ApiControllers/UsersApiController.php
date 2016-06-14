<?php
/**
 * Created by PhpStorm.
 * User: nikola
 * Date: 9.6.16.
 * Time: 19.19
 */

namespace Gdev\UserManagement\ApiControllers;

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

}