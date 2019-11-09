<?php

namespace SocialNetwork\Repository;

use SocialNetwork\Database\Db;
use SocialNetwork\Models\Friendship;
use SocialNetwork\Models\FriendshipState;

class FriendshipRepository
{
    public function getFriends($myProfileId)
    {
        $query = "SELECT * FROM friendships WHERE (
        (senderId = :myProfileId AND status = :status) 
        OR
        (receiverId = :myProfileId AND status = :status)
        )";
        $params = array(
            "myProfileId" => $myProfileId,
            ":status" => FriendshipState::FRIENDS
        );

        $result = Db::querySelect($query, $params);
        if (!$result) {
            return array();
        }

        $friends = array();
        foreach ($result as $row) {
            $senderId = $row["senderId"];
            $receiverId = $row["receiverId"];
            if ($senderId == $myProfileId) {
                $friendProfileId = $receiverId;
            } else {
                $friendProfileId = $senderId;
            }
            $repository = new ProfileRepository();
            $friends[] = $repository->getProfileFromId($friendProfileId);
        }
        
        return $friends;
    }

    public function getFriendRequests($myProfileId)
    {
        $query = "SELECT * FROM friendships WHERE receiverId = :myProfileId AND status = :status";
        $params = array(
            ":myProfileId" => $myProfileId,
            ":status" => FriendshipState::NOT_FRIENDS
        );

        $result = Db::querySelect($query, $params);
        if (!$result) {
            return array();
        }

        $friendRequests = array();
        foreach ($result as $row) {
            $senderId = $row["senderId"];
            $repository = new ProfileRepository();
            $friendRequests[] = $repository->getProfileFromId($senderId);
        }

        return $friendRequests;
    }
    
    public function getFriendship($myProfileId, $friendProfileId)
    {
        $query = "SELECT * FROM friendships WHERE 
        (senderId = :myProfileId AND receiverId = :friendProfileId)
        OR
        (senderId = :friendProfileId AND receiverId = :myProfileId)
        ";

        $params = array(
            ":myProfileId" => $myProfileId,
            ":friendProfileId" => $friendProfileId
        );

        $result = Db::querySelect($query, $params);
        if (!$result) {
            return array();
        }

        $friendship = $this->mapToFriendships($myProfileId, $result);

        if (count($friendship) > 0) {
            return $friendship[0];
        }

        return $friendship;
    }

    private function mapToFriendships($myProfileId, $result)
    {
        $friendships = array();

        foreach ($result as $row) {
            $friendState = null;
            $friendProfileId = null;

            $id = $row["id"];
            $senderId = $row["senderId"];
            $receiverId = $row["receiverId"];
            $status = $row["status"];

            if ($senderId == $myProfileId) {
                $friendProfileId = $receiverId;
            } else {
                $friendProfileId = $senderId;
            }

            if ($status == FriendshipState::FRIENDS) {
                $friendshipState = FriendshipState::FRIENDS;
            } else {
                if ($senderId == $myProfileId) {
                    $friendshipState = FriendshipState::SENT_FRIEND_REQUEST;
                } else {
                    $friendshipState = FriendshipState::HAVE_FRIEND_REQUEST;
                }
            }

            $friendship = new Friendship($myProfileId, $friendProfileId, $friendshipState);
            $friendship->setId($id);
            $friendships[] = $friendship;
        }

        return $friendships;
    }

    public function addFriendship(Friendship $friendship)
    {
        $query = "INSERT INTO friendships VALUES (null, :myProfileId, :friendProfileId, :status)";
        $params = array(
            ":myProfileId" => $friendship->getMyProfileId(),
            ":friendProfileId" => $friendship->getFriendProfileId(),
            ":status" => FriendshipState::NOT_FRIENDS
        );
        $id = Db::queryInsert($query, $params);
        $friendship->setId($id);
    }

    public function removeFriendship(Friendship $friendship)
    {
        $query = "DELETE FROM friendships WHERE id=:id";

        $params = array(
            ":id" =>$friendship->getId()
        );
        Db::queryDelete($query, $params);
    }

    public function withdrawFriendshipRequest(Friendship $friendship)
    {
        $query = "DELETE FROM friendships WHERE id = :id";
        $params = array(
            ":id" => $friendship->getId()
        );
        Db::queryDelete($query, $params);
    }

    public function acceptFriendshipRequest(Friendship $friendship)
    {
        $query = "UPDATE friendships SET status = :status WHERE id = :id";
        $params = array(
            ":status" => FriendshipState::FRIENDS,
            ":id" => $friendship->getId()
        );
        Db::queryUpdate($query, $params);
        $friendship->setStatus(FriendshipState::FRIENDS);
    }

    public function declineFriendshipRequest(Friendship $friendship)
    {
        $query = "DELETE FROM friendships WHERE id = :id";
        $params = array(
            ":id" => $friendship->getId()
        );
        Db::queryDelete($query, $params);
    }
}
