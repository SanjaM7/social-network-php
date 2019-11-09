<?php

namespace SocialNetwork\Helpers;

trait AuthenticationTrait
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
        if (!$this->isLoggedIn()) {
            return null;
        }

        return $_SESSION["accountId"];
    }

    public function isLoggedIn()
    {
        return isset($_SESSION["accountId"]);
    }
}
