<?php
/**
 * Created by PhpStorm.
 * User: Milan
 * Date: 10.6.2016.
 * Time: 16.02
 */

namespace Gdev\UserManagement\Models;

use Gdev\UserManagement\Components\UserManagementDependencyResolver;
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
 * @property integer Protected
 */
class RolePermission extends Entity
{

	// Database Mapping
	protected static $table = "role_permissions";

	public static function fields()
	{
		return [
			"RolePermissionId" => ['type' => 'integer', 'primary' => true, 'autoincrement' => true],
			"RoleId" => ['type' => 'integer', 'required' => true],
			"PermissionId" => ['type' => 'integer', 'required' => true],
			"Protected" => ['type' => 'integer', 'required' => true]
		];
	}

	public static function relations(MapperInterface $mapper, EntityInterface $entity)
	{
		return [
			'Role' => $mapper->belongsTo($entity, UserManagementDependencyResolver::getInstance()->Resolve("Role"), 'RoleId'),
			'Permission' => $mapper->belongsTo($entity, UserManagementDependencyResolver::getInstance()->Resolve("Permission"), 'PermissionId'),
		];
	}
}