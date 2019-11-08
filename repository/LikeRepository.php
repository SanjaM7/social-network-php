<?php

class LikeRepository
{

    public function isLiked($like)
    {
        $query = "SELECT * FROM likes WHERE statusId = :statusId AND profileId = :profileId";
        $params = array(
            ":statusId" => $like->getStatusId(),
            ":profileId" => $like->getProfileId()
        );
        $result = Db::queryExists($query, $params);
        return $result;
    }

    public function like($like)
    {
        $query = "INSERT INTO likes (statusId, profileId) VALUES (:statusId, :profileId)";
        $params = array(
            ":statusId" => $like->getStatusId(),
            "profileId" => $like->getProfileId()
        );
        $id = Db::queryInsert($query, $params);
    }

    public function unlike($like)
    {
        $query = "DELETE FROM likes WHERE statusId = :statusId AND profileId = :profileId";
        $params = array(
            ":statusId" => $like->getStatusId(),
            ":profileId" => $like->getProfileId()
        );
        Db::queryDelete($query, $params);
    }

    public function getLike($statusId, $profileId)
    {
        $query = "SELECT * FROM likes WHERE statusId = :statusId AND profileId = :profileId";
        $params = array(
            ":statusId" => $statusId,
            ":profileId" => $profileId
        );
        $result = Db::querySelect($query, $params);
        if (!$result) {
            return NULL;
        }

        return $this->mapToLike($result[0]);
    }

    private function mapToLike($row)
    {
        $statusId = $row["statusId"];
        $profileId = $row["profileId"];

        $like = new Like($statusId, $profileId);
        return $like;
    }
}