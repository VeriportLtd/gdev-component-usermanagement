<?php

namespace Gdev\UserManagement\ApiControllers;

use Gdev\UserManagement\DataManagers\InvitationRolesDataManager;

class InvitationRolesApiController {

	public static function SaveInvitationRole($model) {
		return InvitationRolesDataManager::SaveInvitationRole($model);
	}

	public static function GetInvitationRoles($invitationId) {
		return InvitationRolesDataManager::GetInvitationRoles($invitationId);
	}

	public static function DeleteInvitationRole($invitationRoleId) {
		return InvitationRolesDataManager::DeleteInvitationRole($invitationRoleId);
	}

}