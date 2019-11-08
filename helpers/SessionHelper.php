<?php

trait AutenticationTrait 
{
    public function logIn($id)
    {
        $_SESSION["accountId"] = $id;
    }

    public function logOut()
    {
        $_SESSION["accountId"] = null;
    }

    public function getUserId()
    {
        if(!$this->isLoggedIn()){
            return null;
        }

        return $_SESSION["accountId"];
    }

    public function isLoggedIn()
    {
        return isset($_SESSION["accountId"]);
    }
}

trait AuthorizationTrait
{
    public function requireAuthorized()
    {
        if (!$this->isLoggedIn()) {
            header("Location: /index");
            die();
        }
    }

    public function requireUnauthorized()
    {
        if ($this->isLoggedIn()) {
            header("Location: /index");
            return;
        }
    }
}

trait ErrorTrait
{
    public function setError($error)
    {
        $_SESSION["error"] = $error;
    }

    public function getAndClearError()
    {
        $error = array();
        if (isset($_SESSION["error"])) {
            $error = $_SESSION["error"];
        }

        $this->setError(null);
        if (!$error) {
            return array();
        }

        return (array) $error;
    }
}
class SessionHelper
{
    use AutenticationTrait, AuthorizationTrait, ErrorTrait;
}
