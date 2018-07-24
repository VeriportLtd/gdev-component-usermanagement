<?php

namespace Gdev\UserManagement\Models;

use DateTime;
use Gdev\UserManagement\Components\UserManagementDependencyResolver;
use Spot\Entity;
use Spot\EntityInterface;
use Spot\MapperInterface;

/**
 * Class Invitation
 * @package Models
 *
 * @property integer InvitationId
 * @property integer SenderId
 * @property integer RegisteredUserId
 * @property string Token
 * @property string Email
 * @property DateTime ExpirationDate
 * @property DateTime InvitationDate
 * @property boolean Anonymous
 * @property User User
 * @property UserDetail UserDetail
 * @property Role[] Roles
 */
class Invitation extends Entity
{

    // Database Mapping
    protected static $table = "invitations";

    public static function fields()
    {
        return [
            "InvitationId" => ['type' => 'integer', 'primary' => true, 'autoincrement' => true],
            "Token" => ['type' => 'string'],
            "ExpirationDate" => ['type' => 'datetime'],
            "Email" => ['type' => 'string'],
            "SenderId" => ['type' => 'integer'],
            "RegisteredUserId" => ['type' => 'integer'],
            "InvitationDate" => ['type' => 'datetime'],
            "Anonymous" => ['type' => 'boolean'],
        ];
    }

    public static function relations(MapperInterface $mapper, EntityInterface $entity)
    {
        return [
            'Sender' => $mapper->belongsTo($entity, UserManagementDependencyResolver::getInstance()->Resolve("User"), 'SenderId'),
            'User' => $mapper->belongsTo($entity, UserManagementDependencyResolver::getInstance()->Resolve("User"), 'RegisteredUserId'),
            'Roles' => $mapper->hasManyThrough($entity, UserManagementDependencyResolver::getInstance()->Resolve("Role"), 'Gdev\UserManagement\Models\InvitationRole', 'RoleId', 'InvitationId'),
        ];
    }

}