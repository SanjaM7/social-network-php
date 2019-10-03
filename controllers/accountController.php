<?php

class AccountController
{
    private $sessionHelper;
    private $pageHelper;
    private $accountService;

    public function __construct()
    {
        $this->sessionHelper = new SessionHelper();
        $this->pageHelper = new PageHelper();
        $this->accountService = new AccountService();
    }

    function GET_create()
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

    function POST_create()
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

    function GET_logIn()
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

    function POST_logIn()
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

    function POST_logOut()
    {
        $this->sessionHelper->requireAuthorized();

        $this->sessionHelper->logOut();
        $status = "logOut-success";
        header("Location: /index?status=$status");
    }
}
