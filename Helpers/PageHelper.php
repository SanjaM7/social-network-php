<?php

namespace SocialNetwork\Helpers;

use SocialNetwork\Models\ViewContext;

class PageHelper
{
    /**
     * @var ViewContext
     */
    private $context;

    public function __construct()
    {
        $sessionHelper = new SessionHelper();
        $this->context = new ViewContext($sessionHelper->isLoggedIn());
    }

    public function displayPage($viewName, $params = array())
    {
        $viewName = realpath(dirname(__FILE__) . "/../views/$viewName");
        require_once realpath(dirname(__FILE__) . "/../views/shared/layout.php");
    }
}
