<?php

namespace Gdev\UserManagement\ApiControllers;

use Gdev\UserManagement\DataManagers\InvitationsDataManager;
use Gdev\UserManagement\Models\Invitation;

/**
 * Class InvitationsApiController
 * @package Business\ApiControllers
 */
class InvitationsApiController {

    // Invitation
    public static function GetInvitations()
    {
        return InvitationsDataManager::GetInvitations();
    }

    /**
     * @param $invitationId
     * @return Invitation
     */
    public static function GetInvitation($invitationId) {
        return InvitationsDataManager::GetInvitation($invitationId);
    }

    /**
     * @param $token
     * @return Invitation
     */
    public static function GetInvitationByToken($token) {
        return InvitationsDataManager::GetInvitationByToken($token);
    }

    public static function DeleteInvitation($artistId) {
        return InvitationsDataManager::DeleteInvitation($artistId);
    }

    public static function SaveInvitation($artist) {
        return InvitationsDataManager::SaveInvitation($artist);
    }



}