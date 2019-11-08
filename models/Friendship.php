<?php
class Friendship
{
    private $id;
    private $myProfileId;
    private $friendProfileId;
    private $status;

    public function __construct($myProfileId, $friendProfileId, $status)
    {
        $this->myProfileId = $myProfileId;
        $this->friendProfileId = $friendProfileId;
        $this->status = $status;
    }

    public function getId()
    {
        return $this->id;
    }
    public function getMyProfileId()
    {
        return $this->myProfileId;
    }

    public function getFriendProfileId()
    {
        return $this->friendProfileId;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }
    
}
