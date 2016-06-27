<?php

namespace Gdev\UserManagement\ApiControllers;

use Gdev\UserManagement\DataManagers\ConfirmationLinksDataManager;

class ConfirmationLinksApiController {

	public static function InsertConfirmationLink($confirmationLink) {
		return ConfirmationLinksDataManager::InsertConfirmationLink($confirmationLink);
	}

	public static function GetConfirmationLink($token) {
		return ConfirmationLinksDataManager::GetConfirmationLink($token);
	}

}