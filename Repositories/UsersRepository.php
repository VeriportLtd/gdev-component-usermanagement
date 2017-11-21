<?php

namespace Gdev\UserManagement\Repositories;

use Data\Repositories\BaseRepository;

/**
 * Class UsersRepository
 * @package Gdev\UserManagement\Repositories
 */
class UsersRepository extends BaseRepository {

    const Model = 'Gdev\UserManagement\Models\User';

    public static function GetLastLoggedInUser($weight)
    {
        $db = static::getInstance();
        $query = sprintf("SELECT
        user_details.FirstName,
        user_details.LastName,
        user_details.Picture,
        user_access_tokens.StartDate
         FROM user_access_tokens
        JOIN user_roles on user_roles.UserId = user_access_tokens.UserId
        JOIN user_details on user_roles.UserId = user_details.UserId
        JOIN roles on user_roles.RoleId = Roles.RoleId
        WHERE roles.Weight >= '%s'
        ORDER BY user_access_tokens.StartDate DESC
        LIMIT 1", $weight);
        $data = $db->query($query);

        return new \LastLoggedUserDTO($data[0]->FirstName,$data[0]->LastName,$data[0]->Image,$data[0]->StartDate);

    }
}