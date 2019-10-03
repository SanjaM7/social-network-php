<?php

class TimelineController
{
    private $sessionHelper;
    private $pageHelper;
    private $statusService;
    private $myProfileId;
    private $friendshipService;
    private $likeService;

    public function __construct()
    {
        $this->sessionHelper = new SessionHelper();
        $this->sessionHelper->requireAuthorized();
        $this->pageHelper = new PageHelper();
        $accountId = $this->sessionHelper->getUserId();
        $profileService = new ProfileService();
        $this->myProfileId = $profileService->getProfileIdFromAccountId($accountId);
        $this->friendshipService = new FriendshipService();
        $this->statusService = new StatusService();
        $this->likeService = new LikeService();
    }

    function GET_view()
    {
        $statusesAndReplies = $this->statusService->getStatusesAndReplies($this->myProfileId);
        $statuses = $statusesAndReplies["statuses"];
        $replies = $statusesAndReplies["replies"];
     
        $status = NULL;
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

    function POST_postStatus()
    {
        $text = $_POST["text"];
        $parentId = NULL;

        $statusErrors = $this->statusService->postStatus($text, $this->myProfileId, $parentId);

        $status = 'status-success';    
        if ($statusErrors) {
            $this->sessionHelper->setError(array("statusErrors" => $statusErrors));
            $status = 'status-error';
        } 

        header("Location: /timeline/view?status=$status");
    }

    function POST_reply()
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

    function POST_like()
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
}
