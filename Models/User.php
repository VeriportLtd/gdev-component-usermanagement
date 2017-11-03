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
 * @property integer Active
 * @property integer Approved
 * @property UserDetails Details
 * @property Role[] Roles
 * @property UserStatus[] Statuses
 */
class User extends Entity
{

    // Database Mapping
    protected static $table = "users";

    public static function fields()
    {
        return [
            "UserId" => ['type' => 'integer', 'primary' => true, 'autoincrement' => true],
            "UserName" => ['type' => 'string', 'required' => true, 'unique' => true],
            "RegistrationDate" => ['type' => 'datetime', 'required' => true],
            "Email" => ['type' => 'string', 'required' => true, 'unique' => true],
            "Password" => ['type' => 'string', 'required' => true],
            "Active" => ['type' => 'integer', 'required' => false],
            "Approved" => ['type' => 'integer', 'required' => false],
        ];
    }

    public static function relations(MapperInterface $mapper, EntityInterface $entity)
    {
        return [
            'Statuses' => $mapper->hasMany($entity, 'Gdev\UserManagement\Models\UserStatus', 'UserId'),
            'Roles' => $mapper->hasManyThrough($entity, 'Gdev\UserManagement\Models\Role', 'Gdev\UserManagement\Models\UserRole', 'RoleId', 'UserId'),
            'Details' => $mapper->hasOne($entity, 'Gdev\UserManagement\Models\UserDetails', 'UserId'),
            'ConfirmationLinks' => $mapper->hasMany($entity, 'Gdev\UserManagement\Models\ConfirmationLink', 'UserId'),
            'PasswordResetLinks' => $mapper->hasMany($entity, 'Gdev\UserManagement\Models\PasswordResetLink', 'UserId'),
            'UserAccessTokens' => $mapper->hasMany($entity, 'Gdev\UserManagement\Models\UserAccessToken', 'UserId'),
            "Businesses" => $mapper->hasManyThrough($entity, 'Data\Models\Business', 'Data\Models\UserBusiness', 'BusinessId', 'UserId'),
            "Threads" => $mapper->hasManyThrough($entity, "Data\Models\Thread", "Data\Models\UserThread", "ThreadId", "UserId")->order(["CreatedAt" => "DESC"]),
            "Messages" => $mapper->hasManyThrough($entity, "Data\Models\Message", "Data\Models\UserMessage", "MessageId", "UserId")->order(["CreatedAt" => "DESC"])
        ];
    }
}