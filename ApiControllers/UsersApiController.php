<?php

namespace Gdev\UserManagement\ApiControllers;

use Business\Enums\RolesEnum;
use Business\Security\Crypt;
use Business\Security\Users;
use Business\Enums\PermissionsEnum;
use Gdev\UserManagement\DataManagers\UserDetailsDataManager;
use Gdev\UserManagement\DataManagers\UsersDataManager;
use Gdev\UserManagement\Models\ConfirmationLink;
use Gdev\UserManagement\Models\User;
use Gdev\UserManagement\Models\UserDetails;
use Gdev\UserManagement\Models\UserRole;
use Gdev\UserManagement\Models\UserStatus;
use Business\Middleware\MailNotifications\MailNotificationDto;
use Business\Middleware\MailNotifications\MailNotificationFactory;
use View\Mail\UserRegisterMailView;
use ViewModel\Mail\UserRegisterMailViewModel;
use Business\DTO\SenderDTO;
use Business\DTO\RecipientDTO;
use Business\Utilities\Config\Config;
use Security;

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
     *
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
     *
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
     *
     * @return User
     */
    public static function GetUserById($userId)
    {
        return UsersDataManager::GetUserById($userId);
    }

    /**
     * @param $userName
     *
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

    public static function Login(?string $username = null, ?string $password = null, ?string $token = null)
    {
        return $token == null ? Users::Login($username, $password) : Users::LoginWithToken($token);
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

    public static function SaveUser(string $username, string $password, string $email, ?array $userRoles = null, ?string $organizationId = null, ?bool $approved = false, ?bool $active = false, ?string $userStatusId = null, ?string $statusMessage = null, int $userId = null): ?User
    {
        if ($userId !== null) {
            $user = UsersApiController::GetUserByUserName($username);
            if (!$user) {
                return null;
            }
        } else {
            $user = new User();
        }
        $user->Email = $email;
        if ($userId !== null) {
            if (!empty($password)) {
                $user->Password = Crypt::HashPassword($password);
            }
        } else {
            $user->Password = Crypt::HashPassword($password);
        }
        $user->UserName = $username;
        $user->RegistrationDate = new \DateTime();
        $user->Approved = $approved;
        $user->Active = $active;

        $organizationId = empty($organizationId) ? null : (int)$organizationId;
        $statusMessage = empty($statusMessage) ? null : $statusMessage;

        $loggedUserId = Security::GetCurrentUserId();
        // checking organization
        if ($organizationId !== null) {
            if (!Security::IsSuperAdmin()) {
                $currentUser = UsersApiController::GetUserById($loggedUserId);
                $organizationId = $currentUser->OrganizationId;
            }
        }
        $user->OrganizationId = $organizationId;
        $status = UsersApiController::InsertUser($user) > 0;

        if ($status) {
            if ($user->UserId !== $loggedUserId) {
                $oldRoles = UserRolesApiController::GetUserRoles($user->UserId);
                if (!empty($userRoles)) {
                    $oldRoleTypes = [];
                    if ($oldRoles->count() > 0) {
                        $oldRoleTypes = $oldRoles->toArray('RoleId');
                        $rolesToBeDeleted = array_diff($oldRoleTypes, $userRoles);
                        if (!empty($rolesToBeDeleted)) {
                            $status = $status && UserRolesApiController::DeleteRoles(['UserId' => $user->UserId, 'RoleId' => array_values($rolesToBeDeleted)]) >= 0;
                        }
                    }

                    $roles = RolesApiController::GetRoles()->toArray('RoleId');
                    foreach ($userRoles as $userRoleId) {
                        $userRoleId = (int)$userRoleId;
                        if (in_array($userRoleId, $roles, true) && !in_array($userRoleId, $oldRoleTypes, true)) {
                            $userRoleModel = new UserRole();
                            $userRoleModel->UserId = $user->UserId;
                            $userRoleModel->RoleId = $userRoleId;
                            $status = UserRolesApiController::InsertUserRole($userRoleModel) && $status;
                        }
                    }
                } elseif ($oldRoles->count() > 0) {
                    $status = $status && UserRolesApiController::DeleteRoles(['UserId' => $user->UserId]) >= 0;
                }
            }
            if (!empty($userStatusId)) {
                $currentUserStatus = UserStatusesApiController::GetCurrentUserStatus($user->UserId);
                $userStatusModel = new UserStatus();
                $userStatusModel->UserId = $user->UserId;
                $userStatusModel->UserStatusTypeId = (int)$userStatusId;
                $userStatusModel->DateFrom = new \DateTime();
                $userStatusModel->Message = $statusMessage ?: 'No Message';
                $status = $status && UserStatusesApiController::InsertUserStatus($userStatusModel);
                if ($currentUserStatus && $status) {
                    $currentUserStatus->DateTo = new \DateTime();
                    $status = $status && UserStatusesApiController::UpdateUserStatus($currentUserStatus);
                }
            }
        }
        return $status ? $user : null;
    }

    public static function SaveUserDetails(User $user, string $firstName, string $lastName, string $phone, ?string $dateOfBirth = null, ?int $gender = null, ?string $picture = null): bool
    {
        $userDetails = $user->Details->entity();
        if (!$userDetails) {
            $userDetails = new UserDetails();
        }
        $userDetails->FirstName = $firstName;
        $userDetails->LastName = $lastName;
        $userDetails->DateOfBirth = !empty($dateOfBirth) ? \DateTime::createFromFormat('m/d/Y', $dateOfBirth) : null;
        $userDetails->UserId = $user->UserId;
        $userDetails->Phone = $phone;

        return UsersApiController::InsertUserDetails($userDetails) !== false;
    }

    public static function CreateConfirmationLink(int $userId): ConfirmationLink
    {
        $confirmationLink = new ConfirmationLink();
        $confirmationLink->UserId = $userId;
        $confirmationLink->Token = bin2hex(openssl_random_pseudo_bytes(8));

        $date = new \DateTime();
        $date->modify('+30 days');
        $confirmationLink->ExpirationDate = $date;

        ConfirmationLinksApiController::InsertConfirmationLink($confirmationLink);

        return $confirmationLink;
    }

    public static function SendConfirmationMail(User $user): void
    {
        $userDetails = $user->Details->entity();
        $confirmationLink = UsersApiController::CreateConfirmationLink($user->UserId);
        $emailBannerUrl = $user->getEmailBanner();
        $mailModel = new UserRegisterMailViewModel($emailBannerUrl);
        // generate mail content
        $mailModel->Name = $userDetails->FirstName;
        $mailModel->ConfirmationLink = $confirmationLink->Token;
        $mailModel->ExpirationDate = $confirmationLink->ExpirationDate;

        $view = new UserRegisterMailView($mailModel);
        $config = Config::GetInstance();
        $mailNotificationFactory = new MailNotificationFactory();
        $mailNotificationFactory->createMailNotification()->send(new MailNotificationDto(
            'Welcome to OrthoStart!',
            $view->Render(false),
            'Your account for OrthoStart website has been created',
            [new SenderDTO('OrthoStart', $config->smtp->from)],
            [new RecipientDTO(sprintf('%s %s', $userDetails->FirstName, $userDetails->LastName), $user->Email)]
        ));
    }


}