<?php

class LikeService implements ILikeService
{
    private $repository;

    public function __construct()
    {
        $this->repository = new LikeRepository();
    }

    public function like($statusId, $myProfileId, $status, $friends)
    {
        $errors = $this->validateLike($statusId, $myProfileId, $status, $friends);
        if ($errors) {
            return $errors;
        }
        $like = new Like($statusId, $myProfileId);
        $this->repository->like($like);
        return array();
    }

    public function validateLike($statusId, $myProfileId, $status, $friends)
    {
        $like = new Like($statusId, $myProfileId);
        $errors = array();
        $canLike = FALSE;
        if ($this->repository->isLiked($like)) {
            $errors[] = LikeError::StatusAlreadyLiked;
        } else if (!$status) {
            $errors[] = LikeError::StatusDoesNotExist;
        } else if ($friends) {
            foreach ($friends as $friend) {
                if ($status->getProfileId() == $friend->getId()) {
                    $canLike = TRUE;
                }
            }
            if ($status->getProfileId() == $myProfileId) {
                $canLike = TRUE;
            }
            if ($canLike == FALSE) {
                $errors[] = LikeError::NotYourFriend;
            }
        }

        return $errors;
    }

    public function unlike($statusId, $myProfileId, $status, $friends)
    {
        $like = $this->repository->getLike($statusId, $myProfileId);
        $errors = $this->validateUnlike($like, $statusId, $myProfileId, $status, $friends);
        if ($errors) {
            return $errors;
        }

        $this->repository->unlike($like);
        return array();
    }

    public function validateUnlike($like, $statusId, $myProfileId, $status, $friends)
    {
        $errors = array();
        $canUnlike = FALSE;
        if (!$this->repository->isLiked($like)) {
            $errors[] = LikeError::StatusIsNotLiked;
        } else if (!$status) {
            $errors[] = LikeError::StatusDoesNotExist;
        } else if ($friends) {
            foreach ($friends as $friend) {
                if ($status->getProfileId() == $friend->getId()) {
                    $canUnlike = TRUE;
                }
            }
            if ($status->getProfileId() == $myProfileId) {
                $canUnlike = TRUE;
            }
            if ($canUnlike == FALSE) {
                $errors[] = LikeError::NotYourFriend;
            }
        }

        return $errors;
    }
}
