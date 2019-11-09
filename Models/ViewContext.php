<?php

namespace SocialNetwork\Models;

class ViewContext
{
    public $isLoggedIn;

    public function __construct($isLoggedIn)
    {
        $this->isLoggedIn = $isLoggedIn;
    }
}
