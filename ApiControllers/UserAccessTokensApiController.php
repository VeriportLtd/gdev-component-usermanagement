<?php
/**
 * Created by PhpStorm.
 * User: nikola
 * Date: 9.6.16.
 * Time: 19.19
 */

namespace Gdev\UserManagement\ApiControllers;

use Gdev\UserManagement\DataManagers\UserAccessTokensDataManager;

class UserAccessTokensApiController {

	public static function CreateUserAccessToken($model) {

		return UserAccessTokensDataManager::CreateUserAccessToken($model);
	}

	public static function GetToken($token) {

		return UserAccessTokensDataManager::GetToken($token);
	}

	public static function RemoveUserAccessToken($userId) {
		return UserAccessTokensDataManager::RemoveUserAccessToken($userId);
	}

}