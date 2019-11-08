<?php if ($params['status'] == "createAccount-success") : ?>
    <h4 class="alert alert-dismissible alert-success">Your account has been created and you can now log in.</h4>
<?php endif; ?>
<?php if ($params['status'] == "logIn-success") : ?>
    <h4 class="alert alert-dismissible alert-success">You are now signed in.</h4>
<?php endif; ?>
<?php if ($params['status'] == "logOut-success") : ?>
    <h4 class="alert alert-dismissible alert-success">You successfully logged out.</h4>
<?php endif; ?>

<h3>Welcome to Chatty</h3>
<h4>The best social network, like... ever!</h4>

<?php if ($params["status"] == "index-success") : ?>
    <?php $profile = $params['profile']; ?>
    <h3> Hello <?php echo $profile->getFirstName(); ?></h3>
<?php endif; ?>

<?php
