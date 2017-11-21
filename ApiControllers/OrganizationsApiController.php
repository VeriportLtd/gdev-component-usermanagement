<?php
/**
 * Created by PhpStorm.
 * User: nikola
 * Date: 9.6.16.
 * Time: 19.19
 */

namespace Gdev\UserManagement\ApiControllers;

use Gdev\UserManagement\DataManagers\OrganizationsDataManager;

class OrganizationsApiController
{

    public static function GetOrganizations()
    {
        return OrganizationsDataManager::GetOrganizations();
    }

    public static function GetOrganizationsCount() {
        return OrganizationsDataManager::GetOrganizationsCount();
    }

    public static function SaveOrganization($model)
    {
        return OrganizationsDataManager::SaveOrganization($model);
    }

    public static function GetOrganizationById($organizationId)
    {
        return OrganizationsDataManager::GetOrganizationById($organizationId);
    }

    public static function DeleteOrganization($organizationId)
    {
        return OrganizationsDataManager::DeleteOrganization($organizationId);
    }

}