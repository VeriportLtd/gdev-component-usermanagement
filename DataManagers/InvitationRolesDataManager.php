<?php

namespace Gdev\UserManagement\DataManagers;

use Gdev\UserManagement\Repositories\InvitationRolesRepository;


class InvitationRolesDataManager {

	public static function InsertInvitationRole($userRole) {
		return InvitationRolesRepository::getInstance()->save($userRole);
	}

	public static function SaveInvitationRole($model) {
		return InvitationRolesRepository::getInstance()->save($model);
	}

	public static function GetInvitationRoles($invitationId) {
		return InvitationRolesRepository::getInstance()->all()->where(['InvitationId' => $invitationId])->execute();
	}

	public static function DeleteInvitationRole($invitationRoleId) {
		return InvitationRolesRepository::getInstance()->delete(['InvitationRoleId' => $invitationRoleId]);
	}


}