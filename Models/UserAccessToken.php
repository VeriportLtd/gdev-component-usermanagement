<?php
/**
 * Created by PhpStorm.
 * User: Milan
 * Date: 10.6.2016.
 * Time: 16.01
 */

namespace Gdev\UserManagement\Models;

use DateTime;
use Gdev\UserManagement\Components\UserManagementDependencyResolver;
use Spot\Entity;
use Spot\EntityInterface;
use Spot\MapperInterface;
/**
 * Class UserAccessToken
 * @package Models
 *
 * @property integer UserAccessTokenId
 * @property string Token
 * @property integer UserId
 * @property DateTime StartDate
 * @property DateTime EndDate
 */
class UserAccessToken extends Entity{

	// Database Mapping
	protected static $table = "user_access_tokens";

	public static function fields() {
		return [
			"UserAccessTokenId" => ['type' => 'integer', 'primary' => true, 'autoincrement' => true],
			"Token" => ['type' => 'string', 'required' => true, 'unique' => true],
			"UserId" => ['type' => 'integer', 'required' => true],
			"StartDate" => ['type' => 'datetime', 'required' => true],
			"EndDate" => ['type' => 'datetime'],
		];
	}

	public static function relations(MapperInterface $mapper, EntityInterface $entity)
	{
		return [
			'User' => $mapper->belongsTo($entity, UserManagementDependencyResolver::getInstance()->Resolve("User"), 'UserId')
		];
	}

	// Helpers

	public function IsActive() {
		return $this->EndDate === null;
	}
}