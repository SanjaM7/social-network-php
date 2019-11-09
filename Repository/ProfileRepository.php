<?php

namespace SocialNetwork\Repository;

use SocialNetwork\Database\Db;
use SocialNetwork\Models\Profile;

class ProfileRepository
{
    /**
     * Create profile = insert params into profiles table and sets the id of profile object
     * @param Profile $profile
     */
    public function createProfile(Profile $profile)
    {
        $query = "INSERT INTO profiles VALUES (null, :firstName, :lastName, :yearOfBirth, :image, :gender, :accountId)";
        $params = array(
            ":firstName" => $profile->getFirstName(),
            ":lastName" => $profile->getLastName(),
            ":yearOfBirth" => $profile->getYearOfBirth(),
            ":image" => $profile->getImage(),
            ":gender" => $profile->getGender(),
            ":accountId" => $profile->getAccountId()
        );

        $id = Db::queryInsert($query, $params);
        $profile->setId($id);
    }

    /**
     * Returns profile object who has passed accountId or NULL if profile with that accountId doesn't exists
     * @param $accountId
     * @return Profile|null
     */
    public function getProfileFromAccountId($accountId)
    {
        $query = "SELECT * FROM profiles WHERE accountId = :accountId";
        $params = array(":accountId" => $accountId);
        $result = Db::querySelect($query, $params);
        if (!$result) {
            return null;
        }

        return $this->mapToProfile($result[0]);
    }

    /**
     * Returns profile object who has passed profileId or NULL if profile with that profileId doesn't exists
     * @param $profileId
     * @return Profile|null
     */
    public function getProfileFromId($profileId)
    {
        $query = "SELECT * FROM profiles WHERE id = :profileId";
        $params = array(":profileId" => $profileId);
        $result = Db::querySelect($query, $params);
        if (!$result) {
            return null;
        }

        return $this->mapToProfile($result[0]);
    }

    /**
     * Mapping profile takes one row = $result[0] and returns profile
     * @param $row
     * @return Profile
     */
    private function mapToProfile($row)
    {
        $id = $row["id"];
        $firstName = $row["firstName"];
        $lastName = $row["lastName"];
        $yearOfBirth = $row["yearOfBirth"];
        $image = $row["image"];
        $gender = $row["gender"];
        $accountId = $row["accountId"];

        $profile = new Profile($accountId, $firstName);

        $profile->setId($id);
        $profile->setLastName($lastName);
        $profile->setYearOfBirth($yearOfBirth);
        $profile->setImage($image);
        $profile->setGender($gender);
        return $profile;
    }

    /**
     * Edit profile = update profiles table on given profile with given params
     * Takes image object and creates imageName and move image into folder
     * @param $profile
     */
    public function editProfile(Profile $profile)
    {
        $query = "UPDATE profiles SET firstName = :firstName, lastName = :lastName, 
        yearOfBirth = :yearOfBirth, image = :image, gender = :gender WHERE id = :id";
        $params = array(
            ":firstName" => $profile->getFirstName(),
            ":lastName" => $profile->getLastName(),
            ":yearOfBirth" => $profile->getYearOfBirth(),
            ":image" => $profile->getImage(),
            ":gender" => $profile->getGender(),
            ":id" => $profile->getId()
        );

        Db::queryUpdate($query, $params);
    }

    /**
     * Search table profiles on firstName or lastName and return all profiles that match or otherwise empty array
     * @param $searchName
     * @return array
     */
    public function searchProfile($searchName)
    {
        $query = "SELECT * FROM profiles WHERE firstName LIKE :searchName OR lastName LIKE :searchName";
        $params = array(
            ":searchName" => "%" . $searchName . "%"

        );
        $result = Db::querySelect($query, $params);
        if (!$result) {
            return array();
        }

        $profiles = array();
        foreach ($result as $row) {
            $profiles[] = $this->mapToProfile($row);
        }

        return $profiles;
    }
}
