<?php

namespace Gdev\UserManagement\DataManagers;

use Data\Repositories\UserBusinessesRepository;
use Gdev\UserManagement\Models\User;
use Gdev\UserManagement\Repositories\UserRolesRepository;
use Gdev\UserManagement\Repositories\UsersRepository;
use Gdev\UserManagement\Repositories\UserStatusesRepository;

class UsersDataManager
{

//Static Methods
    public static function GetFilteredList($start, $length, $columns, $order, $search, $organizationId, $roleWeight)
    {
        return UsersRepository::GetFilteredList($start, $length, $columns, $order, $search, $organizationId, $roleWeight);
    }

    public static function GetUsers($offset = null, $limit = null, $organizationId = null)
    {
        $wheres = [];
        if (!is_null($organizationId)) {
            $wheres['OrganizationId'] = $organizationId;
        }
        return UsersRepository::getInstance()->all()->with(["Roles", "Details"])->where($wheres)->limit($limit, $offset);
    }

    public static function GetActiveUsers($offset = null, $limit = null, $organizationId = null)
    {
        $wheres = ['Active' => 1];
        if (!is_null($organizationId)) {
            $wheres['OrganizationId'] = $organizationId;
        }
        return UsersRepository::getInstance()->all()->with(["Roles", "Details"])->where($wheres)->limit($limit, $offset);
    }

    public static function GetNotApprovedUsers($offset = null, $limit = null, $organizationId = null)
    {
        $wheres = ['Approved' => false];
        if (!is_null($organizationId)) {
            $wheres['OrganizationId'] = $organizationId;
        }
        return UsersRepository::getInstance()->all()->with(["Roles", "Details"])->where($wheres)->limit($limit, $offset);
    }

    public static function GetUserById($userId)
    {

        return UsersRepository::getInstance()->where(['UserId' => $userId])->with(["Roles", "Details", "Businesses", "Threads"])->first();
    }

    public static function GetUserByUserName($userName)
    {
        return UsersRepository::getInstance()->where(['UserName' => $userName])->with(["Roles", "Details"])->first();
    }

    public static function GetUserByEmail($email)
    {
        return UsersRepository::getInstance()->where(['Email' => $email])->with(["Roles", "Details"])->first();
    }

    public static function InsertUser($model)
    {
        return UsersRepository::getInstance()->save($model);
    }

    public static function UpdateUser($model)
    {
        return UsersRepository::getInstance()->save($model);
    }

    public static function DeleteUser($userId)
    {
        return UsersRepository::getInstance()->delete(['UserId' => $userId]);
    }

    public static function GetUsersByCurrentStatus($statusId)
    {
        $result = [];
        $statuses = UserStatusesRepository::getInstance()->all()->where(["UserStatusTypeId" => $statusId, "DateTo" => null])->with(["User"])->execute();
        if (count($statuses) > 0) {
            foreach ($statuses as $status) {
                $result[] = $status->User;
            }
        }
        return $result;
    }

    public static function GetUsersByUserId($userIds)
    {
        $users = implode(',', $userIds);
        return UsersRepository::getInstance()->all()->whereFieldSql("UserId", "IN ($users)")->with(["Businesses", "Threads", "Roles"])->execute();
    }

    public static function GetUsersWithLesserRoles($roleWeight)
    {
        // $result = [];
        $users = UsersRepository::getInstance()
            ->query("
                SELECT * FROM users u 
                INNER JOIN user_roles ur ON ur.UserId = u.UserId INNER JOIN roles r ON ur.RoleId = r.RoleId AND r.Weight >= :roleWeight", ["roleWeight" => $roleWeight]);
        return $users;

    }

    public static function GetUsersForSelectedBusinesses($businessIds)
    {
        $businessIds = implode(",", $businessIds);
        $userBusinesses = UserBusinessesRepository::getInstance()->all()->whereFieldSql("BusinessId", "IN ($businessIds)")->with(["User"])->execute();
        $users = [];
        foreach ($userBusinesses as $userBusiness) {
            $users[] = $userBusiness->User;
        }
        return $users;
    }

    /**
     * @param $roleIds
     *
     * @return array|User[]
     */
    public static function GetUsersForSelectedRoles($roleIds = [])
    {
        $roles = implode(',', $roleIds);
        $userRoles = UserRolesRepository::getInstance()->all()->whereFieldSql("RoleId", "IN ($roles)")->with(["User"])->execute();
        $users = [];
        foreach ($userRoles as $userRole) {
            $users[] = $userRole->User;
        }
        return $users;
    }

    public static function GetLastLoggedInUser($minWeight)
    {
        return UsersRepository::GetLastLoggedInUser($minWeight);
    }

    public static function GetAllUsers()
    {
        return UsersRepository::getInstance()->all();
    }

    /**
     * @param int[] $businessIds
     * @param int $allLiveChatDataPermission
     * @param int $liveChatDataPermission
     *
     * @return int[]
     */
    public static function GetUsersWithAbilityToViewLiveChat($businessIds, $allLiveChatDataPermission, $liveChatDataPermission): array
    {
        $users = [];
        $businessIds = implode(',', $businessIds);
        $query = "SELECT u.* from users u INNER JOIN user_roles ur ON u.UserId=ur.UserId INNER JOIN role_permissions rp ON ur.RoleId = rp.RoleId AND rp.PermissionId=$liveChatDataPermission INNER JOIN user_businesses ub ON u.UserId=ub.UserId  AND ub.BusinessId IN ($businessIds)";
        $allowedLiveChatUsers = UsersRepository::getInstance()->query($query);
        $query = "SELECT u.* from users u INNER JOIN user_roles ur ON u.UserId=ur.UserId INNER JOIN role_permissions rp ON ur.RoleId = rp.RoleId AND rp.PermissionId=$allLiveChatDataPermission";
        $allowedAllLiveChatUsers = UsersRepository::getInstance()->query($query);
        foreach ($allowedLiveChatUsers as $allowedLiveChatUser) {
            $users[$allowedLiveChatUser->UserId] = $allowedLiveChatUser;
        }
        foreach ($allowedAllLiveChatUsers as $allowedAllLiveChatUser) {
            if (!array_key_exists($allowedAllLiveChatUser->UserId, $users)) {
                $users[] = $allowedAllLiveChatUser;
            }
        }
        return array_values($users);
    }
//Static Methods End
}