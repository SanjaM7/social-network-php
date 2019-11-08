<?php

class PageHelper
{
    function __construct()
    {
        $sessionHelper = new SessionHelper();
        $this->context = new ViewContext($sessionHelper->isLoggedIn());
    }

    function displayPage($viewName, $params = array())
    {
        $viewName = realpath(dirname(__FILE__) . "/../views/$viewName");
        require_once realpath(dirname(__FILE__) . "/../views/shared/layout.php");
    }
}
