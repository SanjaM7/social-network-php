<?php
use SocialNetwork\Models\ProfileError;
use SocialNetwork\Models\FriendshipState;
use SocialNetwork\Models\FriendshipError;
?>
<?php
/**
 * @var array $params
 */
?>
<?php if ($params['status'] == "addFriend-success") : ?>
    <h4 class="alert alert-dismissible alert-success">Friend request sent. </h4>
<?php endif; ?>
<?php if ($params['status'] == "removeFriend-success") : ?>
    <h4 class="alert alert-dismissible alert-success">Removed from friends. </h4>
<?php endif; ?>
<?php if ($params['status'] == "withdrawFriendRequest-success") : ?>
    <h4 class="alert alert-dismissible alert-success">Friend request withdrew. </h4>
<?php endif; ?>
<?php if ($params['status'] == "acceptFriendRequest-success") : ?>
    <h4 class="alert alert-dismissible alert-success">Friend accepted. </h4>
<?php endif; ?>
<?php if ($params['status'] == "declineFriendRequest-success") : ?>
    <h4 class="alert alert-dismissible alert-success">Friend request declined. </h4>
<?php endif; ?>

<div class="row">
    <div class="col-lg-6">
        <h3>Profile Info</h3>
        <hr class="my-4">
        <?php if (isset($params["profileError"]) && $params['profileError'] !== null) :
            $profileError = $params['profileError'];
            if ($profileError !== null) :
                $errorMessages = array(
                    ProfileError::PROFILE_DOES_NOT_EXIST => "Profile does not exist!",
                );
                ?>
                <h4 class="alert alert-dismissible alert-danger">
                    <?php echo $errorMessages[$profileError] . "<br>"; ?>
                </h4>
            <?php endif; ?>
        <?php else : ?>
            <?php $profile = $params['profile']; ?>
            <div class="row">
                <div class="col-lg-6">
                    <img alt="profileImage" src="/uploads/<?php echo $profile->getImage(); ?>" style='width:200px;'><br>
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

                    <?php $myProfileId = $params['myProfileId']; ?>
                    <?php if ($profile->getId() == $myProfileId) : ?>
                        <a href="/profile/edit" class="btn btn-secondary">Edit Profile</a>
                    <?php else : ?>
                        <?php $state = $params['state'] ?>
                        <?php if ($state == FriendshipState::NOT_FRIENDS) : ?>
                            <form action="/friend/addFriend" method="POST">
                                <input type="hidden" name="friendProfileId" value="<?php echo $profile->getId(); ?>" />
                                <button type="submit" name="addFriend" class="btn btn-success">ADD AS FRIEND</button>
                            </form>
                        <?php endif; ?>
                        <?php if ($state  == FriendshipState::FRIENDS) : ?>
                            <p>You and <?php echo $profile->getFirstName(); ?> are friends</p>
                            <form action="/friend/removeFriend" method="POST">
                                <input type="hidden" name="friendProfileId" value="<?php echo $profile->getId(); ?>" />
                                <button type="submit" name="removeFriend"
                                        class="btn btn-danger">REMOVE FROM FRIENDS</button>
                            </form>
                        <?php endif; ?>

                        <?php if ($state == FriendshipState::SENT_FRIEND_REQUEST) : ?>
                            <p>Friend request sent</p>
                            <form action="/friend/withdrawFriendRequest" method="POST">
                                <input type="hidden" name="friendProfileId" value="<?php echo $profile->getId(); ?>" />
                                <button type="submit" name="withdrawFriendRequest"
                                        class="btn btn-secondary">WITHRAW FRIEND REQUEST</button>
                            </form>
                        <?php endif; ?>

                        <?php if ($state  == FriendshipState::HAVE_FRIEND_REQUEST) : ?>
                            <form action="/friend/acceptFriendRequest" method="POST">
                                <input type="hidden" name="friendProfileId" value="<?php echo $profile->getId(); ?>" />
                                <button type="submit" name="acceptFriendRequest"
                                        class="btn btn-success">ACCEPT FRIEND REQUEST</button>
                            </form>
                            <br>
                            <form action="/friend/declineFriendRequest" method="POST">
                                <input type="hidden" name="friendProfileId" value="<?php echo $profile->getId(); ?>" />
                                <button type="submit" name="declineFriendRequest"
                                        class="btn btn-danger">DECLINE FRIEND REQUEST</button>
                            </form>
                        <?php endif; ?>
                    <?php endif; ?>

                </div>
            </div>
        <?php endif; ?>
    </div>
    <div class="col-lg-6">
        <?php if ($params["status"] == 'addFriend-error' ||
            $params["status"] == 'removeFriend-error' ||
            $params["status"] == 'withdrawFriendRequest-error' ||
            $params["status"] == 'acceptFriendRequest-error' ||
            $params["status"] == 'declineFriendRequest-error') : ?>
            <?php $friendshipErrors = $params['friendshipErrors'];
                $errorMessages = array(
                    FriendshipError::FRIENDS=> "Invalid attempt already your friend!",
                    FriendshipError::NOT_FRIENDS => "Invalid attempt not your friend!",
                    FriendshipError::SENT_FRIEND_REQUEST => "Invalid attempt friend request sent!",
                    FriendshipError::HAVE_FRIEND_REQUEST => "Invalid attempt you have friend request!",
                    FriendshipError::YOUR_PROFILE=> "Invalid attempt you can not add yourself as a friend ",
                );

                ?>
            <?php foreach ($friendshipErrors as $errorCode) : ?>
                <h4 class="alert alert-dismissible alert-danger">
                    <?php echo $errorMessages[$errorCode]; ?>
                </h4>
            <?php endforeach; ?>

        <?php endif; ?>
    </div>
</div>
