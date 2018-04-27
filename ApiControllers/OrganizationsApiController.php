<?php
/**
 * Created by PhpStorm.
 * User: nikola
 * Date: 9.6.16.
 * Time: 19.19
 */

namespace Gdev\UserManagement\ApiControllers;

use Gdev\UserManagement\DataManagers\OrganizationsDataManager;
use Gdev\UserManagement\Models\Organization;

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

    /**
     * @param $organizationId
     * @return Organization
     */
    public static function GetOrganizationById($organizationId)
    {
        return OrganizationsDataManager::GetOrganizationById($organizationId);
    }

    public static function DeleteOrganization($organizationId)
    {
        return OrganizationsDataManager::DeleteOrganization($organizationId);
    }

    public static function SaveOrganizationTranslation($translation){
        return OrganizationsDataManager::SaveOrganizationTranslation($translation);
    }

    public static function SaveOrganizationLanguage($organizationLanguage){
        return OrganizationsDataManager::SaveOrganizationLanguage($organizationLanguage);
    }

    public static function GetOrganizationLanguages($organizationId){
        return OrganizationsDataManager::GetOrganizationLanguages($organizationId);
    }

    public static function DeleteOrganizationLanguage($organizationLanguageId){
        return OrganizationsDataManager::DeleteOrganizationLanguage($organizationLanguageId);
    }

}