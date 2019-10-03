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

        $params = array(
            "friends" => $friends, 
            "friendRequests" => $friendRequests
        );

        $this->pageHelper->displayPage("friend/view.php", $params);
    }

    function POST_addFriend()
    {
        $friendProfileId = $_POST["friendProfileId"];
        $friendProfile = $this->profileService->getProfileFromId($friendProfileId);      
        if(!$friendProfile){
            header("Location: /profile/view?profileId=$friendProfileId");
            return;
        }
        
        $friendshipErrors =  $this->friendshipService->addFriendship($this->myProfileId, $friendProfileId);

        $status = 'addFriend-success';
        if ($friendshipErrors) {
            $this->sessionHelper->setError(array("friendshipErrors" => $friendshipErrors));
            $status = 'addFriend-error';
        }

        header("Location: /profile/view?profileId=$friendProfileId&status=$status");
    }

    function POST_removeFriend()
    {
        $friendProfileId = $_POST["friendProfileId"];
        $friendProfile = $this->profileService->getProfileFromId($friendProfileId);      
        if(!$friendProfile){
            header("Location: /profile/view?profileId=$friendProfileId");
            return;
        }

        $friendshipErrors = $this->friendshipService->removeFriendship($this->myProfileId, $friendProfileId);
        
        $status = 'removeFriend-success';
        if ($friendshipErrors) {
            $this->sessionHelper->setError(array("friendshipErrors" => $friendshipErrors));
            $status = 'removeFriend-error';
        }
      
        header("Location: /profile/view?profileId=$friendProfileId&status=$status");
    }

    function POST_withdrawFriendRequest()
    {
        $friendProfileId = $_POST["friendProfileId"];
        $friendProfile = $this->profileService->getProfileFromId($friendProfileId);      
        if(!$friendProfile){
            header("Location: /profile/view?profileId=$friendProfileId");
            return;
        }

        $friendshipErrors =  $this->friendshipService->withdrawFriendshipRequest($this->myProfileId, $friendProfileId);

        $status = 'withdrawFriendRequest-success';
        if ($friendshipErrors) {
            $this->sessionHelper->setError(array("friendshipErrors" => $friendshipErrors));
            $status = 'withdrawFriendRequest-error';
        }

        header("Location: /profile/view?profileId=$friendProfileId&status=$status");
    }

    function POST_acceptFriendRequest()
    {
        $friendProfileId = $_POST["friendProfileId"];
        $friendProfile = $this->profileService->getProfileFromId($friendProfileId);      
        if(!$friendProfile){
            header("Location: /profile/view?profileId=$friendProfileId");
            return;
        }

        $friendshipErrors = $this->friendshipService->acceptFriendshipRequest($this->myProfileId, $friendProfileId);

        $status = 'acceptFriendRequest-success';
        if ($friendshipErrors) {
            $this->sessionHelper->setError(array("friendshipErrors" => $friendshipErrors));
            $status = 'acceptFriendRequest-error';
        }
   
        header("Location: /profile/view?profileId=$friendProfileId&status=$status");
    }

    function POST_declineFriendRequest()
    {
        $friendProfileId = $_POST["friendProfileId"];
        $friendProfile = $this->profileService->getProfileFromId($friendProfileId);      
        if(!$friendProfile){
            header("Location: /profile/view?profileId=$friendProfileId");
            return;
        }

        $friendshipErrors = $this->friendshipService->declineFriendshipRequest($this->myProfileId, $friendProfileId);

        $status = 'declineFriendRequest-success';
        if ($friendshipErrors) {
            $this->sessionHelper->setError(array("friendshipErrors" => $friendshipErrors));
            $status = 'declineFriendRequest-error';
        }

        header("Location: /profile/view?profileId=$friendProfileId&status=$status");
    }
}
