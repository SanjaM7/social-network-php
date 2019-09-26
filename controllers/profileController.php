<?php

class ProfileController
{
    private $sessionHelper;
    private $pageHelper;
    private $profileService;
    private $friendshipService;
    private $accountId;

    public function __construct()
    {
        $this->sessionHelper = new SessionHelper();
        $this->sessionHelper->requireAuthorized();
        $this->pageHelper = new PageHelper();
        $this->profileService = new ProfileService();
        $this->friendshipService = new FriendshipService();


        $this->accountId = $this->sessionHelper->getUserId();
    }
    function GET_view()
    {
        if (isset($_GET['profileId'])) {
            $friendProfileId = $_GET['profileId'];
            $friendProfile = $this->profileService->getProfileFromId($friendProfileId);

            $myProfileId = $this->profileService->getProfileIdFromAccountId($this->accountId);
            $friendshipState = $this->friendshipService->getFriendshipStateFromProfileIds($myProfileId, $friendProfileId);

            $error = $this->sessionHelper->getAndClearFriendshipError();

            $friendProfileError = $this->profileService->validateFriendProfile($friendProfileId);

            if ($friendProfileError !== null) {
                $params = array("profile" => $friendProfile, "state" => $friendshipState, "error" => $error, "friendProfileError" => $friendProfileError);
                $this->pageHelper->displayPage("profile/view.php", $params);
                return;
            }

            $params = array("profile" => $friendProfile, "state" => $friendshipState, "error" => $error);
            $this->pageHelper->displayPage("profile/view.php", $params);
        } else {
            $myProfile = $this->profileService->getProfileFromAccountId($this->accountId);

            $params = array("profile" => $myProfile);
            $this->pageHelper->displayPage("profile/view.php", $params);
        }
    }

    function GET_edit()
    {
        $this->pageHelper->displayPage("profile/edit.php");
    }

    function POST_edit()
    {
        $firstName = $_POST["firstName"];
        $lastName = $_POST["lastName"];
        $yearOfBirth = $_POST["yearOfBirth"];
        $image = $_FILES["image"];
        $gender = $_POST["gender"];

        $myProfile = $this->profileService->getProfileFromAccountId($this->accountId);
        $errors = $this->profileService->validateProfileParams($myProfile, $firstName, $lastName, $yearOfBirth, $image);

        $params = array("errors" => $errors);
        if (count($errors) > 0) {
            $this->pageHelper->displayPage("profile/edit.php", $params);
            return;
        }

        $this->profileService->editProfile($myProfile, $firstName,  $lastName, $yearOfBirth, $image, $gender);
        header("Location: /profile/view?editProfile=success");
    }

    function GET_search()
    {
        header("Location: /index");
    }

    function POST_search()
    {
        $searchName = $_POST["searchName"];
        $profiles = $this->profileService->searchProfile($searchName);
        $myProfileId = $this->profileService->getProfileIdFromAccountId($this->accountId);

        $params = array("profiles" => $profiles, "query" => $searchName, "myProfileId" => $myProfileId);
        $this->pageHelper->displayPage("profile/search.php", $params);
    }
}
