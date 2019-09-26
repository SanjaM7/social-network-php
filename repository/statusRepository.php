<?php

class StatusRepository
{
    public function postStatus($status)
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

    public function getStatuses($myProfileId)
    {
        $query = "SELECT s.id, s.text, s.profileId, s.parentId, s.createdAt, s.updatedAt, 
        p.accountId, p.firstName, p.lastName 
        FROM statuses AS s 
        INNER JOIN profiles AS p
        ON s.profileId = p.id
        WHERE s.profileId IN
        (
            SELECT senderId FROM friendships WHERE
            receiverId = :myProfileId AND status = :0
            UNION
            SELECT receiverId FROM friendships WHERE
            senderId = :myProfileId AND status = :0
            UNION
            SELECT :myProfileId       
        )
        AND s.parentId IS NULL
        ORDER BY s.updatedAt DESC
        ";
        $params = array(
            "myProfileId" => $myProfileId,
            ":0" => 0

        );
        $result = DB::querySelect($query, $params);

        if (!$result) {
            return array();
        }

        $statuses = $this->mapToStatusesView($result);

        return $statuses;
    }

    public function getReplies($myProfileId)
    {
        $query = "SELECT s.id, s.text, s.profileId, s.parentId, s.createdAt, s.updatedAt, 
        p.accountId, p.firstName, p.lastName 
        FROM statuses AS s 
        INNER JOIN profiles AS p
        ON s.profileId = p.id
        WHERE s.profileId IN
        (
            SELECT senderId FROM friendships WHERE
            receiverId = :myProfileId AND status = :0
            UNION
            SELECT receiverId FROM friendships WHERE
            senderId = :myProfileId AND status = :0
            UNION
            SELECT :myProfileId       
        )
        AND s.parentId IS NOT NULL
        ORDER BY s.updatedAt 
        ";
        $params = array(
            "myProfileId" => $myProfileId,
            ":0" => 0

        );
        $result = DB::querySelect($query, $params);

        if (!$result) {
            return array();
        }

        $replies = $this->mapToStatusesView($result);

        return $replies;
    }

    private function mapToStatusesView($result)
    {
        $statues = array();

        foreach ($result as $row) {
            $id = $row["id"];
            $text = $row["text"];
            $profileId = $row["profileId"];
            $parentId = $row["parentId"];
            $createdAt = $row["createdAt"];
            $updatedAt = $row["updatedAt"];
            $firstName = $row["firstName"];
            $lastName = $row["lastName"];

            $status = new StatusViewModel();
            $status->id = $id;
            $status->text = $text;
            $status->profileId = $profileId;
            $status->parentId = $parentId;
            $status->createdAt = $createdAt;
            $status->updatedAt = $updatedAt;
            $status->firstName = $firstName;
            $status->lastName = $lastName;

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
        $result = DB::querySelect($query, $params);

        if (!$result) {
            return NULL;
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
            $id = $row["id"];
            $text = $row["text"];
            $profileId = $row["profileId"];
            $parentId = $row["parentId"];
            $createdAt = $row["createdAt"];
            $updatedAt = $row["updatedAt"];

            $status = new Status($text, $profileId, $parentId);
            $status->setId($id);
            $status->setText($text);
            $status->setCreatedAt($createdAt);
            $status->setUpdatedAt($updatedAt);

            $statues[] = $status;
        }

        return $statues;
    }

}