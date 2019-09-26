<?php

namespace Gdev\UserManagement\Models;

use DateTime;
use Spot\Entity;
use Spot\EntityInterface;
use Spot\MapperInterface;

/**
 * Class ConfirmationLink
 * @package Models
 *
 * @property integer ConfirmationLinkId
 * @property integer UserId
 * @property DateTime ExpirationDate
 * @property string Token
 */
class ConfirmationLink extends Entity
{
    // Database Mapping
    protected static $table = 'confirmation_links';

    public static function fields()
    {
        return [
            'ConfirmationLinkId' => ['type' => 'integer', 'primary' => true, 'autoincrement' => true],
            'UserId' => ['type' => 'integer', 'index' => true, 'required' => true],
            'ExpirationDate' => ['type' => 'datetime', 'required' => true],
            'Token' => ['type' => 'string', 'required' => true, 'unique' => true],
        ];
    }

    public static function relations(MapperInterface $mapper, EntityInterface $entity)
    {
        return [
            'User' => $mapper->belongsTo($entity, User::class, 'UserId')
        ];
    }
}