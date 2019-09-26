<?php

require_once realpath(dirname(__FILE__) . "/../helpers/sessionHelper.php");

class FriendshipService
{
    private $repository;
    function __construct()
    {
        $this->repository = new FriendshipRepository();
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

    public function getFriends($myProfileId)
    {
        $friends = $this->repository->getFriends($myProfileId);
        return $friends;
    }

    public function getFriendsProfilesIds($myProfileId)
    {
        $friends = $this->getFriends($myProfileId);
        $friendsProfilesIds = array();
        foreach ($friends as $friend) {
            $friendsProfilesIds[] = $friend->getId();
        }
        return $friendsProfilesIds;
    }

    public function getFriendRequests($myProfileId)
    {
        $friendRequests = $this->repository->getFriendRequests($myProfileId);
        return $friendRequests;
    }

    public function addFriendship($myProfileId, $friendProfileId)
    {
        $friendship = new Friendship($myProfileId, $friendProfileId, FriendshipState::NotFriends);
        $this->repository->addFriendship($friendship);
    }

    public function removeFriendship($myProfileId, $friendProfileId)
    {
        $friendship = $this->repository->getFriendship($myProfileId, $friendProfileId);
        $this->repository->removeFriendship($friendship);
    }

    public function withdrawFriendshipRequest($myProfileId, $friendProfileId)
    {
        $friendship = $this->repository->getFriendship($myProfileId, $friendProfileId);
        $this->repository->withrawFriendshipRequest($friendship);
    }

    public function acceptFriendshipRequest($myProfileId, $friendProfileId)
    {
        $friendship = $this->repository->getFriendship($myProfileId, $friendProfileId);
        $this->repository->acceptFriendshipRequest($friendship);
    }

    public function declineFriendshipRequest($myProfileId, $friendProfileId)
    {
        $friendship = $this->repository->getFriendship($myProfileId, $friendProfileId);
        $this->repository->declineFriendshipRequest($friendship);
    }

    public function validateAddFriendship($myProfileId, $friendProfileId)
    {
        $friendship = $this->repository->getFriendship($myProfileId, $friendProfileId);
        $error = null;
        if($friendProfileId == $myProfileId){
            $error = FriendshipError::YourProfile;
        }
        if ($friendship) {
            if ($friendship->getStatus() == FriendshipState::Friends) {
                $error = FriendshipError::Friends;
            } elseif ($friendship->getStatus() == FriendshipState::SentFriendRequest) {
                $error = FriendshipError::SentFriendRequest;
            } elseif ($friendship->getStatus() == FriendshipState::HaveFriendRequest) {
                $error = FriendshipState::HaveFriendRequest;
            }
        }

        return $error;
    }

    public function validateRemoveFriendship($myProfileId, $friendProfileId)
    {
        $friendship = $this->repository->getFriendship($myProfileId, $friendProfileId);
        $error = null;
        if (!$friendship) {
            $error = FriendshipError::NotFriends;
        } elseif ($friendship->getStatus() == FriendshipState::SentFriendRequest) {
            $error = FriendshipError::SentFriendRequest;
        } elseif ($friendship->getStatus() == FriendshipState::HaveFriendRequest) {
            $error = FriendshipState::HaveFriendRequest;
        }

        return $error;
    }

    public function validateWithdrawFriendshipRequest($myProfileId, $friendProfileId)
    {
        $friendship = $this->repository->getFriendship($myProfileId, $friendProfileId);
        $error = null;
        if (!$friendship) {
            $error = FriendshipError::NotFriends;
        } elseif ($friendship && $friendship->getStatus() == FriendshipState::Friends){
            $error = FriendshipError::Friends;
        } elseif ($friendship && $friendship->getStatus() == FriendshipState::HaveFriendRequest) {
            $error = FriendshipState::HaveFriendRequest;
        }

        return $error;
    }

    public function validateAcceptFriendshipRequest($myProfileId, $friendProfileId)
    {
        $friendship = $this->repository->getFriendship($myProfileId, $friendProfileId);
        $error = null;
        if (!$friendship) {
            $error = FriendshipError::NotFriends;
        } elseif ($friendship && $friendship->getStatus() == FriendshipState::Friends){
            $error = FriendshipError::Friends;
        } elseif($friendship && $friendship->getStatus() == FriendshipState::SentFriendRequest){
            $error = FriendshipError::SentFriendRequest;
        }

        return $error;
    }

    public function ValidateDeclineFriendshipRequest($myProfileId, $friendProfileId)
    {
        $friendship = $this->repository->getFriendship($myProfileId, $friendProfileId);
        $error = null;
        if (!$friendship) {
            $error = FriendshipError::NotFriends;
        } elseif ($friendship && $friendship->getStatus() == FriendshipState::Friends){
            $error = FriendshipError::Friends;
        } elseif($friendship && $friendship->getStatus() == FriendshipState::SentFriendRequest){
            $error = FriendshipError::SentFriendRequest;
        }

        return $error;
    }
}
