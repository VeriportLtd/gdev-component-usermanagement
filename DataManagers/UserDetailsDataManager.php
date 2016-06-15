<?php

namespace Gdev\UserManagement\DataManagers;

use Gdev\UserManagement\Repositories\UserDetailsRepository;

class UserDetailsDataManager {

	public static function InsertUserDetails($model) {
		return UserDetailsRepository::getInstance()->save($model);
	}



}