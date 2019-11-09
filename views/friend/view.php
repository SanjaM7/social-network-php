<?php
/**
 * @var array $params
 * @var object $friend
 * @var object $friendRequest
 */
?>
<div class="row">
    <div class="col-lg-6 my-1">
        <h3>Friends</h3>
        <hr class="my-4">
        <?php $friends = $params['friends']; ?>

        <?php if (empty($params["friends"])) : ?>
            <P>You have no friends</p>
        <?php else : ?>
            <?php foreach ($friends as $friend) : ?>
                <a href="/profile/view?profileId=<?php echo $friend->getId(); ?>">
                    <?php echo $friend->getFirstName() . " " .  $friend->getLastName() . "<br>"; ?></a>
            <?php endforeach; ?>
        <?php endif; ?>

    </div>

    <div class="col-lg-6 my-1">
        <h3>Friend Requests</h3>
        <hr class="my-4">
        <?php $friendRequests = $params['friendRequests']; ?>

        <?php if (empty($params["friendRequests"])) : ?>
            <p>You have no friends requests</p>
        <?php else : ?>
            <?php foreach ($friendRequests as $friendRequest) : ?>
                <a href="/profile/view?profileId=<?php echo $friendRequest->getId(); ?>">
                    <?php echo $friendRequest->getFirstName() . " " .  $friendRequest->getLastName() . "<br>"; ?></a>
            <?php endforeach; ?>
        <?php endif; ?>

    </div>
</div>
