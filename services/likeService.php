<?php

class LikeService
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

    private function validateLike($statusId, $myProfileId, $status, $friends)
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

}
