<?php

interface iStatusService
{
    public function postStatus($text, $myProfileId, $parentId);
    public function reply($text, $myProfileId, $parentId, $friends);
    public function validateStatus($text, $myProfileId, $parentId);
    public function getStatusFromId($id);
    public function getStatusesAndReplies($myProfileId);
}