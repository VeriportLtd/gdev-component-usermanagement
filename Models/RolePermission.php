<?php

namespace Gdev\UserManagement\Models;

use Spot\Entity;
use Spot\EntityInterface;
use Spot\MapperInterface;


/**
 * Class RolePermission
 * @package Models
 *
 * @property integer RolePermissionId
 * @property integer RoleId
 * @property integer PermissionId
 * @property bool Protected
 */
class RolePermission extends Entity
{

    // Database Mapping
    protected static $table = 'role_permissions';

    public static function fields()
    {
        return [
            'RolePermissionId' => ['type' => 'integer', 'primary' => true, 'autoincrement' => true],
            'RoleId' => ['type' => 'integer', 'required' => true],
            'PermissionId' => ['type' => 'integer', 'required' => true],
            'Protected' => ['type' => 'boolean', 'required' => true, 'default' => true]
        ];
    }

    public static function relations(MapperInterface $mapper, EntityInterface $entity)
    {
        return [
            'Role' => $mapper->belongsTo($entity, Role::class, 'RoleId'),
            'Permission' => $mapper->belongsTo($entity, Permission::class, 'PermissionId'),
        ];
    }
}