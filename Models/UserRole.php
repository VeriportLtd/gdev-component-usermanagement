<?php
/**
 * Created by PhpStorm.
 * User: Milan
 * Date: 10.6.2016.
 * Time: 15.27
 */

namespace Gdev\UserManagement\Models;

use Gdev\UserManagement\Components\UserManagementDependencyResolver;
use Spot\Entity;
use Spot\EntityInterface;
use Spot\MapperInterface;
/**
 * Class UserRole
 * @package Models
 *
 * @property integer UserRoleId
 * @property integer UserId
 * @property integer RoleId
 */
class UserRole extends Entity{

	// Database Mapping
	protected static $table = "user_roles";

	public static function fields() {
		return [
			"UserRoleId" => ['type' => 'integer', 'primary' => true, 'autoincrement' => true],
			"UserId" => ['type' => 'integer', 'index' => true, 'required' => true],
			"RoleId" => ['type' => 'integer', 'index' => true, 'required' => true],
		];
	}

	public static function relations(MapperInterface $mapper, EntityInterface $entity) {
		return [
			'User' => $mapper->belongsTo($entity, UserManagementDependencyResolver::getInstance()->Resolve("User"), 'UserId'),
			'Role' => $mapper->belongsTo($entity, UserManagementDependencyResolver::getInstance()->Resolve("Role"), 'RoleId')
		];
	}
}