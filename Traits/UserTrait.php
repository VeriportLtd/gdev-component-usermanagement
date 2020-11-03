<?php


namespace Gdev\UserManagement\Traits;


/**
 * Trait UserTrait
 * @package Gdev\UserManagement\Traits
 */
trait UserTrait
{
    /**
     * @param string|null $thumbnail
     *
     * @return string|null
     */
    public function getPictureUrl(string $thumbnail = null): ?string
    {
        $fileUrl = $this->getFileUrl($this->Picture, static::PICTURE_PATH, $thumbnail);
        return $fileUrl ?? $this->getFileUrl(static::PICTURE_DEFAULT_NAME, static::PICTURE_DEFAULT_PATH);
    }

}