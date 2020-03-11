<?php

namespace Gdev\UserManagement\Models;

use Spot\Entity;
use Spot\EntityInterface;
use Spot\MapperInterface;

/**
 * Class Permission
 * @package Models
 *
 * @property integer PermissionId
 * @property string Caption
 * @property string Description
 * @property PermissionDescription[] PermissionDescriptions
 * @property RolePermission[] RolePermissions
 */
class Permission extends Entity
{
    // Database Mapping
    protected static $table = 'permissions';

    public static function fields()
    {
        return [
            'PermissionId' => ['type' => 'integer', 'primary' => true],
            'Caption' => ['type' => 'string', 'required' => true],
            'Description' => ['type' => 'string', 'required' => true],
        ];
    }

    public static function relations(MapperInterface $mapper, EntityInterface $entity)
    {
        return [
            'PermissionDescriptions' => $mapper->hasMany($entity, PermissionDescription::class, 'PermissionId'),
            'RolePermissions' => $mapper->hasMany($entity, RolePermission::class, 'PermissionId')
        ];
    }
}