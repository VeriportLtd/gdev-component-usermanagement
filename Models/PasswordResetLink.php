<?php
/**
 * Created by PhpStorm.
 * User: Milan
 * Date: 10.6.2016.
 * Time: 16.04
 */

namespace Gdev\UserManagement\Models;

use DateTime;
use Spot\Entity;
use Spot\EntityInterface;
use Spot\MapperInterface;

/**
 * Class PasswordResetLink
 * @package Models
 *
 * @property integer PasswordResetLinkId
 * @property string Token
 * @property integer UserId
 * @property DateTime ExpirationDate
 * @property integer Used
 */
class PasswordResetLink extends Entity
{

	// Database Mapping
	protected static $table = "password_reset_links";

	public static function fields()
	{
		return [
			"PasswordResetLinkId" => ['type' => 'integer', 'primary' => true, 'autoincrement' => true],
			"Token" => ['type' => 'string', 'required' => true],
			"UserId" => ['type' => 'integer', 'index' => true, 'required' => true],
			"ExpirationDate" => ['type' => 'datetime', 'required' => true],
			"Used" => ['type' => 'integer', 'required' => true],
		];
	}

	public static function relations(MapperInterface $mapper, EntityInterface $entity)
	{
		return [
			'User' => $mapper->belongsTo($entity, 'Gdev\UserManagement\Models\User', 'UserId')
		];
	}
}