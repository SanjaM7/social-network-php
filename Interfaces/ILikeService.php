<?php

namespace SocialNetwork\Interfaces;

use SocialNetwork\Models\Like;
use SocialNetwork\Models\Status;

interface ILikeService
{
    public function like($statusId, $myProfileId, Status $status, Array $friends);
    public function validateLike($statusId, $myProfileId, Status $status, Array $friends);
    public function unlike($statusId, $myProfileId, Status $status, Array $friends);
    public function validateUnlike(Like $like, $statusId, $myProfileId, Status $status, Array $friends);
}
