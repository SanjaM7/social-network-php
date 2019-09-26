<?php

class StatusService
{
    private $repository;

    function __construct()
    {
        $this->repository = new StatusRepository();
    }

    function validateStatus($text, $myProfileId, $parentId)
    {
        $status = new Status($text, $myProfileId, $parentId);
        $errors = $status->validateStatusParams();
        return $errors;
    }

    function validateReply($text, $myProfileId, $parentId, $friends)
    {
        $errors = $this->validateStatus($text, $myProfileId, $parentId);
        $parentStatus = $this->repository->getStatusFromId($parentId);
        $canReply = FALSE;
        if ($parentStatus) {
            foreach ($friends as $friend) {
                if ($friend->getId() == $parentStatus->getProfileId() || $myProfileId == $parentStatus->getProfileId()) {
                    $canReply = TRUE;
                }
            }
        }
        if ($canReply == FALSE) {
            array_push($errors, StatusError::CanNotReply);
        }
        return $errors;
    }

    function postStatus($text, $profileId, $parentId)
    {
        $status = new Status($text, $profileId, $parentId);
        $this->repository->postStatus($status);
    }

    function getStatuses($myProfileId)
    {
        $statuses = $this->repository->getStatuses($myProfileId);
        return $statuses;
    }

    function getReplies($myProfileId)
    {
        $replies = $this->repository->getReplies($myProfileId);
        return $replies;
    }
}
