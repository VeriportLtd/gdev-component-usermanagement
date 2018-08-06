<?php

namespace Gdev\UserManagement\Models;

use Data\Models\MVCModel;
use DateTime;
use Gdev\UserManagement\Components\UserManagementDependencyResolver;
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
 * @property integer OrganizationId
 * @property UserDetail Details
 * @property Organization Organization
 * @property Role[] Roles
 * @property UserStatus[] Statuses
 * @property Thread[] Threads
 * @property Message[] Messages
 */
class User extends MVCModel
{

    // Database Mapping
    protected static $table = "users";


    public static function fields()
    {
        $fields = [
            "UserId" => ['type' => 'integer', 'primary' => true, 'autoincrement' => true],
            "UserName" => ['type' => 'string', 'required' => true, 'unique' => true],
            "OrganizationId" => ['type' => 'integer'],
            "RegistrationDate" => ['type' => 'datetime', 'required' => true],
            "Email" => ['type' => 'string', 'required' => true, 'unique' => true],
            "Password" => ['type' => 'string', 'required' => true],
            "Active" => ['type' => 'integer', 'required' => false],
            "Approved" => ['type' => 'integer', 'required' => false],
        ];
        return array_merge($fields, parent::fields());
    }

    public static function relations(MapperInterface $mapper, EntityInterface $entity)
    {
        return [
            'Statuses' => $mapper->hasMany($entity, UserManagementDependencyResolver::getInstance()->Resolve("UserStatus"), 'UserId'),
            'Roles' => $mapper->hasManyThrough($entity, UserManagementDependencyResolver::getInstance()->Resolve("Role"), UserManagementDependencyResolver::getInstance()->Resolve("UserRole"), 'RoleId', 'UserId'),
            'Details' => $mapper->hasOne($entity, UserManagementDependencyResolver::getInstance()->Resolve("UserDetail"), 'UserId'),
            'Organization' => $mapper->belongsTo($entity, UserManagementDependencyResolver::getInstance()->Resolve("Organization"), 'OrganizationId'),
            'ConfirmationLinks' => $mapper->hasMany($entity, UserManagementDependencyResolver::getInstance()->Resolve("ConfirmationLink"), 'UserId'),
            'PasswordResetLinks' => $mapper->hasMany($entity, UserManagementDependencyResolver::getInstance()->Resolve("PasswordResetLink"), 'UserId'),
            'UserAccessTokens' => $mapper->hasMany($entity, UserManagementDependencyResolver::getInstance()->Resolve("UserAccessToken"), 'UserId'),
            "Threads" => $mapper->hasManyThrough($entity, UserManagementDependencyResolver::getInstance()->Resolve("MessageThread"), UserManagementDependencyResolver::getInstance()->Resolve("UserThread"), "ThreadId", "UserId")->order(["UpdatedAt" => "DESC"]),
            "LastFiveThreads" => $mapper->hasManyThrough($entity, UserManagementDependencyResolver::getInstance()->Resolve("MessageThread"), UserManagementDependencyResolver::getInstance()->Resolve("UserThread"), "ThreadId", "UserId")->order(["UpdatedAt" => "DESC"])->limit(5),
            "Messages" => $mapper->hasManyThrough($entity, UserManagementDependencyResolver::getInstance()->Resolve("Message"), UserManagementDependencyResolver::getInstance()->Resolve("UserMessage"), "MessageId", "UserId")->order(["CreatedAt" => "DESC"])
        ];
    }
}