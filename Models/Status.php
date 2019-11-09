<?php

namespace SocialNetwork\Models;

class Status
{
    private $id;
    private $text;
    private $profileId;
    private $parentId;
    private $createdAt;

    public function __construct($text, $profileId, $parentId)
    {
        $this->text = $text;
        $this->profileId = $profileId;
        $this->parentId = $parentId;
    }
    
    public function getId()
    {
        return $this->id;
    }

    public function getText()
    {
        return $this->text;
    }

    public function getProfileId()
    {
        return $this->profileId;
    }

    public function getParentId()
    {
        return $this->parentId;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setText($text)
    {
        $this->text = $text;
    }

    public function setProfileId($profileId)
    {
        $this->profileId = $profileId;
    }

    public function setParentId($parentId)
    {
        $this->parentId = $parentId;
    }

    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    public function validateStatusParams()
    {
        $errors = array();
        if (empty($this->text)) {
            $errors[] = StatusError::REQUIRED_TEXT;
        }
        if (strlen($this->text) > 140) {
            $errors[] = StatusError::TEXT_LIMIT_EXCEED;
        }
        
        return $errors;
    }
}
