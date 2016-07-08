<?php

namespace Gdev\UserManagement\DataManagers;

use Gdev\UserManagement\Models\UserAccessToken;
use Gdev\UserManagement\Repositories\PasswordResetLinksRepository;
use Gdev\UserManagement\Repositories\RolePermissionsRepository;
use Gdev\UserManagement\Repositories\RolesRepository;
use Gdev\UserManagement\Repositories\UserAccessTokensRepository;
use Gdev\UserManagement\Repositories\UserRolesRepository;
use Gdev\UserManagement\Repositories\UsersRepository;
use Gdev\UserManagement\Repositories\UserStatusesRepository;

class UsersDataManager {

	public static function GetUsers() {
		return UsersRepository::getInstance()->all()->with(["Roles", "Details"]);
	}

	public static function GetActiveUsers() {
		return UsersRepository::getInstance()->all()->with(["Roles", "Details"])->where(['Active' => 1]);
	}

	public static function GetNotApprovedUsers() {
		return UsersRepository::getInstance()->all()->with(["Roles", "Details"])->where(['Approved' => null]);
	}

	public static function GetUserById($userId) {
		return UsersRepository::getInstance()->where(['UserId' => $userId])->with(["Roles", "Details"])->first();
	}

	public static function GetUserByUserName($userName) {
		return UsersRepository::getInstance()->where(['Username' => $userName])->with(["Roles", "Details"])->first();
	}

	public static function GetUserByEmail($email) {
		return UsersRepository::getInstance()->where(['Email' => $email])->with(["Roles", "Details"])->first();
	}

	public static function InsertUser($model) {
		return UsersRepository::getInstance()->save($model);
	}

	public static function UpdateUser($model) {
		return UsersRepository::getInstance()->save($model);
	}

	public static function DeleteUser($userId) {
		return UsersRepository::getInstance()->delete(['UserId' => $userId]);
	}

	public static function GetUsersByCurrentStatus($statusId) {
		$result = [];
		$statuses = UserStatusesRepository::getInstance()->all()->where(["UserStatusTypeId" => $statusId, "DateTo" => null])->with(["User"])->execute();
		if(count($statuses) > 0) {
			foreach($statuses as $status) {
				$result[] = $status->User;
			}
		}
		return $result;
	}

}