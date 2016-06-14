<?php
/**
 * Created by PhpStorm.
 * User: nikola
 * Date: 9.6.16.
 * Time: 19.19
 */

namespace Gdev\UserManagement\ApiControllers;

use Gdev\UserManagement\DataManagers\PasswordResetLinkDataManager;

class PasswordResetLinksApiController {

	public static function InsertPasswordResetLink($passwordResetLink) {
		return PasswordResetLinkDataManager::InsertPasswordResetLink($passwordResetLink);
	}

	public static function GetPasswordResetLink($token) {
		return PasswordResetLinkDataManager::GetPasswordResetLink($token);
	}

	public static function UpdatePasswordResetLink($model) {
		return PasswordResetLinkDataManager::UpdatePasswordResetLink($model);
	}

	public static function GetUserResetPasswordLink($guid) {
		return PasswordResetLinkDataManager::GetUserResetPasswordLink($guid);
	}

	public static function GetUserResetPasswordLinkByUserId($userId) {
		return PasswordResetLinkDataManager::GetUserResetPasswordLinkByUserId($userId);
	}

	public static function DeleteUserResetPasswordLink($passwordResetLinkId) {
		return PasswordResetLinkDataManager::DeleteUserResetPasswordLink($passwordResetLinkId);
	}

}