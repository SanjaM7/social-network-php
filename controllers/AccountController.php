<?php

class AccountController extends Controller
{
    private $accountId;
    private $accountService;
    private $profileService;

    public function __construct()
    {
        parent::__construct();

        $this->accountId = $this->sessionHelper->getUserId();
        $this->profileService = new ProfileService();
        $this->accountService = new AccountService();
    }

    function GET_view()
    {
        $status = null;
        $errors = $this->sessionHelper->getAndClearError();
        if (isset($_GET['status'])) {
            $status = $_GET['status'];
        }
        $params = array();

        if ($this->sessionHelper->isLoggedIn()) {

            $myProfile = $this->profileService->getProfileFromAccountId($this->accountId);
            $status = "index-success";
            $params = array(
                "profile" => $myProfile,
                "status" => $status,
                "errors" => array()
            );
        } else {
            $params = array(
                "status" => $status,
                "errors" => array()
            );
        }

        $params = array_merge($params, $errors);
        $this->pageHelper->displayPage("index.php", $params);
    }

    public function GET_create()
    {
        $this->sessionHelper->requireUnauthorized();

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
        $this->pageHelper->displayPage("account/create.php", $params);
    }

    public function POST_create()
    {
        $this->sessionHelper->requireUnauthorized();

        $username = $_POST["username"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $passwordRepeat = $_POST["passwordRepeat"];

        $errors = $this->accountService->createAccount($username, $email, $password, $passwordRepeat);

        $status = "createAccount-success";
        if ($errors) {
            $this->sessionHelper->setError(array("errors" => $errors));
            $status = "createAccount-error";
            header("Location: /account/create?status=$status");
            return;
        }

        header("Location: /index?status=$status");
    }

    public function GET_logIn()
    {
        $this->sessionHelper->requireUnauthorized();

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
        $this->pageHelper->displayPage("account/logIn.php", $params);
    }

    public function POST_logIn()
    {
        $this->sessionHelper->requireUnauthorized();

        $username = $_POST["username"];
        $password = $_POST["password"];

        $account = $this->accountService->getAccount($username);
        $errors = $this->accountService->validateLogIn($account, $password);

        $status = "logIn-success";
        if ($errors) {
            $this->sessionHelper->setError(array("errors" => $errors));
            $status = "logIn-error";
            header("Location: /account/logIn?status=$status");
            return;
        }

        $this->sessionHelper->logIn($account->getId());
        header("Location: /index?status=$status");
    }

    public function POST_logOut()
    {
        $this->sessionHelper->requireAuthorized();

        $this->sessionHelper->logOut();
        $status = "logOut-success";
        header("Location: /index?status=$status");
    }
}
