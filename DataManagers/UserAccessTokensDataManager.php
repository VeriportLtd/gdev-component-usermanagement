<?php

namespace Gdev\UserManagement\DataManagers;

use Gdev\UserManagement\Models\UserAccessToken;
use Gdev\UserManagement\Repositories\UserAccessTokensRepository;

class UserAccessTokensDataManager {

	public static function CreateUserAccessToken($model) {

		return UserAccessTokensRepository::getInstance()->save($model);
	}

	public static function RemoveUserAccessToken($userId) {
		return UserAccessTokensRepository::getInstance()->where(['UserId' => $userId])->delete();
	}

	public static function GetActiveToken($userId, $endDate = null) {
		return UserAccessTokensRepository::getInstance()->where(['UserId' => $userId, 'EndDate' => $endDate])->first();
	}

}