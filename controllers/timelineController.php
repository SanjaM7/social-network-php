<?php

class TimelineController 
{
    private $sessionHelper;
    private $pageHelper;
    private $statusService;
    private $myProfileId;
    private $profileService;
    private $friendshipService;

    public function __construct()
    {
        $this->sessionHelper = new SessionHelper();
        $this->sessionHelper->requireAuthorized();
        $this->pageHelper = new PageHelper();
        $this->statusService = new StatusService();
        $accountId = $this->sessionHelper->getUserId();
        $profileService = new ProfileService();
        $this->myProfileId = $profileService->getProfileIdFromAccountId($accountId);
        $this->friendshipService = new FriendshipService();
    }

    function GET_view()
    {
        $statuses = $this->statusService->getStatuses($this->myProfileId);
        $replies = $this->statusService->getReplies($this->myProfileId);
        $params = array("statuses" => $statuses, "replies" => $replies);
        
        $this->pageHelper->displayPage("timeline/view.php", $params);
    }

    function POST_postStatus()
    {
        $text = $_POST["text"];
        $parentId = NULL;
        
        $statuses = $this->statusService->getStatuses($this->myProfileId);
        $replies = $this->statusService->getReplies($this->myProfileId);

        $errors = $this->statusService->validateStatus($text, $this->myProfileId, $parentId);
      
        if (count($errors) > 0) {
            $params = array("statuses" => $statuses, "replies" => $replies, "errors" => $errors);
            $this->pageHelper->displayPage("timeline/view.php", $params);
            return;
        }
        
        $this->statusService->postStatus($text, $this->myProfileId, $parentId);
        header("Location: view?postStatus=success");
    }

    function POST_reply()
    {
        $text = $_POST["text"];
        $parentId = $_POST["parentId"];

        $statuses = $this->statusService->getStatuses($this->myProfileId);
        $replies = $this->statusService->getReplies($this->myProfileId);

        $friends = $this->friendshipService->getFriends($this->myProfileId);
        $errors = $this->statusService->validateReply($text, $this->myProfileId, $parentId, $friends);

        if (count($errors) > 0) {
            $params = array("statuses" => $statuses, "replies" => $replies, "errors" => $errors);
            $this->pageHelper->displayPage("timeline/view.php", $params);
            return;
        }

        $this->statusService->postStatus($text, $this->myProfileId, $parentId);

        header("Location: view?reply=success");
    }

}