<?php

namespace SocialNetwork\Interfaces;

interface IStatusService
{
    public function postStatus($text, $myProfileId, $parentId);
    public function reply($text, $myProfileId, $parentId, Array $friends);
    public function validateStatus($text, $myProfileId, $parentId);
    public function getStatusFromId($id);
    public function getStatusesAndReplies($myProfileId);
}
