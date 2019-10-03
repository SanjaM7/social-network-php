<?php

class SessionHelper
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
        return $_SESSION["accountId"];
    }

    public function isLoggedIn()
    {
        return isset($_SESSION["accountId"]);
    }

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
