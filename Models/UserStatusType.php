<?php
/**
 * Created by PhpStorm.
 * User: Milan
 * Date: 10.6.2016.
 * Time: 15.57
 */

namespace Gdev\UserManagement\Models;

use Spot\Entity;
use Spot\EntityInterface;
use Spot\MapperInterface;
/**
 * Class UserStatusesType
 * @package Models
 *
 * @property integer UserStatusTypeId
 * @property string Caption 
 */
class UserStatusType extends Entity{

	// Database Mapping
	protected static $table = "user_status_types";

	public static function fields() {
		return [
			"UserStatusTypeId" => ['type' => 'integer', 'primary' => true, 'autoincrement' => true],
			"Caption" => ['type' => 'string', 'index' => true, 'required' => true]
		];
	}

	public static function relations(MapperInterface $mapper, EntityInterface $entity) {
		return [
			'UserStatus' => $mapper->hasOne($entity, 'Gdev\UserManagement\Models\UserStatus', 'UserStatusId')
		];
	}}