<?php
/**
 * Created by PhpStorm.
 * User: Milan
 * Date: 10.6.2016.
 * Time: 15.26
 */

namespace Gdev\UserManagement\Models;

use Business\Enums\ThumbnailSizeEnum;
use Business\Helpers\FileHelper;
use Business\Middleware\FileSystems\DTO\ImageResizeDTO;
use Business\Middleware\FileSystems\Traits\FileUploadTrait;
use Business\Middleware\FileSystems\Traits\ImageUploadTrait;
use Business\Utilities\Config\Config;
use DateTime;
use Spot\Entity;
use Spot\EntityInterface;
use Spot\MapperInterface;

/**
 * Class UserDetails
 * @package Models
 *
 * @property integer UserDetailsId
 * @property integer UserId
 * @property string FirstName
 * @property string LastName
 * @property string Phone
 * @property integer Gender
 * @property DateTime DateOfBirth
 * @property string Picture
 * @property DateTime LastLogin
 *
 */
class UserDetails extends Entity
{
    use FileUploadTrait, ImageUploadTrait;

    //Picture
    public const PICTURE_PATH = 'Media/Users/Picture';
    public const PICTURE_DEFAULT_PATH = 'Content';
    public const PICTURE_DEFAULT_NAME = 'user-default.png';
    protected const PICTURE_NAME_PREFIX = 'user';
    protected const PICTURE_THUMBNAILS = [ThumbnailSizeEnum::SMALL, ThumbnailSizeEnum::MEDIUM];

    // Database Mapping
    protected static $table = "user_details";

    public static function fields()
    {
        return [
            "UserDetailsId" => ['type' => 'integer', 'primary' => true, 'autoincrement' => true],
            "UserId" => ['type' => 'integer', 'required' => true, 'unique' => true],
            "FirstName" => ['type' => 'string', 'required' => true],
            "LastName" => ['type' => 'string', 'required' => true],
            "Gender" => ['type' => 'integer'],
            "DateOfBirth" => ['type' => 'datetime', 'required' => false, 'default' => null],
            "Picture" => ['type' => 'string'],
            "LastLogin" => ['type' => 'datetime'],
            "Phone" => ['type' => 'string', 'required' => true],
        ];
    }

    public static function relations(MapperInterface $mapper, EntityInterface $entity)
    {
        return [
            'User' => $mapper->belongsTo($entity, 'Gdev\UserManagement\Models\User', 'UserId'),
        ];
    }

    public function DisplayFullName()
    {
        return sprintf("%s %s", $this->FirstName, $this->LastName);
    }


    /**
     * @param string $fileSource
     * @param string $logo
     * @param bool $overwrite
     *
     * @return bool
     */
    public function savePicture(string $fileSource, string $logo, bool $overwrite = false): bool
    {
        $newSourceFile = FileHelper::CreateTemporaryFilePath();
        $result = $this->processImage($fileSource, $newSourceFile);
        if ($result) {
            $pictureName = $this->generateFileName($logo, "{$this->FirstName}-{$this->LastName}", static::PICTURE_NAME_PREFIX);
            $defaultPictureSizeSaved = $this->saveFile($newSourceFile, $pictureName, static::PICTURE_PATH) === true;
            $result = $defaultPictureSizeSaved && $this->saveThumbnailImages($fileSource, static::PICTURE_PATH, $pictureName, $this->getImageResizeDTOs(static::PICTURE_THUMBNAILS));
            if ($overwrite && $result) {
                $result = $this->deletePicture() !== false;
            }
            if ($result) {
                $this->Picture = $pictureName;
            }
        }
        return $result;
    }


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


    /**
     * @return bool|null
     */
    public function deletePicture(): ?bool
    {
        if (empty($this->Picture)) {
            return null;
        }
        $result = true;
        foreach (static::PICTURE_THUMBNAILS as $thumbnail) {
            $result = $result && $this->deleteFile($this->Picture, static::PICTURE_PATH, $thumbnail) !== false;
        }
        $result = $result && $this->deleteFile($this->Picture, static::PICTURE_PATH) !== false;

        if ($result !== false) {
            $this->Picture = null;
        }
        return $result;
    }

//used for migration to new directory
    public function getPicturePath(bool $includeDefaultPath, string $thumbnail = null)
    {
        //TODO remove after deploy
        $picturePath = $this->getFilePath($this->Picture, static::PICTURE_PATH, $thumbnail);
        if (($picturePath !== null && is_readable($picturePath)) || !$includeDefaultPath) {
            return $picturePath;
        }
        return $this->getFilePath(static::PICTURE_DEFAULT_NAME, static::PICTURE_DEFAULT_PATH);

    }

}