<?php

namespace Gdev\UserManagement\Models;

use DateTime;
use Spot\Entity;
use Spot\EntityInterface;
use Spot\MapperInterface;

/**
 * Class User
 * @package Models
 *
 * @property integer UserId
 * @property string UserName
 * @property DateTime RegistrationDate
 * @property string Email
 * @property string Password
 */
class User extends Entity
{

	// Database Mapping
	protected static $table = "users";

	public static function fields()
	{
		return [
			"UserId" => ['type' => 'integer', 'primary' => true, 'autoincrement' => true],
			"UserName" => ['type' => 'string', 'required' => true, 'unique' => 'user_email'],
			"RegistrationDate" => ['type' => 'datetime', 'required' => true],
			"Email" => ['type' => 'string', 'required' => true, 'unique' => 'user_email'],
			"Password" => ['type' => 'string', 'required' => true],
		];
	}

	public static function relations(MapperInterface $mapper, EntityInterface $entity)
	{
		return [
			'UserStatus' => $mapper->hasMany($entity, 'Gdev\UserManagement\Models\UserStatus', 'UserId'),
			'UserRole' => $mapper->hasManyThrough($entity, 'Gdev\UserManagement\Models\Role', 'Gdev\UserManagement\Models\UserRole', 'RoleId', 'UserId'),
			'UserDetail' => $mapper->hasOne($entity, 'Gdev\UserManagement\Models\UserDetail', 'UserId'),
			'ConfirmationLink' => $mapper->hasOne($entity, 'Gdev\UserManagement\Models\ConfirmationLink', 'UserId'),
			'PasswordResetLink' => $mapper->hasOne($entity, 'Gdev\UserManagement\Models\PasswordResetLink', 'UserId'),
			'UserAccessToken' => $mapper->hasOne($entity, 'Gdev\UserManagement\Models\UserAccessToken', 'UserId'),
		];
	}
}