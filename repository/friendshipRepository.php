<?php

class FriendshipRepository
{
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

        $result = DB::querySelect($query, $params);
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

            if ($status == FriendshipState::Friends) {
                $friendshipState = FriendshipState::Friends;
            } else {
                if ($senderId == $myProfileId) {
                    $friendshipState = FriendshipState::SentFriendRequest;
                } else {
                    $friendshipState = FriendshipState::HaveFriendRequest;
                }
            }

            $friendship = new Friendship($myProfileId, $friendProfileId, $friendshipState);
            $friendship->setId($id);
            $friendships[] = $friendship;
        }

        return $friendships;
    }

    public function getFriends($myProfileId)
    {
        $query = "SELECT * FROM friendships WHERE (
        (senderId = :myProfileId AND status = :0) 
        OR
        (receiverId = :myProfileId AND status = :0)
        )";
        $params = array(
            "myProfileId" => $myProfileId,
            ":0" => FriendshipState::Friends
        );

        $result = DB::querySelect($query, $params);
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
        $query = "SELECT * FROM friendships WHERE receiverId = :myProfileId AND status = :1";
        $params = array(
            ":myProfileId" => $myProfileId,
            ":1" => FriendshipState::NotFriends
        );

        $result = DB::querySelect($query, $params);
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

    public function addFriendship($friendship)
    {
        $query = "INSERT INTO friendships VALUES ('', :myProfileId, :friendProfileId, :1)";
        $params = array(
            ":myProfileId" => $friendship->getMyProfileId(),
            ":friendProfileId" => $friendship->getFriendProfileId(),
            ":1" => FriendshipState::NotFriends
        );
        $id = Db::queryInsert($query, $params);
        $friendship->setId($id);
    }

    public function removeFriendship($friendship)
    {
        $query = "DELETE FROM friendships WHERE id=:id";

        $params = array(
            ":id" =>$friendship->getId()
        );
        Db::queryDelete($query, $params);
    }

    public function withrawFriendshipRequest($friendship)
    {
        $query = "DELETE FROM friendships WHERE id = :id";
        $params = array(
            ":id" => $friendship->getId()
        );
        Db::queryDelete($query, $params);
    }

    public function acceptFriendshipRequest($friendship)
    {
        $query = "UPDATE friendships SET status = :0 WHERE id = :id";
        $params = array(
            ":0" => FriendshipState::Friends,
            ":id" => $friendship->getId()
        );
        Db::queryUpdate($query, $params);
        $friendship->setStatus(FriendshipState::Friends);
    }

    public function declineFriendshipRequest($friendship)
    {
        $query = "DELETE FROM friendships WHERE id = :id";
        $params = array(
            ":id" => $friendship->getId()
        );
        Db::queryDelete($query, $params);
    }


}
