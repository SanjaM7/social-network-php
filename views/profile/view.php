<?php if (isset($_GET['editProfile'])) : ?>
    <?php if ($_GET['editProfile'] == "success") : ?>
        <h4 class="alert alert-dismissible alert-success">Your profile has been updated. </h4>
    <?php endif; ?>
<?php endif; ?>

<div class="row">
    <div class="col-lg-6">
        <h3>Profile Info</h3>
        <hr class="my-4">
        <?php if (isset($params["profile"])) : ?>
            <?php $profile = $params['profile']; ?>
            <div class="row">
                <div class="col-lg-6">
                    <img src="/uploads/<?php echo $profile->getImage(); ?>" style='width:200px;'><br>
                </div>
                <div class="col-lg-6">
                    <p><b>First Name:</b> <?php echo $profile->getFirstName(); ?></p>
                    <p><b>Last Name:</b> <?php echo $profile->getLastName(); ?></p>
                    <p><b>Years:</b>
                        <?php if (!empty($profile->getYearOfBirth())) : ?>
                            <?php echo date("Y") - $profile->getYearOfBirth(); ?>
                        <?php endif; ?>
                    </p>
                    <p><b>Gender: </b> <?php echo $profile->getGender(); ?></p>
                    <?php if (!isset($_GET['profileId'])) : ?>
                        <a href="/profile/edit" class="btn btn-secondary">Edit Profile</a>
                    <?php endif; ?>

                    <?php if (isset($params['state'])) : ?>
                        <?php $state = $params['state'] ?>

                        <?php if ($state == FriendshipState::NotFriends) : ?>
                            <form action="/friend/addFriend" method="POST">
                                <input type="hidden" name="friendProfileId" value="<?php echo $profile->getId(); ?>" />
                                <input type="submit" name="addFriend" value="ADD AS FRIEND" class="btn btn-success" />
                            </form>
                        <?php endif; ?>
                        <?php if ($state  == FriendshipState::Friends) : ?>
                            <p>You and <?php echo $profile->getFirstName(); ?> are friends</p>
                            <form action="/friend/removeFriend" method="POST">
                                <input type="hidden" name="friendProfileId" value="<?php echo $profile->getId(); ?>" />
                                <input type="submit" name="removeFriend" value="REMOVE FROM FRIENDS" class="btn btn-danger">
                            </form>
                        <?php endif; ?>

                        <?php if ($state == FriendshipState::SentFriendRequest) : ?>
                            <p>Friend request sent</p>
                            <form action="/friend/withrawFriendRequest" method="POST">
                                <input type="hidden" name="friendProfileId" value="<?php echo $profile->getId(); ?>" />
                                <input type="submit" name="withrawFriendRequest" value="WITHRAW FRIEND REQUEST" class="btn btn-secondary">
                            </form>
                        <?php endif; ?>

                        <?php if ($state  == FriendshipState::HaveFriendRequest) : ?>
                            <form action="/friend/acceptFriendRequest" method="POST">
                                <input type="hidden" name="friendProfileId" value="<?php echo $profile->getId(); ?>" />
                                <input type="submit" name="acceptFriendRequest" value="ACCEPT FRIEND REQUEST" class="btn btn-success" />
                            </form>
                            <br>
                            <form action="/friend/declineFriendRequest" method="POST">
                                <input type="hidden" name="friendProfileId" value="<?php echo $profile->getId(); ?>" />
                                <input type="submit" name="declineFriendRequest" value="DECLINE FRIEND REQUEST" class="btn btn-danger" />
                            </form>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
    <div class="col-lg-6">
        <?php if (isset($params["error"])) :
            $error = $params['error'];
            if ($error !== null) :
                $errorMessages = array(
                    FriendshipError::Friends => "Invalid attempt already your friend!",
                    FriendshipError::NotFriends => "Invalid attempt not your friend!",
                    FriendshipError::SentFriendRequest => "Invalid attempt friend request sent!",
                    FriendshipError::HaveFriendRequest => "Invalid attempt you have friend request!",
                    FriendshipError::YourProfile => "Invalid attempt you can not add yourself as a friend ",
                    FriendshipError::ProfileDoesNotExist => "Profile you are trying to add does not exist!",
                );

                ?>
                <h4 class="alert alert-dismissible alert-danger">
                    <?php echo $errorMessages[$error] . "<br>"; ?>
                </h4>
            <?php endif; ?>
        <?php endif; ?>

        <?php if (isset($params["friendProfileError"])) :
            $friendProfileError = $params['friendProfileError'];
            if ($friendProfileError !== null) :
                $errorMessages = array(
                    FriendProfileError::FriendProfileDoesNotExist => "Profile does not exist!",
                );
                ?>
                <h4 class="alert alert-dismissible alert-danger">
                    <?php echo $errorMessages[$friendProfileError] . "<br>"; ?>
                </h4>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>