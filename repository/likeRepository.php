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
        $result = DB::querySelect($query, $params);
        return $result;
    }

    public function like($like)
    {
        $query = "INSERT INTO likes (statusId, profileId) VALUES (:statusId, :profileId)";
        $params = array(
            ":statusId" => $like->getStatusId(),
            "profileId" => $like->getProfileId()
        );
        $id = DB::queryInsert($query, $params);
    }
}