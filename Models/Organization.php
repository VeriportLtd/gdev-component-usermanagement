<?php

namespace Gdev\UserManagement\Models;

use Business\Utilities\Config\Config;
use Gdev\UserManagement\Components\UserManagementDependencyResolver;
use Spot\Entity;
use Spot\EntityInterface;
use Spot\MapperInterface;
use Data\Models\MVCModel;

/**
 * Class Organization
 * @package Models
 *
 * @property integer OrganizationId
 * @property string Name
 * @property string Address
 * @property string Phone
 * @property string Website
 * @property string Logo
 */
class Organization extends MVCModel
{

    // Database Mapping
    protected static $table = "organizations";


    public static function fields()
    {
        $fields = [
            "OrganizationId" => ['type' => 'integer', 'primary' => true, 'autoincrement' => true],
            "Name" => ['type' => 'string', 'required' => true, 'unique' => true],
            "Address" => ['type' => 'string'],
            "Phone" => ['type' => 'string'],
            "Website" => ['type' => 'string'],
            "Logo" => ['type' => 'string']
        ];

        return array_merge($fields, parent::fields());
    }

    public static function relations(MapperInterface $mapper, EntityInterface $entity)
    {
        return [
            'Users' => $mapper->hasMany($entity, UserManagementDependencyResolver::getInstance()->Resolve("User"), 'UserId'),
        ];
    }

    public function PictureSource($thumb = null) {
        $config = Config::GetInstance();

        if (!empty($this->Logo)) {
            return sprintf("%sMedia/Organizations/%s%s", $config->cdn->url, empty($this->Logo) ? "" : $thumb . "/", $this->Logo);
        }
        return sprintf("%s/Content/organization-default.png", $config->cdn->url);
    }

    public function PicturePath($thumb = null) {
        return sprintf("%sMedia/Organizations/%s%s", CDN_PATH, empty($this->Logo) ? "" : $thumb . "/", $this->Logo);
    }
}