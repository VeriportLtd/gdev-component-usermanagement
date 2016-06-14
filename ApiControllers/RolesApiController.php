<?php
/**
 * Created by PhpStorm.
 * User: nikola
 * Date: 9.6.16.
 * Time: 19.19
 */

namespace Gdev\UserManagement\ApiControllers;

use Gdev\UserManagement\DataManagers\RolesDataManager;

class RolesApiController {

	public static function GetRoles($userId) {
		return RolesDataManager::GetRoles($userId);
	}

}