<?php

namespace SocialNetwork\Repository;

use SocialNetwork\Database\Db;
use SocialNetwork\Models\Account;
use SocialNetwork\Models\Profile;

class AccountRepository
{
    /**
     * Query database and returns true if username exists or false
     * @param $username
     * @return bool
     */
    public function isUsernameTaken($username)
    {
        $query = "SELECT username FROM accounts WHERE username=:username";
        $params = array(":username" => $username);
        $result = Db::queryExists($query, $params);
        return $result;
    }

    /**
     * Query database and returns true if email exists or false
     * @param $email
     * @return bool
     */
    public function isEmailTaken($email)
    {
        $query = "SELECT email FROM accounts WHERE email=:email";
        $params = array(":email" => $email);
        $result = Db::queryExists($query, $params);
        return $result;
    }

    /**
     * Create account=insert params into accounts table, sets the id of account object and create profile with accountId
     * @param $account
     */
    public function createAccount(Account $account)
    {
        $query = "INSERT INTO accounts VALUES (null, :username, :email, :password)";
        $params = array(
            ":username" => $account->getUsername(),
            ":email" => $account->getEmail(),
            ":password" => $account->getHashedPassword()
        );

        $id = Db::queryInsert($query, $params);
        $account->setId($id);

        $repository = new ProfileRepository();
        $profile = new Profile($id, $account->getUsername());
        $repository->createProfile($profile);
    }

    /**
     * Returns account object who has passed username or NULL if account with that username doesn't exists
     * @param $username
     * @return Account|null
     */
    public function getAccount($username)
    {
        $query = "SELECT * FROM accounts WHERE username=:username";
        $params = array(":username" => $username);
        $result = Db::querySelect($query, $params);
        if (!$result) {
            return null;
        }

        return $this->mapToAccount($result[0]);
    }

    /**
     * Mapping account takes one row =  $result[0] and returns account
     * @param $row
     * @return Account
     */
    private function mapToAccount($row)
    {
        $id = $row["id"];
        $username = $row["username"];
        $email = $row["email"];
        $hashedPassword = $row["password"];

        $account = new Account($username, $email, null, null);
        
        $account->setId($id);
        $account->setHashedPassword($hashedPassword);
        return $account;
    }
}
