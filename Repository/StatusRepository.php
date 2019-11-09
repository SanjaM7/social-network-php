<?php

namespace SocialNetwork\Repository;

use SocialNetwork\Database\Db;
use SocialNetwork\Models\FriendshipState;
use SocialNetwork\Models\Status;
use SocialNetwork\Models\StatusViewModel;

class StatusRepository
{
    public function getStatusesAndReplies($myProfileId)
    {
        $query = "SELECT p.accountId, p.firstName, p.lastName, 
        s.id, s.text, s.profileId, s.parentId, s.createdAt, 
        COALESCE(likesCount.countOfLikes, 0) as countOfLikes, 
        COALESCE(myLikes.hasLike, 0) as hasMyLike
        FROM statuses as s  
        INNER JOIN profiles AS p
        ON s.profileId = p.id      
        LEFT JOIN (SELECT COUNT(statusId) as countOfLikes, statusId FROM likes GROUP BY statusId) as likesCount
        ON s.id = likesCount.statusId        
        LEFT JOIN (SELECT COUNT(statusId) as hasLike, statusId FROM likes
        WHERE profileId = :myProfileId GROUP BY statusId) as myLikes 
        ON s.id = myLikes.statusId        
            WHERE s.profileId IN
            (
                SELECT senderId FROM friendships WHERE
                receiverId = :myProfileId AND status = :status
                UNION
                SELECT receiverId FROM friendships WHERE
                senderId = :myProfileId AND status = :status
                UNION
                SELECT :myProfileId      
            )
            ORDER BY s.createdAt DESC
        ";
        $params = array(
            ":myProfileId" => $myProfileId,
            ":status" => FriendshipState::FRIENDS
        );

        $result = Db::querySelect($query, $params);

        if (!$result) {
            return array();
        }

        $statusesAndReplies = $this->mapToStatusesView($result);

        return $statusesAndReplies;
    }

    private function mapToStatusesView($result)
    {
        $statues = array();

        foreach ($result as $row) {
            $status = new StatusViewModel();
            $status->accountId = $row["accountId"];
            $status->firstName = $row["firstName"];
            $status->lastName = $row["lastName"];
            $status->id = $row["id"];
            $status->text = $row["text"];
            $status->profileId = $row["profileId"];
            $status->parentId = $row["parentId"];
            $status->createdAt = $row["createdAt"];
            $status->countOfLikes = $row["countOfLikes"];
            $status->hasMyLike = $row["hasMyLike"];

            $statues[] = $status;
        }

        return $statues;
    }

    public function getStatusFromId($id)
    {
        $query = "SELECT * FROM statuses WHERE id = :id";
        $params = array(
            ":id" => $id
        );
        $result = Db::querySelect($query, $params);

        if (!$result) {
            return null;
        }

        $status = $this->mapToStatuses($result);

        if (count($status) > 0) {
            return $status[0];
        }

        return $status;
    }

    private function mapToStatuses($result)
    {
        $statues = array();

        foreach ($result as $row) {
            $status = new Status($row["text"], $row["profileId"], $row["parentId"]);
            $status->setId($row["id"]);
            $status->setCreatedAt($row["createdAt"]);

            $statues[] = $status;
        }

        return $statues;
    }

    public function postStatus(Status $status)
    {
        $query = "INSERT into statuses(text, profileId, parentId) VALUES (:text, :profileId, :parentId)";
        $params = array(
            ":text" => $status->getText(),
            ":profileId" => $status->getProfileId(),
            ":parentId" => $status->getParentId()
        );
        $id = Db::queryInsert($query, $params);
        $status->setId($id);
    }
}
