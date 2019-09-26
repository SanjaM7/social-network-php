<?php

class ViewContext
{
    public function __construct($isLoggedIn)
    {
        $this->isLoggedIn = $isLoggedIn;
    }
}
