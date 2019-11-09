<?php

namespace SocialNetwork\Interfaces;

interface IProfileService
{
    public function getProfileFromAccountId($accountId);
    public function getProfileFromId($profileId);
    public function getProfileIdFromAccountId($accountId);
    public function editProfile($accountId, $firstName, $lastName, $yearOfBirth, $image, $gender);
    public function searchProfile($searchName);
    public function validateProfile($profileId);
}
