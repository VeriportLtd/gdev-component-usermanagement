<?php
/**
 * Created by PhpStorm.
 * User: Milan
 * Date: 10.6.2016.
 * Time: 16.03
 */

namespace Gdev\UserManagement\Models;

use DateTime;
use Spot\Entity;
use Spot\EntityInterface;
use Spot\MapperInterface;

/**
 * Class ConfirmationLink
 * @package Models
 *
 * @property integer ConfirmationLinkId
 * @property integer UserId
 * @property DateTime ExpirationDate
 * @property string ConfirmationLinkGuid
 */
class ConfirmationLink extends Entity
{
	// Database Mapping
	protected static $table = "confirmation_links";

	public static function fields()
	{
		return [
			"ConfirmationLinkId" => ['type' => 'integer', 'primary' => true, 'autoincrement' => true],
			"UserId" => ['type' => 'integer', 'index' => true, 'required' => true],
			"ExpirationDate" => ['type' => 'datetime', 'required' => true],
			"ConfirmationLinkGuid" => ['type' => 'string', 'required' => true],
		];
	}

	public static function relations(MapperInterface $mapper, EntityInterface $entity)
	{
		return [
			'User' => $mapper->belongsTo($entity, 'Gdev\UserManagement\Models\User', 'UserId')
		];
	}
}