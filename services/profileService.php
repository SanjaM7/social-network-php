<?php

class ProfileService
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

    public function validateProfileParams($profile, $firstName, $lastName, $yearOfBirth, $image)
    {
        $errors = $profile->validateProfileParams($firstName, $lastName, $yearOfBirth, $image);
        return $errors;
    }

    public function editProfile($profile, $firstName,  $lastName, $yearOfBirth, $image, $gender)
    {
        $profile->setProfile($firstName,  $lastName, $yearOfBirth, $image, $gender);
        $this->repository->editProfile($profile);
    }

    public function searchProfile($searchName)
    {
        $profiles = $this->repository->searchProfile($searchName);
        return $profiles;
    }

    public function validateFriendProfile($friendProfileId)
    {
        $error = null;
        $friendProfile = $this->repository->getProfileFromId($friendProfileId);
        if(!$friendProfile){
            $error = FriendProfileError::FriendProfileDoesNotExist;
        }

        return $error;
    }
}