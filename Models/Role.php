<?php
/**
 * Created by PhpStorm.
 * User: Milan
 * Date: 10.6.2016.
 * Time: 16.01
 */

namespace Gdev\UserManagement\Models;

use Spot\Entity;
use Spot\EntityInterface;
use Spot\MapperInterface;

/**
 * Class Role
 * @package Models
 *
 * @property integer RoleId
 * @property integer Protected
 * @property integer Active
 * @property RoleDescription[] RoleDescriptions
 * @property Permission[] Permissions
 * @property UserRole[] UserRoles
 */
class Role extends Entity {

    // Database Mapping
    protected static $table = "roles";

    public static function fields() {
        return [
            "RoleId" => ['type' => 'integer', 'primary' => true, 'autoincrement' => true],
            "Protected" => ['type' => 'integer', 'required' => true],
            "Active" => ['type' => 'integer', 'required' => true]
        ];
    }

    public static function relations(MapperInterface $mapper, EntityInterface $entity) {
        return [
            'RoleDescriptions' => $mapper->hasMany($entity, 'Gdev\UserManagement\Models\RoleDescription', 'RoleId'),
            'Permissions' => $mapper->hasManyThrough($entity, 'Gdev\UserManagement\Models\Permission', 'Gdev\UserManagement\Models\RolePermission', 'PermissionId', 'RoleId'),
            'UserRoles' => $mapper->hasMany($entity, 'Gdev\UserManagement\Models\UserRole', 'UserId')
        ];
    }
}