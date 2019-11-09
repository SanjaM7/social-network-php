<?php

namespace SocialNetwork\Helpers;

trait ErrorTrait
{
    public function setError($error)
    {
        $_SESSION["error"] = $error;
    }

    public function getAndClearError()
    {
        $error = array();
        if (isset($_SESSION["error"])) {
            $error = $_SESSION["error"];
        }

        $this->setError(null);
        if (!$error) {
            return array();
        }

        return (array) $error;
    }
}
