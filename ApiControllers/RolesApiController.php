<?php
/**
 * Created by PhpStorm.
 * User: nikola
 * Date: 9.6.16.
 * Time: 19.19
 */

namespace Gdev\UserManagement\ApiControllers;

use Gdev\UserManagement\DataManagers\RolesDataManager;
use Gdev\UserManagement\Models\Role;
use Gdev\UserManagement\Models\RolePermission;
use phpDocumentor\Reflection\Types\Self_;
use Security;

class RolesApiController
{

    public static function GetRoles($offset = null, $limit = null, $organizationId = null, $weight = null,$conditions=[])
    {
        return RolesDataManager::GetRoles($offset, $limit, $organizationId, $weight,$conditions);
    }

    public static function InsertRole($model)
    {
        return RolesDataManager::InsertRole($model);
    }

    public static function DeleteRole($roleId)
    {
        return RolesDataManager::DeleteRole($roleId);
    }

    /**
     * @param $roleId
     *
     * @return Role
     */
    public static function GetRoleById($roleId)
    {
        return RolesDataManager::GetRoleById($roleId);
    }

    public static function SaveRole(string $name, array $permissionIds, int $weight, ?int $roleId = null, bool $active = false, bool $protected = false, ?int $organizationId = null): ?Role
    {

        $role = $roleId !== null ? self::GetRoleById($roleId) : new Role();

        $role->Name = $name;
        $role->Active = !empty($active);
        $role->Protected = !empty($protected);
        $role->Weight = $weight;

        // checking organization
        if ($organizationId === null && !Security::IsSuperAdmin()) {
            $currentUser = UsersApiController::GetUserById(Security::GetCurrentUser()->UserId);
            $organizationId = $currentUser->OrganizationId;
        }
        $role->OrganizationId = $organizationId;
        $success = self::InsertRole($role)>=0;

        if ($success) {
            $oldRolePermissions = RolePermissionsApiController::GetRolePermissions($role->RoleId);
            if ($oldRolePermissions->count() > 0) {
                foreach ($oldRolePermissions as $oldRolePermission) {
                    RolePermissionsApiController::DeleteRolesPermission($oldRolePermission->RolePermissionId);
                }
            }

            foreach ($permissionIds as $permissionId) {
                $rolePermissionModel = new RolePermission();
                $rolePermissionModel->PermissionId = $permissionId;
                $rolePermissionModel->RoleId = $role->RoleId;
                $success = $success && RolePermissionsApiController::InsertRolesPermission($rolePermissionModel);
            }
            if (!$success) {
                self::DeleteRole($role->RoleId);
            }
        }

        return $success ? $role : null;
    }


}