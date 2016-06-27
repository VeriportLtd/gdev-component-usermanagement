<?php

namespace Gdev\UserManagement\DataManagers;

use Gdev\UserManagement\Repositories\ConfirmationLinksRepository;

class ConfirmationLinksDataManager {

    public static function InsertConfirmationLink($confirmationLink) {
        return ConfirmationLinksRepository::getInstance()->save($confirmationLink);
    }

    public static function GetConfirmationLink($token) {
        return ConfirmationLinksRepository::getInstance()->where(['Token' => $token])->with("User")->first();
    }

}