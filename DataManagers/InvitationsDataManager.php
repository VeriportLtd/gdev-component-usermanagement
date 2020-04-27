<?php

namespace Gdev\UserManagement\DataManagers;

use Gdev\UserManagement\Repositories\InvitationsRepository;

class InvitationsDataManager {

    public static function GetInvitations() {
        return InvitationsRepository::getInstance()->all()->with(["Roles", "User"]);
    }

    public static function DeleteInvitation($invitationId) {
        return InvitationsRepository::getInstance()->delete(["InvitationId" => $invitationId]);
    }

    public static function GetInvitation($invitationId) {
        return InvitationsRepository::getInstance()->get($invitationId);
    }

    public static function GetInvitationByToken($token) {
        return InvitationsRepository::getInstance()->first(["Token" => $token]);
    }

    public static function SaveInvitation($model) {
        return InvitationsRepository::getInstance()->save($model);
    }

}