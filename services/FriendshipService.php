<?php

class FriendshipService implements IFriendshipService
{
    private $repository;
    function __construct()
    {
        $this->repository = new FriendshipRepository();
    }

    public function getFriends($myProfileId)
    {
        $friends = $this->repository->getFriends($myProfileId);
        return $friends;
    }

    public function getFriendRequests($myProfileId)
    {
        $friendRequests = $this->repository->getFriendRequests($myProfileId);
        return $friendRequests;
    }

    public function addFriendship($myProfileId, $friendProfileId)
    {
        $errors = $this->validateAddFriendship($myProfileId, $friendProfileId);
        if ($errors) {
            return $errors;
        }

        $friendship = new Friendship($myProfileId, $friendProfileId, FriendshipState::NotFriends);
        $this->repository->addFriendship($friendship);
        return array();
    }

    public function validateAddFriendship($myProfileId, $friendProfileId)
    {
        $friendship = $this->repository->getFriendship($myProfileId, $friendProfileId);
        $errors = array();
        if ($friendProfileId == $myProfileId) {
            $errors[] = FriendshipError::YourProfile;
        } elseif ($friendship) {
            if ($friendship->getStatus() == FriendshipState::Friends) {
                $errors[] = FriendshipError::Friends;
            } elseif ($friendship->getStatus() == FriendshipState::SentFriendRequest) {
                $errors[] = FriendshipError::SentFriendRequest;
            } elseif ($friendship->getStatus() == FriendshipState::HaveFriendRequest) {
                $errors[] = FriendshipError::HaveFriendRequest;
            }
        }

        return $errors;
    }

    public function removeFriendship($myProfileId, $friendProfileId)
    {
        $friendship = $this->repository->getFriendship($myProfileId, $friendProfileId);
        $errors = $this->validateRemoveFriendship($friendship);
        if ($errors) {
            return $errors;
        }

        $this->repository->removeFriendship($friendship);
        return array();
    }

    public function validateRemoveFriendship($friendship)
    {
        $errors = array();
        if (!$friendship) {
            $errors[] = FriendshipError::NotFriends;
        } elseif ($friendship->getStatus() == FriendshipState::SentFriendRequest) {
            $errors[] = FriendshipError::SentFriendRequest;
        } elseif ($friendship->getStatus() == FriendshipState::HaveFriendRequest) {
            $errors[] = FriendshipError::HaveFriendRequest;
        }

        return $errors;
    }

    public function withdrawFriendshipRequest($myProfileId, $friendProfileId)
    {
        $friendship = $this->repository->getFriendship($myProfileId, $friendProfileId);
        $errors = $this->validateWithdrawFriendshipRequest($friendship);
        if ($errors) {
            return $errors;
        }

        $this->repository->withdrawFriendshipRequest($friendship);
        return array();
    }

    public function validateWithdrawFriendshipRequest($friendship)
    {
        $errors = array();
        if (!$friendship) {
            $errors[] = FriendshipError::NotFriends;
        } elseif ($friendship->getStatus() == FriendshipState::Friends) {
            $errors[] = FriendshipError::Friends;
        } elseif ($friendship->getStatus() == FriendshipState::HaveFriendRequest) {
            $errors[] = FriendshipError::HaveFriendRequest;
        }

        return $errors;
    }

    public function acceptFriendshipRequest($myProfileId, $friendProfileId)
    {
        $friendship = $this->repository->getFriendship($myProfileId, $friendProfileId);
        $errors = $this->validateAcceptFriendshipRequest($friendship);
        if ($errors) {
            return $errors;
        }

        $this->repository->acceptFriendshipRequest($friendship);
        return array();
    }

    public function validateAcceptFriendshipRequest($friendship)
    {
        $errors = array();
        if (!$friendship) {
            $errors[] = FriendshipError::NotFriends;
        } elseif ($friendship->getStatus() == FriendshipState::Friends) {
            $errors[] = FriendshipError::Friends;
        } elseif ($friendship->getStatus() == FriendshipState::SentFriendRequest) {
            $errors[] = FriendshipError::SentFriendRequest;
        }

        return $errors;
    }

    public function declineFriendshipRequest($myProfileId, $friendProfileId)
    {
        $friendship = $this->repository->getFriendship($myProfileId, $friendProfileId);
        $errors = $this->validateDeclineFriendshipRequest($friendship);
        if ($errors) {
            return $errors;
        }

        $this->repository->declineFriendshipRequest($friendship);
        return array();
    }

    public function validateDeclineFriendshipRequest($friendship)
    {
        $errors = array();
        if (!$friendship) {
            $errors[] = FriendshipError::NotFriends;
        } elseif ($friendship->getStatus() == FriendshipState::Friends) {
            $errors[] = FriendshipError::Friends;
        } elseif ($friendship->getStatus() == FriendshipState::SentFriendRequest) {
            $errors[] = FriendshipError::SentFriendRequest;
        }

        return $errors;
    }

    public function getFriendshipStateFromProfileIds($myProfileId, $friendProfileId)
    {
        $friendship = $this->repository->getFriendship($myProfileId, $friendProfileId);
        if (!$friendship) {
            $friendshipState = FriendshipState::NotFriends;
        } else {
            $friendshipState = $friendship->getStatus();
        }
        return $friendshipState;
    }

}
