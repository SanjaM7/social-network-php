<?php
class StatusError
{
    const RequiredText = 0;
    const TextLimitExceed = 1;
    const CanNotReply = 2;
}
class Status
{
    private $id;
    private $text;
    private $profileId;
    private $parentId;
    private $createdAt;
    private $updatedAt;

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

    public function getUpdatedAt()
    {
        return $this->updatedAt;
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

    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    public function validateStatusParams()
    {
        $errors = array();
        if(empty($this->text)){
            array_push($errors, StatusError::RequiredText);
        }
        
        if(strlen($this->text) > 140){
            array_push($errors, StatusError::TextLimitExceed);
        }
        
        return $errors;
    }

}