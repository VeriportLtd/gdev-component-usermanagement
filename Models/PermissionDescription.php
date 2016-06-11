<?php
/**
 * Created by PhpStorm.
 * User: Milan
 * Date: 10.6.2016.
 * Time: 16.02
 */

namespace Gdev\UserManagement\Models;

use Spot\Entity;
use Spot\EntityInterface;
use Spot\MapperInterface;
/**
 * Class PermissionDescription
 * @package Models
 *
 * @property integer PermissionDescriptionId
 * @property integer PermissionId
 * @property string Name
 * @property string Description
 * @property integer LanguageId
 */
class PermissionDescription extends Entity{

	// Database Mapping
	protected static $table = "permissions_descriptions";

	public static function fields() {
		return [
			"PermissionDescriptionId" => ['type' => 'integer', 'primary' => true, 'autoincrement' => true],
			"PermissionId" => ['type' => 'integer', 'required' => true],
			"Name" => ['type' => 'string', 'required' => true],
			"Description" => ['type' => 'string', 'required' => true],
			"LanguageId" => ['type' => 'integer', 'required' => true]
		];
	}

	public static function relations(MapperInterface $mapper, EntityInterface $entity)
	{
		return [
			'Permission' => $mapper->belongsTo($entity, 'Gdev\UserManagement\Models\Permission', 'PermissionId')
		];
	}
}