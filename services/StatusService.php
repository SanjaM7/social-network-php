<?php

class StatusService implements IStatusService
{
    private $repository;

    public function __construct()
    {
        $this->repository = new StatusRepository();
    }

    public function postStatus($text, $myProfileId, $parentId)
    {
        $errors = $this->validateStatus($text, $myProfileId, $parentId);
        if ($errors) {
            return $errors;
        }
        $status = new Status($text, $myProfileId, $parentId);
        $this->repository->postStatus($status);
        return array();
    }

    public function reply($text, $myProfileId, $parentId, $friends)
    {
        $errors = $this->validateStatus($text, $myProfileId, $parentId);
        if ($errors) {
            return $errors;
        }
        $parentStatus = $this->getStatusFromId($parentId);
        $canReply = FALSE;
        if (!$parentStatus) {
            $errors[] = StatusError::StatusDoesNotExist;
        } else if ($parentStatus->getParentId() != NULL) {
            $errors[] = StatusError::CanNotReplyOnReply;
        } else if ($friends) {
            foreach ($friends as $friend) {
                if ($parentStatus->getProfileId() == $friend->getId()) {
                    $canReply = TRUE;
                }
            }
            if ($parentStatus->getProfileId() == $myProfileId) {
                $canReply = TRUE;
            }
            if ($canReply == FALSE) {
                $errors[] = StatusError::NotYourFriend;
            }
        }

        if($errors){
            return $errors;
        }

        $status = new Status($text, $myProfileId, $parentId);
        $this->repository->postStatus($status);
        return array();
    }

    
    public function validateStatus($text, $myProfileId, $parentId)
    {
        $status = new Status($text, $myProfileId, $parentId);
        $errors = $status->validateStatusParams();
        return $errors;
    }

    public function getStatusFromId($id)
    {
        $status = $this->repository->getStatusFromId($id);
        return $status;
    }

    public function getStatusesAndReplies($myProfileId)
    {
        $statusesAndReplies = $this->repository->getStatusesAndReplies($myProfileId);
        $statuses = array();
        $replies = array();
        if ($statusesAndReplies) {
            foreach ($statusesAndReplies as $statusOrReply) {
                if ($statusOrReply->parentId == NULL) {
                    $statuses[] = $statusOrReply;
                } else {
                    $replies[] = $statusOrReply;
                }
            }
        }
        $replies = array_reverse($replies);
        $statusesAndReplies = array("statuses" => $statuses, "replies" => $replies);
        return $statusesAndReplies;
    }
}
