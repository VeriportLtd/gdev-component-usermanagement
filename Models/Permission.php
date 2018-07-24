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
 * Class Permission
 * @package Models
 *
 * @property integer PermissionId
 * @property string Caption
 * @property string Description
 * @property PermissionDescription[] PermissionDescriptions
 * @property RolePermission[] RolePermissions
 */
class Permission extends Entity
{
	// Database Mapping
	protected static $table = "permissions";

	public static function fields()
	{
		return [
			"PermissionId" => ['type' => 'integer', 'primary' => true],
			"Caption" => ['type' => 'string', 'required' => true],
			"Description" => ['type' => 'string', 'required' => true]
		];
	}

	public static function relations(MapperInterface $mapper, EntityInterface $entity)
	{
		return [
			'PermissionDescriptions' => $mapper->hasMany($entity, UserManagementDependencyResolver::getInstance()->Resolve("PermissionDescription"), 'PermissionId'),
			'RolePermissions' => $mapper->hasMany($entity, UserManagementDependencyResolver::getInstance()->Resolve("Permission"), 'PermissionId'),
		];
	}
}