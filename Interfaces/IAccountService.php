<?php

namespace SocialNetwork\Interfaces;

use SocialNetwork\Models\Account;

interface IAccountService
{
    public function createAccount($username, $email, $password, $passwordRepeat);
    public function validateAccount($username, $email, $password, $passwordRepeat);
    public function getAccount($username);
    public function validateLogIn(Account $account, $password);
}
