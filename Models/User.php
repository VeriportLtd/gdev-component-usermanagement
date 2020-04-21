<?php

namespace Gdev\UserManagement\Models;

use Data\Models\Business;
use Data\Models\BusinessType;
use Data\Models\BusinessTypeCustomDetails;
use Data\Models\Customer;
use Data\Models\Message;
use Data\Models\MessageThread;
use Data\Models\MVCModel;
use Data\Models\Panel;
use Data\Models\Participant;
use Data\Models\UserParticipant;
use DateTime;
use Spot\EntityInterface;
use Spot\MapperInterface;
use Gdev\UserManagement\Models\UserDetails;
use Gdev\UserManagement\Models\UserStatus;
use Gdev\UserManagement\Models\Role;
use Gdev\UserManagement\Models\UserRole;
use Gdev\UserManagement\Models\Organization;
use Gdev\UserManagement\Models\ConfirmationLink;
use Gdev\UserManagement\Models\PasswordResetLink;
use Gdev\UserManagement\Models\UserAccessToken;
use Data\Models\UserBusiness;
use Data\Models\UserThread;
use Data\Models\UserMessage;

/**
 * Class User
 * @package Models
 *
 * @property integer UserId
 * @property string UserName
 * @property DateTime RegistrationDate
 * @property string Email
 * @property string Password
 * @property string FbAccessToken
 * @property boolean Active
 * @property boolean Approved
 * @property integer OrganizationId
 * @property UserDetails Details
 * @property Organization Organization
 * @property Role[] Roles
 * @property UserStatus[] Statuses
 * @property Business[] Businesses
 * @property MessageThread[] Threads
 * @property Message[] Messages
 * @property Panel[] Panels
 * @property Participant[] Participants
 */
class User extends MVCModel
{

    // Database Mapping
    protected static $table = 'users';


    public static function fields()
    {
        $fields = [
            'UserId' => ['type' => 'integer', 'primary' => true, 'autoincrement' => true],
            'UserName' => ['type' => 'string', 'required' => true, 'unique' => true],
            'OrganizationId' => ['type' => 'integer'],
            'RegistrationDate' => ['type' => 'datetime', 'required' => true],
            'Email' => ['type' => 'string', 'required' => true, 'unique' => true],
            'Password' => ['type' => 'string', 'required' => true],
            'FbAccessToken' => ['type' => 'text', 'required' => false],
            'Active' => ['type' => 'boolean', 'required' => false, 'default' => false],
            'Approved' => ['type' => 'boolean', 'required' => false, 'default' => false],
        ];
        return array_merge($fields, parent::fields());
    }

    public static function relations(MapperInterface $mapper, EntityInterface $entity)
    {
        return [
            'Statuses' => $mapper->hasMany($entity, UserStatus::class, 'UserId'),
            'Roles' => $mapper->hasManyThrough($entity, Role::class, UserRole::class, 'RoleId', 'UserId'),
            'Details' => $mapper->hasOne($entity, UserDetails::class, 'UserId'),
            'Organization' => $mapper->belongsTo($entity, Organization::class, 'OrganizationId'),
            'ConfirmationLinks' => $mapper->hasMany($entity, ConfirmationLink::class, 'UserId'),
            'PasswordResetLinks' => $mapper->hasMany($entity, PasswordResetLink::class, 'UserId'),
            'UserAccessTokens' => $mapper->hasMany($entity, UserAccessToken::class, 'UserId'),
            'Businesses' => $mapper->hasManyThrough($entity, Business::class, UserBusiness::class, 'BusinessId', 'UserId'),
            'Threads' => $mapper->hasManyThrough($entity, MessageThread::class, UserThread::class, 'ThreadId', 'UserId')->order(['UpdatedAt' => 'DESC']),
            'LastFiveThreads' => $mapper->hasManyThrough($entity, MessageThread::class, UserThread::class, 'ThreadId', 'UserId')->order(['UpdatedAt' => 'DESC'])->limit(5),
            'Messages' => $mapper->hasManyThrough($entity, Message::class, UserMessage::class, 'MessageId', 'UserId')->order(['CreatedAt' => 'DESC']),
            'Panels' => $mapper->hasMany($entity, Panel::class, 'UserId'),
            'Participants' => $mapper->hasManyThrough($entity, Participant::class, UserParticipant::class, 'ParticipantId', 'UserId'),
        ];
    }

    /**
     * @return BusinessType|null
     */
    public function getBusinessType(): ?BusinessType
    {
        $firstBusiness = $this->getBusiness();
        if ($firstBusiness) {
            return $firstBusiness->BusinessType->entity();
        }
        return null;
    }

    /**
     * @return Business|null
     */
    public function getBusiness(): ?Business
    {
        return count($this->Businesses) ? $this->Businesses[0] : null;
    }

    /**
     * @return string|null
     */
    public function getEmailBanner(): ?string
    {
        /** @var BusinessTypeCustomDetails|null $businessTypeCustomDetails */
        if ($this->getBusiness()) {
            $businessTypeCustomDetails = $this->getBusiness()->getBusinessTypeCustomDetails();
            $emailBannerUrl = null;
            $this->LogoUrl = $businessTypeCustomDetails->getEmailBannerUrl();
            if ($businessTypeCustomDetails && !empty($businessTypeCustomDetails->EmailBanner)) {
                $emailBannerPath = $businessTypeCustomDetails->getEmailBannerPath();
                if (is_readable($emailBannerPath) && is_file($emailBannerPath)) {
                    $emailBannerUrl = $businessTypeCustomDetails->getEmailBannerUrl();
                }
            }
            return $emailBannerUrl;
        }
        return null;
    }

    /**
     * @return bool
     */
    public function isParticipant(): bool
    {
        return $this->getParticipant() !== null;
    }

    /**
     * @return Participant|null
     */
    public function getParticipant(): ?Participant
    {
        $participants = $this->Participants->entities();
        if (count($participants) > 0) {
            return $participants[0]->entity();
        }
        return null;
    }

    /**
     * @param Customer $customer
     * @return bool
     */
    public function canViewCustomer(Customer $customer): bool
    {
        $businessIds = $this->Businesses->toArray('BusinessId');
        return in_array($customer->BusinessId, $businessIds, true);
    }


}