<?php

interface iAccountService 
{
    public function createAccount($username, $email, $password, $passwordRepeat);
    public function validateAccount($username, $email, $password, $passwordRepeat);
    public function getAccount($username);
    public function validateLogIn($account, $password);
}