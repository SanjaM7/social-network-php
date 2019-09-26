<?php
if (!isset($params["profiles"])) :
    header("Location: /../index");
endif;
?>

<h3>SEARCH</h3>

<hr class="my-4">

<?php
if (isset($params['query'])) : ?>
    <div><b> You have searched for: </b> <?php echo $params['query'] ?> </div>
<?php endif; ?>

<?php $profiles = $params['profiles']; ?>

<?php foreach ($profiles as $profile) : ?>
<?php $myProfileId = $params['myProfileId']; ?>
    <?php if ($profile->getId() != $myProfileId) : ?><a href="/profile/view?profileId=<?php echo $profile->getId(); ?>">
            <?php echo $profile->getFirstName() . " " .  $profile->getLastName() . "<br>"; ?></a>
    <?php else : ?>
    <a href="/profile/view">
            <?php echo $profile->getFirstName() . " " .  $profile->getLastName() . "<br>"; ?></a>
    <?php endif; ?>

<?php endforeach;
