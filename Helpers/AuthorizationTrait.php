<?php

namespace SocialNetwork\Helpers;

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
