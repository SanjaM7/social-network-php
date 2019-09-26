<?php

class FriendController
{
    private $sessionHelper;
    private $pageHelper;
    private $friendshipService;
    private $profileService;
    private $myProfileId;

    public function __construct()
    {
        $this->sessionHelper = new SessionHelper();
        $this->sessionHelper->requireAuthorized();
        $this->pageHelper = new PageHelper();

        $this->friendshipService = new FriendshipService();
        $accountId = $this->sessionHelper->getUserId();
        $this->profileService = new ProfileService();
        $this->myProfileId = $this->profileService->getProfileIdFromAccountId($accountId);
    }

    function GET_view()
    {
        $friends = $this->friendshipService->getFriends($this->myProfileId);
        $friendRequests = $this->friendshipService->getFriendRequests($this->myProfileId);
        $params = array("friends" => $friends, "friendRequests" => $friendRequests);
        $this->pageHelper->displayPage("friend/view.php", $params);
    }

    function POST_addFriend()
    {
        $friendProfileId = $_POST["friendProfileId"];

        $friendProfile = $this->profileService->getProfileFromId($friendProfileId);
        $error = $this->friendshipService->validateAddFriendship($this->myProfileId, $friendProfileId, $friendProfile);

        if(!$friendProfile){
            header("Location: /profile/view?profileId=$friendProfileId");
            return;
        }

        if ($error !== null) {
            $this->sessionHelper->setFriendshipError($error);
            header("Location: /profile/view?profileId=$friendProfileId");
            return;
        }

        $this->friendshipService->addFriendship($this->myProfileId, $friendProfileId);
        header("Location: /profile/view?profileId=$friendProfileId");
    }

    function POST_removeFriend()
    {
        $friendProfileId = $_POST["friendProfileId"];

        $error = $this->friendshipService->validateRemoveFriendship($this->myProfileId, $friendProfileId);
        
        if ($error !== null) {
            $this->sessionHelper->setFriendshipError($error);
            header("Location: /profile/view?profileId=$friendProfileId");
            return;
        }

        $this->friendshipService->removeFriendship($this->myProfileId, $friendProfileId);
        header("Location: /profile/view?profileId=$friendProfileId");
    }

    function POST_withrawFriendRequest()
    {
        $friendProfileId = $_POST["friendProfileId"];

        $error = $this->friendshipService->validateWithdrawFriendshipRequest($this->myProfileId, $friendProfileId);

        if ($error !== null) {
            $this->sessionHelper->setFriendshipError($error);
            header("Location: /profile/view?profileId=$friendProfileId");
            return;
        }

        $this->friendshipService->withdrawFriendshipRequest($this->myProfileId, $friendProfileId);
        header("Location: /profile/view?profileId=$friendProfileId");
    }

    function POST_acceptFriendRequest()
    {
        $friendProfileId = $_POST["friendProfileId"];

        $error = $this->friendshipService->validateAcceptFriendshipRequest($this->myProfileId, $friendProfileId);

        if ($error !== null) {
            $this->sessionHelper->setFriendshipError($error);
            header("Location: /profile/view?profileId=$friendProfileId");
            return;
        }

        $this->friendshipService->acceptFriendshipRequest($this->myProfileId, $friendProfileId);
        header("Location: /profile/view?profileId=$friendProfileId");
    }

    function POST_declineFriendRequest()
    {
        $friendProfileId = $_POST["friendProfileId"];

        $error = $this->friendshipService->ValidateDeclineFriendshipRequest($this->myProfileId, $friendProfileId);

        if ($error !== null) {
            $this->sessionHelper->setFriendshipError($error);
            header("Location: /profile/view?profileId=$friendProfileId");
            return;
        }

        $this->friendshipService->declineFriendshipRequest($this->myProfileId, $friendProfileId);
        header("Location: /profile/view?profileId=$friendProfileId");
    }
}
