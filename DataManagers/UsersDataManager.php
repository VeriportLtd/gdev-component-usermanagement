<?php

namespace Gdev\UserManagement\DataManagers;

use Gdev\UserManagement\Models\UserAccessToken;
use Gdev\UserManagement\Repositories\PasswordResetLinksRepository;
use Gdev\UserManagement\Repositories\RolePermissionsRepository;
use Gdev\UserManagement\Repositories\RolesRepository;
use Gdev\UserManagement\Repositories\UserAccessTokensRepository;
use Gdev\UserManagement\Repositories\UserRolesRepository;
use Gdev\UserManagement\Repositories\UsersRepository;

class UsersDataManager {

	public static function GetUsers() {
		return UsersRepository::getInstance()->all();
	}

	public static function GetUserById($userId) {
		return UsersRepository::getInstance()->get($userId);
	}

	public static function GetUserByUserName($userName) {
		return UsersRepository::getInstance()->where(['Username' => $userName])->first();
	}


	public static function InsertUser($model) {
		return UsersRepository::getInstance()->save($model);
	}

	public static function UpdateUser($model) {
		return UsersRepository::getInstance()->save($model);
	}

	public static function DeleteUser($userId){
		return UsersRepository::getInstance()->delete($userId);
	}


	public static function GetRolesPermissions() {
		return RolePermissionsRepository::getInstance()->all();
	}

	public static function InsertRolesPermission($model) {
		return RolePermissionsRepository::getInstance()->save($model);
	}

	public static function UpdateRolesPermission($model) {
		return RolePermissionsRepository::getInstance()->save($model);
	}

	public static function DeleteRolesPermission($id) {
		return RolePermissionsRepository::getInstance()->delete($id);
	}


	public static function GetUserAccessToken($userId, $endDate = null) {
		return UserAccessTokensRepository::getInstance()->where(['UserId' => $userId, 'EndDate' => $endDate])->first();
	}

	/**
	 * Generates and saves new Access Token for User. Returns false if failed, or new Token Id if successful.
	 *
	 * @param int $userId
	 * @return int|bool
	 */
	public static function CreateUserAccessToken($userId) {

		$token = new UserAccessToken();
		$token->Token = Tokens::CreateToken();
		$token->UserId = $userId;
		$token->StartDate = date("Y-m-d H:i:s");
		$token->EndDate = null;

		return UserAccessTokensRepository::getInstance()->save($token);
	}

	public static function RemoveUserAccessToken($userId) {
		return UserAccessTokensRepository::getInstance()->where(['UserId' => $userId])->delete($token);
	}


	public static function GetRoles($userId) {
		return RolesRepository::getInstance()->where(['UserId' => $userId])->all();
	}

	public static function GetRolePermissions($roleId) {
		return RolePermissionsRepository::getInstance()->where(['RoleId' => $roleId])->all();
	}

	public static function InsertUserRole($userRole) {
		return UserRolesRepository::getInstance()->save($userRole);
	}

	public static function UpdateUserRole($userRole) {
		return UserRolesRepository::getInstance()->save($userRole);
	}

	public static function GetUserByEmail($email) {
		return UserRolesRepository::getInstance()->where(['Email' => $email])->first();
	}

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
		return PasswordResetLinksRepository::getInstance()->delete($passwordResetLinkId);
	}

}