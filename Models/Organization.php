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
 * @property string Picture
 * @property string Name
 * @property string Description
 * @property boolen CallBack
 * @property OrganizationLanguage[] OrganizationLanguages
 */
class Organization extends Entity
{

    // Database Mapping
    protected static $table = "organizations";


    public static function fields()
    {
        return [
            "OrganizationId" => ['type' => 'integer', 'primary' => true, 'autoincrement' => true],
            "Picture" => ['type' => 'string'],
            "Name" => ['type' => 'string'],
            "Description" => ['type' => 'text'],
            "CallBack" => ['type' => 'integer'],
        ];
    }


    public static function relations(MapperInterface $mapper, EntityInterface $entity)
    {
        return [
            'Users' => $mapper->hasMany($entity, 'Gdev\UserManagement\Models\User', 'UserId'),
            "OrganizationLanguages" => $mapper->hasMany($entity, 'Data\Models\OrganizationLanguage', 'OrganiaztionId'),
            "Languages" => $mapper->hasManyThrough($entity, 'Data\Models\Language', 'Data\Models\OrganizationLanguage', 'LanguageId', 'OrganizationId'),

        ];
    }

    public function PictureSource($thumb = null) {
        $config = Config::GetInstance();

        if (!empty($this->Picture)) {
            return sprintf("%sMedia/Organizations/%s%s", $config->cdn->url, empty($this->Picture) ? "" : $thumb . "/", $this->Picture);
        }
        return sprintf("%s/Content/default.jpg", $config->cdn->url);
    }

    public function PicturePath($thumb = null) {
        return sprintf("%sMedia/Organizations/%s%s", CDN_PATH, empty($this->Picture) ? "" : $thumb . "/", $this->Picture);
    }


}