<?php

class Account
{
    private $id;
    private $username;
    private $email;
    private $hashedPassword;

    public function __construct($username, $email, $password, $passwordRepeat)
    {

        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->passwordRepeat = $passwordRepeat;
        $this->hashedPassword = $this->hashPassword($password);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getHashedPassword()
    {
        return $this->hashedPassword;
    }

    private function hashPassword($password)
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setHashedPassword($hashedPassword)
    {
        $this->hashedPassword = $hashedPassword;
    }

    /**
     * Validate create account parameters and returns errors array if there are errors
     */
    public function validateAccountParams()
    {
        $errors = array();

        if (!preg_match("/^[A-Za-z][A-Za-z0-9]{2,31}$/", $this->username)) {
            array_push($errors, AccountError::InvalidUsername);
        }

        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            array_push($errors, AccountError::InvalidEmail);
        }

        if (strlen($this->password) < 6 || strlen($this->password) > 60) {
            array_push($errors, AccountError::InvalidPassword);
        }

        if ($this->password !== $this->passwordRepeat) {
            array_push($errors, AccountError::InvalidPasswordRepeat);
        }

        return $errors;
    }

    /**
     * Returs true if password match password in database otherwise false
     */
    public function isPasswordMatching($password)
    {
        $pwdMatch = password_verify($password, $this->hashedPassword);
        return $pwdMatch;
    }
}
