<?php 

interface iFriendshipService
{
    public function getFriends($myProfileId);
    public function getFriendRequests($myProfileId);
    public function addFriendship($myProfileId, $friendProfileId);
    public function validateAddFriendship($myProfileId, $friendProfileId);
    public function removeFriendship($myProfileId, $friendProfileId);
    public function validateRemoveFriendship($friendship);
    public function withdrawFriendshipRequest($myProfileId, $friendProfileId);
    public function validateWithdrawFriendshipRequest($friendship);
    public function acceptFriendshipRequest($myProfileId, $friendProfileId);
    public function validateAcceptFriendshipRequest($friendship);
    public function declineFriendshipRequest($myProfileId, $friendProfileId);
    public function validateDeclineFriendshipRequest($friendship);
    public function getFriendshipStateFromProfileIds($myProfileId, $friendProfileId);
}