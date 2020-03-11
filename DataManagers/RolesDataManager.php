<?php

namespace Gdev\UserManagement\DataManagers;

use Gdev\UserManagement\Repositories\RolesRepository;

class RolesDataManager
{

    public static function GetRoles($offset = null, $limit = null, $organizationId = null, $weight = null, $conditions = [])
    {
        $wheres = [];
        if ($organizationId !== null) {
            $wheres['OrganizationId'] = $organizationId;
        }
        if ($weight !== null) {
            $wheres['Weight >='] = $weight;
        }
        if (!empty($conditions)) {
            $wheres = array_merge($wheres, $conditions);
        }
        return RolesRepository::getInstance()->all()->with(['Permissions', 'UserRoles'])->where($wheres)->limit($limit, $offset);
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