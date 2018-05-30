<?php
/**
 * Created by PhpStorm.
 * User: nikola
 * Date: 9.6.16.
 * Time: 19.19
 */

namespace Gdev\UserManagement\ApiControllers;

use Business\Security\Users;
use Gdev\UserManagement\DataManagers\UserDetailsDataManager;
use Gdev\UserManagement\DataManagers\UsersDataManager;
use Gdev\UserManagement\Models\User;
use Gdev\UserManagement\Models\UserDetails;

class UsersApiController
{

    public static function GetActiveUsers($offset = null, $limit = null, $organizationId = null)
    {
        return UsersDataManager::GetActiveUsers($offset, $limit, $organizationId);
    }

    public static function GetUsers($offset = null, $limit = null, $organizationId = null)
    {
        return UsersDataManager::GetUsers($offset, $limit, $organizationId);
    }

    public static function GetNotApprovedUsers($offset = null, $limit = null, $organizationId = null)
    {
        return UsersDataManager::GetNotApprovedUsers($offset, $limit, $organizationId);
    }

    public static function GetUsersByCurrentStatus($statusId)
    {
        return UsersDataManager::GetUsersByCurrentStatus($statusId);
    }

    /**
     * @param $userId
     * @return User
     */
    public static function GetUserById($userId)
    {
        return UsersDataManager::GetUserById($userId);
    }

    /**
     * @param $userName
     * @return User
     */
    public static function GetUserByUserName($userName)
    {
        return UsersDataManager::GetUserByUserName($userName);
    }

    public static function InsertUser($model)
    {
        return UsersDataManager::InsertUser($model);
    }


    public static function InsertUserDetails($model)
    {
        return UserDetailsDataManager::InsertUserDetails($model);
    }

    public static function UpdateUser($model)
    {
        return UsersDataManager::UpdateUser($model);
    }

    public static function DeleteUser($userId)
    {
        return UsersDataManager::DeleteUser($userId);
    }

    public static function GetUserByEmail($email)
    {
        return UsersDataManager::GetUserByEmail($email);
    }

    public static function Login($email = null, $password = null, $token = null)
    {
        if ($token == null) {
            return Users::Login($email, $password);
        } else {
            return Users::LoginWithToken($token);
        }
    }

    public static function GetUsersWithLesserRoles($roleWeight, $organizationId = null)
    {
        return UsersDataManager::GetUsersWithLesserRoles($roleWeight, $organizationId);
    }

    public static function GetUsersForSelectedBusinesses($businessIds = [])
    {
        if (empty($businessIds)) {
            return [];
        }
        return UsersDataManager::GetUsersForSelectedBusinesses($businessIds);
    }

    public static function GetUsersByUserId($userIds = [])
    {
        if (empty($userIds)) {
            return [];
        }

        return UsersDataManager::GetUsersByUserId($userIds);
    }

    public static function GetUsersForSelectedRoles($roleIds)
    {
        if (empty($roleIds)) {
            return [];
        }
        return UsersDataManager::GetUsersForSelectedRoles($roleIds);
    }
    public static function GetLastLoggedInUser($minWeight) {
        return UsersDataManager::GetLastLoggedInUser($minWeight);
    }


}