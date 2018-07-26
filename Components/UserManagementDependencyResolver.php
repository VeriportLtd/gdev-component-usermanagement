<?php
/**
 * Created by PhpStorm.
 * User: helix
 * Date: 24-Jul-18
 * Time: 12:36
 */

namespace Gdev\UserManagement\Components;

class UserManagementDependencyResolver extends \Backslash\Resolver\DependencyResolver
{
    const DEFAULT_PATH = ROOT_PATH . "Data/Models";
    const DEFAULT_NAMESPACE = "Data\Models";
    const FALLBACK_PATH = ROOT_PATH . "/Composer/Bundles/gdev/user-management/Models";
    const FALLBACK_NAMESPACE = "Gdev\UserManagement\Models";
}