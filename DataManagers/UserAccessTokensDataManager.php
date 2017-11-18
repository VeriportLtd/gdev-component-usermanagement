<?php

namespace Gdev\UserManagement\DataManagers;

use DateTime;
use Gdev\UserManagement\Repositories\UserAccessTokensRepository;

class UserAccessTokensDataManager
{

    public static function CreateUserAccessToken($model)
    {

        return UserAccessTokensRepository::getInstance()->save($model);
    }

    public static function RemoveUserAccessToken($userId)
    {
        return UserAccessTokensRepository::getInstance()->delete(['UserId' => $userId]);
    }

    public static function GetActiveToken($userId, $endDate = null)
    {
        return UserAccessTokensRepository::getInstance()->where(['UserId' => $userId, 'EndDate' => $endDate])->first();
    }

    public static function GetToken($token)
    {
        return UserAccessTokensRepository::getInstance()->where(['Token' => $token])->first();
    }

    public static function VoidUserAccessToken($userId)
    {
        $token = self::GetActiveToken($userId);
        $token->EndDate = new DateTime();
        if ($token) {
            return UserAccessTokensRepository::getInstance()->save($token);

        } else {
            return null;
        }
    }

}