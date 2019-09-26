<?php

class SessionHelper
{
    public function login($id)
    {
        $_SESSION["accountId"] = $id;
    }

    public function logout()
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

    public function setFriendshipError($error)
    {
        $_SESSION["friendshipError"] = $error;
    }

    public function getAndClearFriendshipError()
    {
        $error = null;
        if (isset($_SESSION["friendshipError"])) {
            $error = $_SESSION["friendshipError"];
        }
        
        $this->setFriendshipError(null);
        return $error;
    }

}
