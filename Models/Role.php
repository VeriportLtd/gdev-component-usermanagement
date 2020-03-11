<?php

namespace Gdev\UserManagement\Models;

use Spot\Entity;
use Spot\EntityInterface;
use Spot\MapperInterface;

/**
 * Class Role
 * @package Models
 *
 * @property integer RoleId
 * @property boolean Protected
 * @property boolean Active
 * @property string Name
 * @property integer OrganizationId
 * @property Organization Organization
 * @property Permission[] Permissions
 * @property UserRole[] UserRoles
 * @property integer Weight
 */
class Role extends Entity
{

    public const SUPER_ADMIN_ROLE_ID = 1;
    // Database Mapping
    protected static $table = 'roles';

    public static function fields()
    {
        return [
            'RoleId' => ['type' => 'integer', 'primary' => true, 'autoincrement' => true],
            'Name' => ['type' => 'string', 'required' => true],
            'OrganizationId' => ['type' => 'integer'],
            'Protected' => ['type' => 'boolean', 'required' => true],
            'Active' => ['type' => 'boolean', 'required' => true],
            'Weight' => ['type' => 'integer', 'required' => true],
        ];
    }

    public static function relations(MapperInterface $mapper, EntityInterface $entity)
    {
        return [
            'Permissions' => $mapper->hasManyThrough($entity, Permission::class, RolePermission::class, 'PermissionId', 'RoleId'),
            'UserRoles' => $mapper->hasMany($entity, UserRole::class, 'UserId'),
            'Organization' => $mapper->belongsTo($entity, Organization::class, 'OrganizationId'),
        ];
    }


    public function isSuperAdminRole(): bool
    {
        return $this->RoleId === $this::SUPER_ADMIN_ROLE_ID;
    }
}