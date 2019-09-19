<?php
/**
 * Created by PhpStorm.
 * User: nikola
 * Date: 9.6.16.
 * Time: 19.19
 */

namespace Gdev\UserManagement\ApiControllers;

use Business\Enums\RolesEnum;
use Business\Security\Crypt;
use Business\Security\Users;
use Business\Enums\PermissionsEnum;
use Gdev\UserManagement\DataManagers\UserDetailsDataManager;
use Gdev\UserManagement\DataManagers\UsersDataManager;
use Gdev\UserManagement\Models\User;
use Gdev\UserManagement\Models\UserDetails;
use Gdev\UserManagement\Models\UserRole;
use Gdev\UserManagement\Models\UserStatus;

class UsersApiController
{

    /**
     * @param $start
     * @param $length
     * @param $columns
     * @param $order
     * @param $search
     * @param null $organizationId
     * @param null $roleWeight
     * @return \Business\DTO\DTDataDTO
     */
    public static function GetFilteredList($start, $length, $columns, $order, $search, $organizationId = null, $roleWeight = null)
    {
        return UsersDataManager::GetFilteredList($start, $length, $columns, $order, $search, $organizationId, $roleWeight);

    }

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

    /**
     * @param [] $businesses
     * @return int[]
     */
    public static function GetUsersWithAbilityToViewLiveChat($businesses)
    {
        $businessIds = [];
        foreach ($businesses as $business) {
            $businessIds[] = $business->BusinessId;
        }
        return UsersDataManager::GetUsersWithAbilityToViewLiveChat($businessIds, PermissionsEnum::ViewAllLiveChatData, PermissionsEnum::ViewLiveChatData);
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

    public static function GetUsersWithLesserRoles($roleWeight)
    {
        return UsersDataManager::GetUsersWithLesserRoles($roleWeight);
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

    public static function GetLastLoggedInUser($minWeight)
    {
        return UsersDataManager::GetLastLoggedInUser($minWeight);
    }

    public static function GetAllUsers()
    {
        return UsersDataManager::GetAllUsers();
    }
//string $username, string $password, string $email, ?array $userRoles = null, ?string $organizationId = null, ?string $approved = nu, ?int $active = 0, ?int $userStatusId = null, ?string $statusMessage = null
//string $username, string $password, string $email, ?array $userRoles = null, ?int $organizationId = null, ?int $approved = 0, ?int $active = 0, ?int $userStatusId = null, ?string $statusMessage = null
    public static function CreateUser(string $username, string $password, string $email, ?array $userRoles = null, ?string $organizationId = null, ?string $approved = null, ?int $active = 0, ?int $userStatusId = null, ?string $statusMessage = null): ?User
    {
        $user = new User();
        $user->Email = $email;
        $user->Password = Crypt::HashPassword($password);
        $user->UserName = $username;
        $user->RegistrationDate = new \DateTime();
        $user->Approved = $approved;
        $user->Active = $active;

        $organizationId = empty($organizationId) ? null : $organizationId;
        $statusMessage = empty($statusMessage) ? null : $statusMessage;

        // checking organization
        if ($organizationId !== null) {
            if (!\Security::IsSuperAdmin()) {
                $currentUser = UsersApiController::GetUserById(Security::GetCurrentUser()->UserId);
                $organizationId = $currentUser->OrganizationId;
            }
        }
        $user->OrganizationId = $organizationId;
        $status = true;
        $userId = UsersApiController::InsertUser($user);
        $status = $status && $userId > 0;

        if ($status) {
            $userId = (int)$userId;
            if ($userRoles !== null) {
                foreach ($userRoles as $userRoleId) {
                    $userRoleId = (int)$userRoleId;
                    if (in_array($userRoleId, RolesEnum::enum(), true)) {
                        $userRoleModel = new UserRole();
                        $userRoleModel->UserId = $userId;
                        $userRoleModel->RoleId = $userRoleId;
                        $status = UserRolesApiController::InsertUserRole($userRoleModel) && $status;
                    }
                }
            }
            if ($userStatusId !== null) {
                $userStatusModel = new UserStatus();
                $userStatusModel->UserId = $userId;
                $userStatusModel->UserStatusTypeId = $userStatusId;
                $userStatusModel->DateFrom = new \DateTime();
                $userStatusModel->Message = $statusMessage ?: 'No Message';
                $status = UserStatusesApiController::InsertUserStatus($userStatusModel) && $status;
            }
        }
        return $status ? $user : null;
    }

    public static function CreateUserDetails(int $userId, string $firstName, string $lastName, ?string $dateOfBirth = null, ?int $gender = null, ?string $picture = null): bool
    {
        $userDetails = new UserDetails();

        $userDetails->FirstName = $firstName;
        $userDetails->LastName = $lastName;
        $userDetails->DateOfBirth = $dateOfBirth ? \DateTime::createFromFormat('m/d/Y', $dateOfBirth) : null;
        /*    $userDetails->Gender = $gender && in_array($gender, GendersEnum::enum(), true) ? $gender : null;
            $userDetails->Picture = $picture;*/
        $userDetails->UserId = $userId;

        return UsersApiController::InsertUserDetails($userDetails) > 0;

    }


}