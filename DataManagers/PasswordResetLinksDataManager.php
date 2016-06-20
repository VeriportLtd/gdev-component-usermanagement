<?php

namespace Gdev\UserManagement\DataManagers;

use Gdev\UserManagement\Repositories\PasswordResetLinksRepository;

class PasswordResetLinkDataManager {

	public static function InsertPasswordResetLink($passwordResetLink) {
		return PasswordResetLinksRepository::getInstance()->save($passwordResetLink);
	}

	public static function GetPasswordResetLink($token) {
		return PasswordResetLinksRepository::getInstance()->where(['Token' => $token])->first();
	}

	public static function UpdatePasswordResetLink($model) {
		return PasswordResetLinksRepository::getInstance()->save($model);
	}

	public static function GetUserResetPasswordLink($guid) {
		return PasswordResetLinksRepository::getInstance()->where(['Guid' => $guid])->first();
	}

	public static function GetUserResetPasswordLinkByUserId($userId) {
		return PasswordResetLinksRepository::getInstance()->where(['UserId' => $userId])->first();
	}

	public static function DeleteUserResetPasswordLink($passwordResetLinkId) {
		return PasswordResetLinksRepository::getInstance()->delete(['PasswordResetLinkId' => $passwordResetLinkId]);
	}

}