<?php

class AccountService
{
    private $repository;

    function __construct()
    {
        $this->repository = new AccountRepository();
    }

    function validateAccount($username, $email, $password, $passwordRepeat)
    {
        $account = new Account($username, $email, $password, $passwordRepeat);
        $errors = $account->validateAccountParams();

        if(!count($errors)){
            if ($this->repository->isUsernameTaken($username)) {
                $errors[] = AccountError::UsernameTaken;
            } elseif ($this->repository->isEmailTaken($email)) {
                $errors[] = AccountError::EmailTaken;
            }
        }

        return $errors;
    }

    function createAccount($username, $email, $password, $passwordRepeat)
    {
        $account = new Account($username, $email, $password, $passwordRepeat);
        $this->repository->createAccount($account);
    }

    function getAccount($username)
    {
        $account = $this->repository->getAccount($username);
        return $account;
    }

    function DoesAccountExists($account)
    {
        $errors = array();
        if (!$account) {
            $errors[] = AccountError::AccountDoesNotExists;
        }
        return $errors;
    }

    function isPasswordMatching($account, $password)
    {
        $errors = array();
        if (!$account->isPasswordMatching($password)){
            $errors[] = AccountError::InvalidPassword;
        }
       return $errors;
    }
}


