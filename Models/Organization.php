<?php

namespace Gdev\UserManagement\Models;

use Spot\Entity;
use Spot\EntityInterface;
use Spot\MapperInterface;

/**
 * Class Organization
 * @package Models
 *
 * @property integer OrganizationId
 * @property string Name
 */
class Organization extends Entity
{

    // Database Mapping
    protected static $table = "users";


    public static function fields()
    {
        return [
            "OrganizationId" => ['type' => 'integer', 'primary' => true, 'autoincrement' => true],
            "Name" => ['type' => 'string', 'required' => true, 'unique' => true]
        ];
    }

    public static function relations(MapperInterface $mapper, EntityInterface $entity)
    {
        return [
            'Users' => $mapper->hasMany($entity, 'Gdev\UserManagement\Models\User', 'UserId'),
        ];
    }
}