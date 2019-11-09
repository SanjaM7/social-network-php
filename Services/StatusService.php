<?php

namespace SocialNetwork\Services;

use SocialNetwork\Interfaces\IStatusService;
use SocialNetwork\Models\Status;
use SocialNetwork\Models\StatusError;
use SocialNetwork\Repository\StatusRepository;

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

    public function reply($text, $myProfileId, $parentId, Array $friends)
    {
        $errors = $this->validateStatus($text, $myProfileId, $parentId);
        if ($errors) {
            return $errors;
        }
        $parentStatus = $this->getStatusFromId($parentId);
        $canReply = false;
        if (!$parentStatus) {
            $errors[] = StatusError::STATUS_DOES_NOT_EXIST;
        } elseif ($parentStatus->getParentId() != null) {
            $errors[] = StatusError::CAN_NOT_REPLY_ON_REPLY;
        } elseif ($friends) {
            foreach ($friends as $friend) {
                if ($parentStatus->getProfileId() == $friend->getId()) {
                    $canReply = true;
                }
            }
            if ($parentStatus->getProfileId() == $myProfileId) {
                $canReply = true;
            }
            if ($canReply == false) {
                $errors[] = StatusError::NOT_YOUR_FRIEND;
            }
        }

        if ($errors) {
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
                if ($statusOrReply->parentId == null) {
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
