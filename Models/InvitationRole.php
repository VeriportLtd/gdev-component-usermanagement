<?php

namespace Gdev\UserManagement\Models;

use Spot\Entity;
use Spot\EntityInterface;
use Spot\MapperInterface;

/**
 * Class InvitationRole
 * @package Models
 *
 * @property integer InvitationRoleId
 * @property integer InvitationId
 * @property integer RoleId
 */
class InvitationRole extends Entity
{

    // Database Mapping
    protected static $table = "invitation_roles";

    public static function fields()
    {
        return [
            "InvitationRoleId" => ['type' => 'integer', 'primary' => true, 'autoincrement' => true],
            "InvitationId" => ['type' => 'integer', 'index' => true, 'required' => true],
            "RoleId" => ['type' => 'integer', 'index' => true, 'required' => true],
        ];
    }

    public static function relations(MapperInterface $mapper, EntityInterface $entity)
    {
        return [
            'Invitation' => $mapper->belongsTo($entity, 'Gdev\UserManagement\Models\Invitation', 'InvitationId'),
            'Role' => $mapper->belongsTo($entity, 'Gdev\UserManagement\Models\Role', 'RoleId')
        ];
    }
}