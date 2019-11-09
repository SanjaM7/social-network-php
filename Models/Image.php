<?php

namespace SocialNetwork\Models;

use SocialNetwork\Models\ProfileError;

class Image
{
    private $imageName;
    private $imageTmpName;
    private $imageSize;
    private $imageError;
    private $imageType;

    private $imageActualExt;

    public function __construct($image)
    {
        $this->imageName = $image["name"];
        $this->imageTmpName = $image["tmp_name"];
        $this->imageSize = $image["size"];
        $this->imageError = $image["error"];
        $this->imageType = $image["type"];
        $imageExt = explode('.', $this->imageName);
        $imageActualExt = strtolower(end($imageExt));
        $this->imageActualExt = $imageActualExt;
    }

    public function getImageName()
    {
        return $this->imageName;
    }
    public function getImageTmpName()
    {
        return $this->imageTmpName;
    }
    public function getImageSize()
    {
        return $this->imageSize;
    }
    public function getImageError()
    {
        return $this->imageError;
    }
    public function getImageType()
    {
        return $this->imageType;
    }
    public function getImageActualExt()
    {
        return $this->imageActualExt;
    }

    /**
     * Return errors array if image params are invalid
     */
    public function validateImageParams()
    {
        $allowedExtensions = array('jpeg', 'png', 'jpg');
        $errors = $this->validateParams($this->imageActualExt, $allowedExtensions);
        return $errors;
    }

    /**
     * Validate create image parameters and returns errors array if there are errors
     * @param $imageActualExt
     * @param $allowedExtensions
     * @return array
     */
    private function validateParams($imageActualExt, $allowedExtensions)
    {
        $errors = array();
        if (!in_array($imageActualExt, $allowedExtensions)) {
            array_push($errors, ProfileError::INVALID_EXTENSION);
        }

        if ($this->imageError !== 0) {
            array_push($errors, ProfileError::ERROR_UPLOADING);
        }

        if ($this->imageSize >= 1000000) {
            array_push($errors, ProfileError::IMAGE_TOO_LARGE);
        }

        return $errors;
    }
}
