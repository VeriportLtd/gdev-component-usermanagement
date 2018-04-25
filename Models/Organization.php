<?php

namespace Gdev\UserManagement\Models;

use Business\Utilities\Config\Config;
use Spot\Entity;
use Spot\EntityInterface;
use Spot\MapperInterface;

/**
 * Class Organization
 * @package Models
 *
 * @property integer OrganizationId
 * @property string Name
 * @property string Description
 * @property string Picture
 */
class Organization extends Entity
{

    // Database Mapping
    protected static $table = "organizations";


    public static function fields()
    {
        return [
            "OrganizationId" => ['type' => 'integer', 'primary' => true, 'autoincrement' => true],
            "Name" => ['type' => 'string', 'required' => true, 'unique' => true],
            "Description" => ['type' => 'text'],
            "Picture" => ['type' => 'string'],
        ];
    }

    public static function relations(MapperInterface $mapper, EntityInterface $entity)
    {
        return [
            'Users' => $mapper->hasMany($entity, 'Gdev\UserManagement\Models\User', 'UserId'),
        ];
    }

    public function PictureSource($thumb = null) {
        $config = Config::GetInstance();

        if (!empty($this->Picture)) {
            return sprintf("%sMedia/Organizations/%s%s", $config->cdn->url, empty($this->Picture) ? "" : $thumb . "/", $this->Picture);
        }
        return sprintf("%s/Content/user-default.png", $config->cdn->url);
    }

    public function PicturePath($thumb = null) {
        return sprintf("%sMedia/Organizations/%s%s", CDN_PATH, empty($this->Picture) ? "" : $thumb . "/", $this->Picture);
    }
}