<?php

class IndexController
{
    private $sessionHelper;
    private $pageHelper;
    private $profileService;
    private $accountId;

    public function __construct()
    {
        $this->sessionHelper = new SessionHelper();
        $this->pageHelper = new PageHelper();
        $this->profileService = new ProfileService();
        $this->accountId = $this->sessionHelper->getUserId();
    }
    function GET_index()
    {
        $params = array();
        if ($this->sessionHelper->isLoggedIn()) {

            $myProfile = $this->profileService->getProfileFromAccountId($this->accountId);
            
            $params = array("profile" => $myProfile);
        }

        $this->pageHelper->displayPage('index.php', $params);

        
    }
}
