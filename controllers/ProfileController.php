
<?php
class ProfileController extends Controller 
{
    private $profileService;
    private $friendshipService;
    private $accountId;

    public function __construct()
    {
        parent::__construct();
        $this->sessionHelper->requireAuthorized();
        $this->profileService = new ProfileService();
        $this->friendshipService = new FriendshipService();
        $this->accountId = $this->sessionHelper->getUserId();
    }

    public function GET_view()
    {
        $status = null;
        $frienshipErrors = $this->sessionHelper->getAndClearError();
        if (isset($_GET['status'])) {
            $status = $_GET['status'];
        }
        $params = array();
        
        if (isset($_GET["profileId"])) {
            $friendProfileId = $_GET["profileId"];
            $friendProfile = $this->profileService->getProfileFromId($friendProfileId);
            $myProfileId = $this->profileService->getProfileIdFromAccountId($this->accountId);
            $friendshipState = $this->friendshipService->getFriendshipStateFromProfileIds($myProfileId, $friendProfileId);

            $profileError = $this->profileService->validateProfile($friendProfileId);
            
            $params = array(
                "profile" => $friendProfile,
                "state" => $friendshipState,
                "myProfileId" => $myProfileId,
                "status" => $status,
                "profileError" => $profileError,
                "friendshipErrors" => array()
            );
        } else {
            $myProfile = $this->profileService->getProfileFromAccountId($this->accountId);
            $myProfileId = $myProfile->getId();
            $params = array(
                "profile" => $myProfile,
                "myProfileId" => $myProfileId,
                "status" => $status,
                "friendshipErrors" => array()
            );
        }

        $params = array_merge($params, $frienshipErrors);
        $this->pageHelper->displayPage("profile/view.php", $params);
    }

    public function GET_edit()
    {
        $status = null;
        $errors = $this->sessionHelper->getAndClearError();
        if (isset($_GET["status"])) {
            $status = $_GET["status"];        
        }

        $params = array(
            "status" => $status,
            "errors" => array()
        );
        $params = array_merge($params, $errors);
        $this->pageHelper->displayPage("profile/edit.php", $params);
    }

    public function POST_edit()
    {
        $firstName = $_POST["firstName"];
        $lastName = $_POST["lastName"];
        $yearOfBirth = $_POST["yearOfBirth"];
        $image = $_FILES["image"];
        $gender = $_POST["gender"];

        $errors = $this->profileService->editProfile($this->accountId, $firstName,  $lastName, $yearOfBirth, $image, $gender);

        $status = "profile-edit-success";
        if ($errors) {
            $this->sessionHelper->setError(array("errors" => $errors));
            $status = "profile-edit-error";
            header("Location: /profile/edit?status=$status");
            return;
        }

        header("Location: /profile/view?status=$status");
    }

    public function GET_search()
    {
        header("Location: /index");
    }

    public function POST_search()
    {
        $searchName = $_POST["searchName"];
        $profiles = $this->profileService->searchProfile($searchName);
        $myProfileId = $this->profileService->getProfileIdFromAccountId($this->accountId);
        $params = array(
            "profiles" => $profiles,
            "query" => $searchName,
            "myProfileId" => $myProfileId
        );

        $this->pageHelper->displayPage("profile/search.php", $params);
    }
}
