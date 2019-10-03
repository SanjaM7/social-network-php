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
        $status = null;
        $errors = $this->sessionHelper->getAndClearError();
        if (isset($_GET['status'])) {
            $status = $_GET['status'];
        }
        $params = array();

        if ($this->sessionHelper->isLoggedIn()) {

            $myProfile = $this->profileService->getProfileFromAccountId($this->accountId);
            $status = "index-success";
            $params = array(
                "profile" => $myProfile,
                "status" => $status,
                "errors" => array()
            );
        } else {
            $params = array(
                "status" => $status,
                "errors" => array()
            );
        }

        $params = array_merge($params, $errors);
        $this->pageHelper->displayPage("index.php", $params);
    }
}
