<?php

class AccountRepository
{
    /**
     * Query database and returns true if username exists or false
     */
    public function isUsernameTaken($username)
    {
        $query = "SELECT username FROM accounts WHERE username=:username";
        $params = array(":username" => $username);
        $result = DB::queryExists($query, $params);
        return $result;
    }

    /**
     * Query database and returns true if email exists or false
     */
    public function isEmailTaken($email)
    {
        $query = "SELECT email FROM accounts WHERE email=:email";
        $params = array(":email" => $email);
        $result = DB::queryExists($query, $params);
        return $result;
    }

    /**
     * Create account = insert params into accounts table, sets the id of account object and create profile with accountId
     */
    public function createAccount($account)
    {
        $query = "INSERT INTO accounts VALUES ('', :username, :email, :password)";
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
     */
    public function getAccount($username)
    {
        $query = "SELECT * FROM accounts WHERE username=:username";
        $params = array(":username" => $username);
        $result = DB::querySelect($query, $params);
        if (!$result) {
            return null;
        }

        return $this->mapToAccount($result[0]);
    }

    /**
     * Mapping account takes one row =  $result[0] and returns account
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
