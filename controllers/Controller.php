<?php 

abstract class Controller 
{
    protected $sessionHelper;
    protected $pageHelper;

    public function __construct()
    {
        $this->sessionHelper = new SessionHelper();
        $this->pageHelper = new PageHelper();
    }

    abstract protected function GET_view();
}