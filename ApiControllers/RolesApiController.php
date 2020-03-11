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

    public static function GetRoles($offset = null, $limit = null, $organizationId = null, $weight = null)
    {
        return RolesDataManager::GetRoles($offset, $limit, $organizationId, $weight);
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
        $success = self::InsertRole($role);
        if (!empty($permissionIds)) {
            foreach ($permissionIds as $permissionId) {
                $rolePermissionModel = new RolePermission();
                $rolePermissionModel->PermissionId = $permissionId;
                $rolePermissionModel->RoleId = $roleId;
                $success = $success && RolePermissionsApiController::InsertRolesPermission($rolePermissionModel);
            }
        }

        $oldRolePermissions = RolePermissionsApiController::GetRolePermissions($roleId);
        $oldRolePermissionTypes = [];

        if ($permissionIds != null) {
            if ($oldRolePermissions != null) {
                foreach ($oldRolePermissions as $oldRolePermission) {
                    $oldRolePermissionTypes[] = $oldRolePermission->PermissionId;
                    if (!in_array($oldRolePermission->PermissionId, $permissionIds, false)) {
                        RolePermissionsApiController::DeleteRolesPermission($oldRolePermission->RolePermissionId);
                    }
                }
            }

            foreach ($permissionIds as $permissionId) {
                $rolePermissionModel = new RolePermission();
                $rolePermissionModel->PermissionId = $permissionId;
                $rolePermissionModel->RoleId = $roleId;
                $rolePermissionModel->Protected = 1;
                if (count($oldRolePermissions) > 0) {
                    if (!in_array($permissionId, $oldRolePermissionTypes, false)) {
                        RolePermissionsApiController::InsertRolesPermission($rolePermissionModel);
                    }
                } else {
                    RolePermissionsApiController::InsertRolesPermission($rolePermissionModel);
                }
            }
        } else {
            foreach ($oldRolePermissions as $oldRolePermission) {
                RolePermissionsApiController::DeleteRolesPermission($oldRolePermission->RolePermissionId);
            }
        }


        return $success ? $role : null;
    }


}