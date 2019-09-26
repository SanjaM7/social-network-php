<div class="row">
    <div class="col-lg-6 my-1">

        <h3>Friends</h3>
        <hr class="my-4">
        <?php

        if (isset($params["friends"])) :
            $friends = $params['friends'];

            if(empty($params["friends"])){
                echo "You have no friends";
            }
            ?>

            <?php foreach ($friends as $friend) : ?>

                <a href="/profile/view?profileId=<?php echo $friend->getId(); ?>">
                    <?php echo $friend->getFirstName() . " " .  $friend->getLastName() . "<br>"; ?></a>

            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <div class="col-lg-6 my-1">

        <h3>Friend Requests</h3>
        <hr class="my-4">
        <?php

        if (isset($params["friendRequests"])) :
            $friendRequests = $params['friendRequests'];

            if(empty($params["friendRequests"])){
                echo "You have no friends requests";
            }
            ?>
            <?php foreach ($friendRequests as $friendRequest) : ?>

                <a href="/profile/view?profileId=<?php echo $friendRequest->getId(); ?>">
                    <?php echo $friendRequest->getFirstName() . " " .  $friendRequest->getLastName() . "<br>"; ?></a>

            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>