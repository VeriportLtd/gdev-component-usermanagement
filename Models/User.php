<?php

namespace Gdev\UserManagement\Models;

use Data\Models\MVCModel;
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
 * @property string FbAccessToken
 * @property integer Active
 * @property integer Approved
 * @property integer OrganizationId
 * @property UserDetails Details
 * @property Organization Organization
 * @property Role[] Roles
 * @property UserStatus[] Statuses
 * @property Bussiness[] Businesses
 * @property Thread[] Threads
 * @property Message[] Messages
 */
class User extends MVCModel
{

    // Database Mapping
    protected static $table = "users";


    public static function fields()
    {
        return [
            "UserId" => ['type' => 'integer', 'primary' => true, 'autoincrement' => true],
            "UserName" => ['type' => 'string', 'required' => true, 'unique' => true],
            "OrganizationId" => ['type' => 'integer'],
            "RegistrationDate" => ['type' => 'datetime', 'required' => true],
            "Email" => ['type' => 'string', 'required' => true, 'unique' => true],
            "Password" => ['type' => 'string', 'required' => true],
            "FbAccessToken" => ['type' => 'text', 'required' => false],
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
            'Organization' => $mapper->belongsTo($entity, 'Gdev\UserManagement\Models\Organization', 'OrganizationId'),
            'ConfirmationLinks' => $mapper->hasMany($entity, 'Gdev\UserManagement\Models\ConfirmationLink', 'UserId'),
            'PasswordResetLinks' => $mapper->hasMany($entity, 'Gdev\UserManagement\Models\PasswordResetLink', 'UserId'),
            'UserAccessTokens' => $mapper->hasMany($entity, 'Gdev\UserManagement\Models\UserAccessToken', 'UserId'),
            "Businesses" => $mapper->hasManyThrough($entity, 'Data\Models\Business', 'Data\Models\UserBusiness', 'BusinessId', 'UserId'),
            "Threads" => $mapper->hasManyThrough($entity, "Data\Models\MessageThread", "Data\Models\UserThread", "ThreadId", "UserId")->order(["UpdatedAt" => "DESC"]),
            "LastFiveThreads" => $mapper->hasManyThrough($entity, "Data\Models\MessageThread", "Data\Models\UserThread", "ThreadId", "UserId")->order(["UpdatedAt" => "DESC"])->limit(5),
            "Messages" => $mapper->hasManyThrough($entity, "Data\Models\Message", "Data\Models\UserMessage", "MessageId", "UserId")->order(["CreatedAt" => "DESC"])
        ];
    }
}