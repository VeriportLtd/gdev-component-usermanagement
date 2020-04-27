<?php
/**
 * Created by PhpStorm.
 * User: nikola
 * Date: 9.6.16.
 * Time: 19.19
 */

namespace Gdev\UserManagement\ApiControllers;

use Gdev\UserManagement\DataManagers\PasswordResetLinksDataManager;

class PasswordResetLinksApiController {

	public static function InsertPasswordResetLink($passwordResetLink) {
		return PasswordResetLinksDataManager::InsertPasswordResetLink($passwordResetLink);
	}

	public static function GetPasswordResetLink($token) {
		return PasswordResetLinksDataManager::GetPasswordResetLink($token);
	}

	public static function UpdatePasswordResetLink($model) {
		return PasswordResetLinksDataManager::UpdatePasswordResetLink($model);
	}

	public static function GetUserResetPasswordLink($guid) {
		return PasswordResetLinksDataManager::GetUserResetPasswordLink($guid);
	}

	public static function GetUserResetPasswordLinkByUserId($userId) {
		return PasswordResetLinksDataManager::GetUserResetPasswordLinkByUserId($userId);
	}

	public static function DeleteUserResetPasswordLink($passwordResetLinkId) {
		return PasswordResetLinksDataManager::DeleteUserResetPasswordLink($passwordResetLinkId);
	}

}