<?php

class Profile
{
    private $id;
    private $firstName;
    private $lastName;
    private $yearOfBirth;
    private $image;
    private $gender;
    private $accountId;

    public function __construct($accountId, $firstName)
    {
        $this->firstName = $firstName;
        $this->lastName = NULL;
        $this->yearOfBirth = NULL;
        $this->image = 'profiledefault.jpg';
        $this->gender = NULL;
        $this->accountId = $accountId;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function getYearOfBirth()
    {
        return $this->yearOfBirth;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function getGender()
    {
        return $this->gender;
    }

    public function getAccountId()
    {
        return $this->accountId;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    public function setYearOfBirth($yearOfBirth)
    {
        $this->yearOfBirth = $yearOfBirth;
    }

    public function setImage($image)
    {
        $this->image = $image;
    }

    public function setGender($gender)
    {
        $this->gender = $gender;
    }

    public function validateProfileParams($firstName, $lastName, $yearOfBirth, $image)
    {
        $errors = array();
        $errors = $this->validateParams($firstName, $lastName, $yearOfBirth);
        if (!count($errors)) {
            $image = new Image($image);
            $errors = $image->validateImageParams();
        }

        return $errors;
    }

    /**
     * Validate profile parameters and returns errors array if there are errors
     */
    private function validateParams($firstName, $lastName, $yearOfBirth)
    {
        $errors = array();

        if (!preg_match("/^[a-zA-Z]*$/", $firstName) || strlen($firstName) < 2 || strlen($firstName) > 32) {
            array_push($errors, ProfileError::InvalidFirstName);
        }

        if (!preg_match("/^[a-zA-Z]*$/", $lastName) || strlen($lastName) < 1 || strlen($lastName) > 64) {
            array_push($errors, ProfileError::InvalidLastName);
        }

        if ($yearOfBirth < 1900 || $yearOfBirth > date("Y")) {
            array_push($errors, ProfileError::InvalidYearOfBirth);
        }
        
        return $errors;
    }

    public function setProfile($firstName,  $lastName, $yearOfBirth, $image, $gender)
    {
        $this->setFirstName($firstName);
        $this->setLastName($lastName);
        $this->setYearOfBirth($yearOfBirth);
        $this->setGender($gender);

        $image = new Image($image);

        $imageNameNew = "profile" . $this->id . "." . $image->getImageActualExt();
        $currentPath = dirname(__FILE__);
        $fileDestination = "$currentPath/../uploads/$imageNameNew";
        move_uploaded_file($image->getImageTmpName(), $fileDestination);
        $this->setImage($imageNameNew);
    }

}

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
     */
    private function validateParams($imageActualExt, $allowedExtensions)
    {
        $errors = array();
        if (!in_array($imageActualExt, $allowedExtensions)) {
            array_push($errors, ProfileError::InvalidExtention);
        }

        if ($this->imageError !== 0) {
            array_push($errors, ProfileError::ErrorUploading);
        }

        if ($this->imageSize >= 1000000) {
            array_push($errors, ProfileError::ImageTooLarge);
        }

        return $errors;
    }
}
