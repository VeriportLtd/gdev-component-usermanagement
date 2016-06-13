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
 * Class RoleDescription
 * @package Models
 *
 * @property integer RoleDescriptionId
 * @property integer RoleId
 * @property string Name
 * @property string Description
 */
class RoleDescription extends Entity {

    // Database Mapping
    protected static $table = "role_descriptions";

    public static function fields() {
        return [
            "RoleDescriptionId" => ['type' => 'integer', 'primary' => true, 'autoincrement' => true],
            "RoleId" => ['type' => 'integer', 'required' => true],
            "Name" => ['type' => 'string', 'required' => true],
            "Description" => ['type' => 'string', 'required' => true]
        ];
    }

    public static function relations(MapperInterface $mapper, EntityInterface $entity) {
        return [
            'Role' => $mapper->belongsTo($entity, 'Gdev\UserManagement\Models\Role', 'RoleId')
        ];
    }
}