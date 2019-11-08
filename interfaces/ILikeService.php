<?php

interface iLikeService
{
    public function like($statusId, $myProfileId, $status, $friends);
    public function validateLike($statusId, $myProfileId, $status, $friends);
    public function unlike($statusId, $myProfileId, $status, $friends);
    public function validateUnlike($like, $statusId, $myProfileId, $status, $friends);
}