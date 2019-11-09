<?php

namespace SocialNetwork\Repository;

use SocialNetwork\Database\Db;
use SocialNetwork\Models\Like;

class LikeRepository
{
    public function isLiked(Like $like)
    {
        $query = "SELECT * FROM likes WHERE statusId = :statusId AND profileId = :profileId";
        $params = array(
            ":statusId" => $like->getStatusId(),
            ":profileId" => $like->getProfileId()
        );
        $result = Db::queryExists($query, $params);
        return $result;
    }

    public function like(Like $like)
    {
        $query = "INSERT INTO likes (statusId, profileId) VALUES (:statusId, :profileId)";
        $params = array(
            ":statusId" => $like->getStatusId(),
            "profileId" => $like->getProfileId()
        );
        $id = Db::queryInsert($query, $params);
    }

    public function unlike(Like $like)
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
            return null;
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
