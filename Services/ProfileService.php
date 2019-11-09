<?php

namespace SocialNetwork\Services;

use SocialNetwork\Interfaces\IProfileService;
use SocialNetwork\Models\ProfileError;
use SocialNetwork\Repository\ProfileRepository;

class ProfileService implements IProfileService
{
    private $repository;

    public function __construct()
    {
        $this->repository = new ProfileRepository();
    }

    public function getProfileFromAccountId($accountId)
    {
        $myProfile = $this->repository->getProfileFromAccountId($accountId);
        return $myProfile;
    }

    public function getProfileFromId($profileId)
    {
        $profile = $this->repository->getProfileFromId($profileId);
        return $profile;
    }

    public function getProfileIdFromAccountId($accountId)
    {
        $myProfile = $this->repository->getProfileFromAccountId($accountId);
        $myProfileId = $myProfile->getId();
        return $myProfileId;
    }

    public function editProfile($accountId, $firstName, $lastName, $yearOfBirth, $image, $gender)
    {
        $profile = $this->repository->getProfileFromAccountId($accountId);
        $errors = $profile->validateProfileParams($firstName, $lastName, $yearOfBirth, $image);
        if ($errors) {
            return $errors;
        }
        $profile->setProfile($firstName, $lastName, $yearOfBirth, $image, $gender);
        $this->repository->editProfile($profile);
        return array();
    }

    public function searchProfile($searchName)
    {
        if (empty($searchName)) {
            return array();
        }
        $profiles = $this->repository->searchProfile($searchName);
        return $profiles;
    }

    public function validateProfile($profileId)
    {
        $error = null;
        $profile = $this->repository->getProfileFromId($profileId);
        if (!$profile) {
            $error = ProfileError::PROFILE_DOES_NOT_EXIST;
        }

        return $error;
    }
}
