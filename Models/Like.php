<?php

namespace SocialNetwork\Models;

class Like
{
    private $statusId;
    private $profileId;

    public function __construct($statusId, $profileId)
    {
        $this->statusId = $statusId;
        $this->profileId = $profileId;
    }

    public function getStatusId()
    {
        return $this->statusId;
    }

    public function getProfileId()
    {
        return $this->profileId;
    }

    public function setStatusId($statusId)
    {
        $this->statusId = $statusId;
    }

    public function setProfileId($profileId)
    {
        $this->profileId = $profileId;
    }
}
