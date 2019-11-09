<?php

namespace SocialNetwork\Controllers;

use SocialNetwork\Helpers\PageHelper;
use SocialNetwork\Helpers\SessionHelper;

abstract class Controller
{
    protected $sessionHelper;
    protected $pageHelper;

    public function __construct()
    {
        $this->sessionHelper = new SessionHelper();
        $this->pageHelper = new PageHelper();
    }

    abstract protected function getView();
}
