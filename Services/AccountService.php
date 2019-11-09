<?php

namespace SocialNetwork\Services;

use SocialNetwork\Interfaces\IAccountService;
use SocialNetwork\Models\Account;
use SocialNetwork\Models\AccountError;
use SocialNetwork\Repository\AccountRepository;

class AccountService implements IAccountService
{
    private $repository;

    public function __construct()
    {
        $this->repository = new AccountRepository();
    }

    public function createAccount($username, $email, $password, $passwordRepeat)
    {
        $errors = $this->validateAccount($username, $email, $password, $passwordRepeat);
        if ($errors) {
            return $errors;
        }

        $account = new Account($username, $email, $password, $passwordRepeat);
        $this->repository->createAccount($account);
        return array();
    }

    public function validateAccount($username, $email, $password, $passwordRepeat)
    {
        $account = new Account($username, $email, $password, $passwordRepeat);
        $errors = $account->validateAccountParams();

        if (empty($errors)) {
            if ($this->repository->isUsernameTaken($username)) {
                $errors[] = AccountError::USERNAME_TAKEN;
            } elseif ($this->repository->isEmailTaken($email)) {
                $errors[] = AccountError::EMAIL_TAKEN;
            }
        }

        return $errors;
    }

    public function getAccount($username)
    {
        $account = $this->repository->getAccount($username);
        return $account;
    }

    public function validateLogIn($account, $password)
    {
        $errors = array();
        if (!$account) {
            $errors[] = AccountError::ACCOUNT_DOES_NOT_EXISTS;
        } elseif (!$account->isPasswordMatching($password)) {
            $errors[] = AccountError::INVALID_PASSWORD;
        }

        return $errors;
    }
}
