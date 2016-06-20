<?php
/**
 * Created by PhpStorm.
 * User: nikola
 * Date: 9.6.16.
 * Time: 19.19
 */

namespace Gdev\UserManagement\ApiControllers;

use Gdev\UserManagement\DataManagers\UserStatusesDataManager;

class UserStatusesApiController {

	public static function InsertUserStatus($model) {
		return UserStatusesDataManager::InsertUserStatus($model);
	}

	public static function UpdateUserStatus($userStatus) {
		return UserStatusesDataManager::UpdateUserStatus($userStatus);
	}

	public static function GetUserStatuses($userId) {
		return UserStatusesDataManager::GetUserStatuses($userId);
	}

	public static function DeleteUserStatus($userStatusId) {
		return UserStatusesDataManager::DeleteUserStatus($userStatusId);
	}

}