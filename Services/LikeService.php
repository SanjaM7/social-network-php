<?php

namespace SocialNetwork\Services;

use SocialNetwork\Interfaces\ILikeService;
use SocialNetwork\Models\Status;
use SocialNetwork\Models\Like;
use SocialNetwork\Models\LikeError;
use SocialNetwork\Repository\LikeRepository;

class LikeService implements ILikeService
{
    private $repository;

    public function __construct()
    {
        $this->repository = new LikeRepository();
    }

    public function like($statusId, $myProfileId, Status $status, Array $friends)
    {
        $errors = $this->validateLike($statusId, $myProfileId, $status, $friends);
        if ($errors) {
            return $errors;
        }
        $like = new Like($statusId, $myProfileId);
        $this->repository->like($like);
        return array();
    }

    public function validateLike($statusId, $myProfileId, Status $status, Array $friends)
    {
        $like = new Like($statusId, $myProfileId);
        $errors = array();
        $canLike = false;
        if ($this->repository->isLiked($like)) {
            $errors[] = LikeError::STATUS_ALREADY_LIKED;
        } elseif (!$status) {
            $errors[] = LikeError::STATUS_DOES_NOT_EXISTS;
        } elseif ($friends) {
            foreach ($friends as $friend) {
                if ($status->getProfileId() == $friend->getId()) {
                    $canLike = true;
                }
            }
            if ($status->getProfileId() == $myProfileId) {
                $canLike = true;
            }
            if ($canLike == false) {
                $errors[] = LikeError::NOT_YOUR_FRIEND;
            }
        }

        return $errors;
    }

    public function unlike($statusId, $myProfileId, Status $status, Array $friends)
    {
        $like = $this->repository->getLike($statusId, $myProfileId);
        $errors = $this->validateUnlike($like, $statusId, $myProfileId, $status, $friends);
        if ($errors) {
            return $errors;
        }

        $this->repository->unlike($like);
        return array();
    }

    public function validateUnlike(Like $like, $statusId, $myProfileId, Status $status, Array $friends)
    {
        $errors = array();
        $canUnlike = false;
        if (!$this->repository->isLiked($like)) {
            $errors[] = LikeError::STATUS_NOT_LIKED;
        } elseif (!$status) {
            $errors[] = LikeError::STATUS_DOES_NOT_EXISTS;
        } elseif ($friends) {
            foreach ($friends as $friend) {
                if ($status->getProfileId() == $friend->getId()) {
                    $canUnlike = true;
                }
            }
            if ($status->getProfileId() == $myProfileId) {
                $canUnlike = true;
            }
            if ($canUnlike == false) {
                $errors[] = LikeError::NOT_YOUR_FRIEND;
            }
        }

        return $errors;
    }
}
