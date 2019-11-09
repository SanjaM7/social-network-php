<?php

namespace SocialNetwork\Models;

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
        $this->lastName = null;
        $this->yearOfBirth = null;
        $this->image = 'profiledefault.jpg';
        $this->gender = null;
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
     * @param $firstName
     * @param $lastName
     * @param $yearOfBirth
     * @return array
     */
    private function validateParams($firstName, $lastName, $yearOfBirth)
    {
        $errors = array();

        if (!preg_match("/^[a-zA-Z]*$/", $firstName) || strlen($firstName) < 2 || strlen($firstName) > 32) {
            array_push($errors, ProfileError::INVALID_FIRST_NAME);
        }

        if (!preg_match("/^[a-zA-Z]*$/", $lastName) || strlen($lastName) < 1 || strlen($lastName) > 64) {
            array_push($errors, ProfileError::INVALID_LAST_NAME);
        }

        if ($yearOfBirth < 1900 || $yearOfBirth > date("Y")) {
            array_push($errors, ProfileError::INVALID_YEAR_OF_BIRTH);
        }
        
        return $errors;
    }

    public function setProfile($firstName, $lastName, $yearOfBirth, $image, $gender)
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
