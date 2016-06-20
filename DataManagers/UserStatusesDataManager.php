<?php

namespace Gdev\UserManagement\DataManagers;

use Gdev\UserManagement\Repositories\UserStatusesRepository;


class UserStatusesDataManager {

	public static function InsertUserStatus($userStatus) {
		return UserStatusesRepository::getInstance()->save($userStatus);
	}

	public static function UpdateUserStatus($userStatus) {
		return UserStatusesRepository::getInstance()->save($userStatus);
	}

	public static function GetUserStatuses($userId) {
		return UserStatusesRepository::getInstance()->all()->where(['UserId' => $userId])->execute();
	}

	public static function DeleteUserStatus($userStatusId) {
		return UserStatusesRepository::getInstance()->delete(['UserStatusId' => $userStatusId]);
	}


}