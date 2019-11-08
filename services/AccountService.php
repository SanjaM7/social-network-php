<?php

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
                $errors[] = AccountError::UsernameTaken;
            } elseif ($this->repository->isEmailTaken($email)) {
                $errors[] = AccountError::EmailTaken;
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
            $errors[] = AccountError::AccountDoesNotExists;
        } elseif (!$account->isPasswordMatching($password)) {
            $errors[] = AccountError::InvalidPassword;
        }

        return $errors;
    }
}
