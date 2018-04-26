<?php

namespace Gdev\UserManagement\Models;

use Business\Utilities\Config\Config;
use Spot\Entity;
use Spot\EntityInterface;
use Spot\MapperInterface;

/**
 * Class OrganizationTranslation
 * @package Models
 *
 * @property integer OrganizationTranslationId
 * @property integer OrganizationId
 * @property integer LanguageId
 * @property string Name
 * @property string Description
 */
class OrganizationTranslation extends Entity
{

    // Database Mapping
    protected static $table = "organization_translations";


    public static function fields()
    {
        return [
            "OrganizationTranslationId" => ['type' => 'integer', 'primary' => true, 'autoincrement' => true],
            "OrganizationId" => ['type' => 'integer'],
            "LanguageId" => ['type' => 'integer'],
            "Name" => ['type' => 'string'],
            "Description" => ['type' => 'text']
        ];
    }


    public static function relations(MapperInterface $mapper, EntityInterface $entity)
    {
        return [
            "Language" => $mapper->belongsTo($entity, 'Data\Models\Language', 'LanguageId'),
            "Organization" => $mapper->belongsTo($entity, 'Gdev\UserManagement\Models\Organization', 'OrganizationId')
        ];
    }

}