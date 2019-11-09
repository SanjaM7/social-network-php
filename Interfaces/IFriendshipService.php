<?php

namespace SocialNetwork\Interfaces;

use SocialNetwork\Models\Friendship;

interface IFriendshipService
{
    public function getFriends($myProfileId);
    public function getFriendRequests($myProfileId);
    public function addFriendship($myProfileId, $friendProfileId);
    public function validateAddFriendship($myProfileId, $friendProfileId);
    public function removeFriendship($myProfileId, $friendProfileId);
    public function validateRemoveFriendship(Friendship $friendship);
    public function withdrawFriendshipRequest($myProfileId, $friendProfileId);
    public function validateWithdrawFriendshipRequest(Friendship $friendship);
    public function acceptFriendshipRequest($myProfileId, $friendProfileId);
    public function validateAcceptFriendshipRequest(Friendship $friendship);
    public function declineFriendshipRequest($myProfileId, $friendProfileId);
    public function validateDeclineFriendshipRequest(Friendship $friendship);
    public function getFriendshipStateFromProfileIds($myProfileId, $friendProfileId);
}
