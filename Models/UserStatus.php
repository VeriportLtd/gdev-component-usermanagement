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
 * Class UserStatus
 * @package Models
 *
 * @property integer UserStatusId
 * @property integer UserId
 * @property integer UserStatusTypeId
 * @property DateTime DateFrom
 * @property DateTime DateTo
 * @property string Message
 */
class UserStatus extends Entity{

	// Database Mapping
	protected static $table = "user_statuses";

	public static function fields() {
		return [
			"UserStatusId" => ['type' => 'integer', 'primary' => true, 'autoincrement' => true],
			"UserId" => ['type' => 'integer', 'index' => true, 'required' => true],
			"UserStatusTypeId" => ['type' => 'integer', 'index' => true, 'required' => true],
			"DateFrom" => ['type' => 'datetime', 'required' => true],
			"DateTo" => ['type' => 'datetime'],
			"Message" => ['type' => 'string', 'required' => true],
		];
	}

	public static function relations(MapperInterface $mapper, EntityInterface $entity) {
		return [
			'User' => $mapper->belongsTo($entity, 'Gdev\UserManagement\Models\User', 'UserId'),
			'UserStatus' => $mapper->belongsTo($entity, 'Gdev\UserManagement\Models\UserStatusType', 'UserStatusTypeId')
		];
	}
}