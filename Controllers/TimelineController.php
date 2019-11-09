<?php

namespace SocialNetwork\Controllers;

use SocialNetwork\Services\FriendshipService;
use SocialNetwork\Services\LikeService;
use SocialNetwork\Services\ProfileService;
use SocialNetwork\Services\StatusService;

class TimelineController extends Controller
{
    private $statusService;
    private $myProfileId;
    private $friendshipService;
    private $likeService;

    public function __construct()
    {
        parent::__construct();
        $this->sessionHelper->requireAuthorized();
        $accountId = $this->sessionHelper->getUserId();
        $profileService = new ProfileService();
        $this->myProfileId = $profileService->getProfileIdFromAccountId($accountId);
        $this->friendshipService = new FriendshipService();
        $this->statusService = new StatusService();
        $this->likeService = new LikeService();
    }

    public function getView()
    {
        $statusesAndReplies = $this->statusService->getStatusesAndReplies($this->myProfileId);
        $statuses = $statusesAndReplies["statuses"];
        $replies = $statusesAndReplies["replies"];
     
        $status = null;
        $errors = $this->sessionHelper->getAndClearError();
        if (isset($_GET['status'])) {
            $status = $_GET['status'];
        }
        
        $params = array(
            "statuses" => $statuses,
            "replies" => $replies,
            "status" => $status,
            "errors" => array(),
            "statusErrors" => array(),
            "likeErrors" => array()
        );
        
        $params = array_merge($params, $errors);
        $this->pageHelper->displayPage("timeline/view.php", $params);
    }

    public function postPostStatus()
    {
        $text = $_POST["text"];
        $parentId = null;

        $statusErrors = $this->statusService->postStatus($text, $this->myProfileId, $parentId);

        $status = 'status-success';
        if ($statusErrors) {
            $this->sessionHelper->setError(array("statusErrors" => $statusErrors));
            $status = 'status-error';
        }

        header("Location: /timeline/view?status=$status");
    }

    public function postReply()
    {
        $text = $_POST["text"];
        $parentId = $_POST["parentId"];

        $friends = $this->friendshipService->getFriends($this->myProfileId);
        $statusErrors = $this->statusService->reply($text, $this->myProfileId, $parentId, $friends);

        $status = 'reply-success';
        if ($statusErrors) {
            $this->sessionHelper->setError(array("statusErrors" => $statusErrors));
            $status = 'reply-error';
        }

        header("Location: /timeline/view?status=$status");
    }

    public function postLike()
    {
        $statusId = $_POST['statusId'];

        $status = $this->statusService->getStatusFromId($statusId);
        $friends = $this->friendshipService->getFriends($this->myProfileId);

        $likeErrors = $this->likeService->like($statusId, $this->myProfileId, $status, $friends);

        $status = 'like-success';
        if ($likeErrors) {
            $this->sessionHelper->setError(array("likeErrors" => $likeErrors));
            $status = 'like-error';
        }

        header("Location: /timeline/view?status=$status");
    }

    public function postUnlike()
    {
        $statusId = $_POST['statusId'];

        $status = $this->statusService->getStatusFromId($statusId);
        $friends = $this->friendshipService->getFriends($this->myProfileId);

        $likeErrors = $this->likeService->unlike($statusId, $this->myProfileId, $status, $friends);

        $status = 'unlike-success';
        if ($likeErrors) {
            $this->sessionHelper->setError(array("likeErrors" => $likeErrors));
            $status = 'unlike-error';
        }

        header("Location: /timeline/view?status=$status");
    }
}
