<?php
/**
 * Created by PhpStorm.
 * User: Milan
 * Date: 10.6.2016.
 * Time: 15.26
 */

namespace Gdev\UserManagement\Models;

use DateTime;
use Spot\Entity;
use Spot\EntityInterface;
use Spot\MapperInterface;

/**
 * Class UserDetail
 * @package Models
 *
 * @property integer UserDetailId
 * @property integer UserId
 * @property string FirstName
 * @property string LastName
 * @property integer Gender
 * @property DateTime DateOfBirth
 * @property string Picture
 */
class UserDetail extends Entity {

    // Database Mapping
    protected static $table = "user_details";

    public static function fields() {
        return [
            "UserDetailId" => ['type' => 'integer', 'primary' => true, 'autoincrement' => true],
            "UserId" => ['type' => 'integer', 'required' => true, 'unique' => true],
            "FirstName" => ['type' => 'string', 'required' => true],
            "LastName" => ['type' => 'string', 'required' => true],
            "Gender" => ['type' => 'integer'],
            "DateOfBirth" => ['type' => 'datetime'],
            "Picture" => ['type' => 'string'],
        ];
    }

    public static function relations(MapperInterface $mapper, EntityInterface $entity) {
        return [
            'User' => $mapper->belongsTo($entity, 'Gdev\UserManagement\Models\User', 'UserId'),
        ];
    }
}