<?php

namespace Gdev\UserManagement\Models;

use Business\Utilities\Config\Config;
use Gdev\UserManagement\Components\UserManagementDependencyResolver;
use Spot\Entity;
use Spot\EntityInterface;
use Spot\MapperInterface;
use Data\Models\MVCModel;
use \ion\PhpHelper as PHP;

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
 * @property boolean AffiliateFlag
 * @property boolean CustomerFlag
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
            "Logo" => ['type' => 'string'],
            "AffiliateFlag" => ['type' => 'boolean', 'required' => true],
            "CustomerFlag" => ['type' => 'boolean', 'required' => true]			
        ];

        return array_merge($fields, parent::fields());
    }

    public static function relations(MapperInterface $mapper, EntityInterface $entity)
    {
        return [
            'Users' => $mapper->hasMany($entity, UserManagementDependencyResolver::getInstance()->Resolve("User"), 'UserId'),
        ];
    }

//    public function PictureSource($thumb = null) {
//        $config = Config::GetInstance();
//
//        if (!empty($this->Logo)) {
//            return sprintf("%sMedia/Organizations/%s%s", $config->cdn->url, empty($this->Logo) ? "" : $thumb . "/", $this->Logo);
//        }
//        return sprintf("%s/Content/organization-default.png", $config->cdn->url);
//    }
//
//    public function PicturePath($thumb = null) {
//        return sprintf("%sMedia/Organizations/%s%s", CDN_PATH, empty($this->Logo) ? "" : $thumb . "/", $this->Logo);
//    }
    
    public function PictureSource($thumb = null) {
        
        $config = Config::GetInstance();

        $orgDashed = PHP::strToDashedCase($this->Name);
        
        if (!empty($this->Logo)) {
            
            return sprintf("%suploads/%s/%s", $config->accounts->url, $orgDashed, $this->Logo);
        }
        return sprintf("%suploads/%s/organization-logo.png", $config->accounts->url, $orgDashed);
    }

    public function PicturePath($thumb = null) {
        
        return null;
        //return "X";
        
//        return sprintf("%sMedia/Organizations/%s%s", CDN_PATH, empty($this->Logo) ? "" : $thumb . "/", $this->Logo);
    }
    
    public function PictureUrl($thumb = null) {
        
        return Config::GetInstance()->accounts->url;
    }
}