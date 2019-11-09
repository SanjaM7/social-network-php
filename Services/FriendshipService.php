<?php

namespace SocialNetwork\Services;

use SocialNetwork\Interfaces\IFriendshipService;
use SocialNetwork\Models\Friendship;
use SocialNetwork\Models\FriendshipError;
use SocialNetwork\Models\FriendshipState;
use SocialNetwork\Repository\FriendshipRepository;

class FriendshipService implements IFriendshipService
{
    private $repository;
    public function __construct()
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

        $friendship = new Friendship($myProfileId, $friendProfileId, FriendshipState::NOT_FRIENDS);
        $this->repository->addFriendship($friendship);
        return array();
    }

    public function validateAddFriendship($myProfileId, $friendProfileId)
    {
        $friendship = $this->repository->getFriendship($myProfileId, $friendProfileId);
        $errors = array();
        if ($friendProfileId == $myProfileId) {
            $errors[] = FriendshipError::YOUR_PROFILE;
        } elseif ($friendship) {
            if ($friendship->getStatus() == FriendshipState::FRIENDS) {
                $errors[] = FriendshipError::FRIENDS;
            } elseif ($friendship->getStatus() == FriendshipState::SENT_FRIEND_REQUEST) {
                $errors[] = FriendshipError::SENT_FRIEND_REQUEST;
            } elseif ($friendship->getStatus() == FriendshipState::HAVE_FRIEND_REQUEST) {
                $errors[] = FriendshipError::HAVE_FRIEND_REQUEST;
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

    public function validateRemoveFriendship(Friendship $friendship)
    {
        $errors = array();
        if (!$friendship) {
            $errors[] = FriendshipError::NOT_FRIENDS;
        } elseif ($friendship->getStatus() == FriendshipState::SENT_FRIEND_REQUEST) {
            $errors[] = FriendshipError::SENT_FRIEND_REQUEST;
        } elseif ($friendship->getStatus() == FriendshipState::HAVE_FRIEND_REQUEST) {
            $errors[] = FriendshipError::HAVE_FRIEND_REQUEST;
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

    public function validateWithdrawFriendshipRequest(Friendship $friendship)
    {
        $errors = array();
        if (!$friendship) {
            $errors[] = FriendshipError::NOT_FRIENDS;
        } elseif ($friendship->getStatus() == FriendshipState::FRIENDS) {
            $errors[] = FriendshipError::FRIENDS;
        } elseif ($friendship->getStatus() == FriendshipState::HAVE_FRIEND_REQUEST) {
            $errors[] = FriendshipError::HAVE_FRIEND_REQUEST;
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

    public function validateAcceptFriendshipRequest(Friendship $friendship)
    {
        $errors = array();
        if (!$friendship) {
            $errors[] = FriendshipError::NOT_FRIENDS;
        } elseif ($friendship->getStatus() == FriendshipState::FRIENDS) {
            $errors[] = FriendshipError::FRIENDS;
        } elseif ($friendship->getStatus() == FriendshipState::SENT_FRIEND_REQUEST) {
            $errors[] = FriendshipError::SENT_FRIEND_REQUEST;
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

    public function validateDeclineFriendshipRequest(Friendship $friendship)
    {
        $errors = array();
        if (!$friendship) {
            $errors[] = FriendshipError::NOT_FRIENDS;
        } elseif ($friendship->getStatus() == FriendshipState::FRIENDS) {
            $errors[] = FriendshipError::FRIENDS;
        } elseif ($friendship->getStatus() == FriendshipState::SENT_FRIEND_REQUEST) {
            $errors[] = FriendshipError::SENT_FRIEND_REQUEST;
        }

        return $errors;
    }

    public function getFriendshipStateFromProfileIds($myProfileId, $friendProfileId)
    {
        $friendship = $this->repository->getFriendship($myProfileId, $friendProfileId);
        if (!$friendship) {
            $friendshipState = FriendshipState::NOT_FRIENDS;
        } else {
            $friendshipState = $friendship->getStatus();
        }
        return $friendshipState;
    }
}
