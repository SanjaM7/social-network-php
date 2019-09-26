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

        $this->pageHelper->displayPage("account/create.php");
    }

    function POST_create()
    {
        $this->sessionHelper->requireUnauthorized();

        $username = $_POST["username"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $passwordRepeat = $_POST["passwordRepeat"];

        $errors = $this->accountService->validateAccount($username, $email, $password, $passwordRepeat);

        $params = array("errors" => $errors);
        if (count($errors) > 0) {
            $this->pageHelper->displayPage("account/create.php", $params);
            return;
        }

        $this->accountService->createAccount($username, $email, $password, $passwordRepeat);
        header("Location: /index?createAccount=success");
    }

    function GET_logIn()
    {
        $this->sessionHelper->requireUnauthorized();

        $this->pageHelper->displayPage("account/logIn.php");
    }

    function POST_logIn()
    {

        $this->sessionHelper->requireUnauthorized();

        $username = $_POST["username"];
        $password = $_POST["password"];

        $account = $this->accountService->getAccount($username);

        $errors = $this->accountService->DoesAccountExists($account);
        if (count($errors) > 0) {
            $params = array("errors" => $errors);
            $this->pageHelper->displayPage("account/logIn.php", $params);
            return;
        }

        $errors = $this->accountService->isPasswordMatching($account, $password);
        if (count($errors) > 0) {
            $params = array("errors" => $errors);
            $this->pageHelper->displayPage("account/logIn.php", $params);
            return;
        }
        
        $this->sessionHelper->login($account->getId());
        header("Location: /index?logIn=success");
    }

    function POST_logOut()
    {
        $this->sessionHelper->requireAuthorized();

        $this->sessionHelper->logout();
        header("Location: /index?logOut=success");
    }

}
