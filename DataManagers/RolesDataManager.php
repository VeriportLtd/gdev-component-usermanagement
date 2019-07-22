<?php

namespace Gdev\UserManagement\DataManagers;

use Gdev\UserManagement\Repositories\RolesRepository;

class RolesDataManager
{

    public static function GetRoles($offset = null, $limit = null, $organizationId = null,$weight)
    {
        $wheres = [];
        if (!is_null($organizationId)) {
            $wheres["OrganizationId"] = $organizationId;
        }
        if (!is_null($weight)){
            $wheres["Weight >="] = $weight;
        }
        return RolesRepository::getInstance()->all()->with(["Permissions", "UserRoles"])->where($wheres)->limit($limit, $offset);
    }

    public static function InsertRole($model)
    {
        return RolesRepository::getInstance()->save($model);
    }

    public static function UpdateRole($model)
    {
        return RolesRepository::getInstance()->save($model);
    }

    public static function DeleteRole($roleId)
    {
        return RolesRepository::getInstance()->delete(['RoleId' => $roleId]);
    }

    public static function GetRoleById($roleId)
    {
        return RolesRepository::getInstance()->get($roleId);
    }

}