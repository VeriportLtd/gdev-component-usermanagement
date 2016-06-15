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
 * @property UserDetail Details
 * @property Role[] Roles
 * @property UserStatus[] Statuses
 */
class User extends Entity {

    // Database Mapping
    protected static $table = "users";

    public static function fields() {
        return [
            "UserId" => ['type' => 'integer', 'primary' => true, 'autoincrement' => true],
            "UserName" => ['type' => 'string', 'required' => true, 'unique' => true],
            "RegistrationDate" => ['type' => 'datetime', 'required' => true],
            "Email" => ['type' => 'string', 'required' => true, 'unique' => true],
            "Password" => ['type' => 'string', 'required' => true],
        ];
    }

    public static function relations(MapperInterface $mapper, EntityInterface $entity) {
        return [
            'Statuses' => $mapper->hasMany($entity, 'Gdev\UserManagement\Models\UserStatus', 'UserId'),
            'Roles' => $mapper->hasManyThrough($entity, 'Gdev\UserManagement\Models\Role', 'Gdev\UserManagement\Models\UserRole', 'RoleId', 'UserId'),
            'Details' => $mapper->hasOne($entity, 'Gdev\UserManagement\Models\UserDetail', 'UserId'),
            'ConfirmationLinks' => $mapper->hasMany($entity, 'Gdev\UserManagement\Models\ConfirmationLink', 'UserId'),
            'PasswordResetLinks' => $mapper->hasMany($entity, 'Gdev\UserManagement\Models\PasswordResetLink', 'UserId'),
            'UserAccessTokens' => $mapper->hasMany($entity, 'Gdev\UserManagement\Models\UserAccessToken', 'UserId'),
        ];
    }
}