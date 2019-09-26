<?php
if (isset($_GET['createAccount'])) :
    if ($_GET['createAccount'] == "success") : ?>
        <h4 class="alert alert-dismissible alert-success">Your account has been created and you can now log in.</h4>
    <?php
    endif;
endif;
if (isset($_GET['logIn'])) :
    if ($_GET['logIn'] == "success") : ?>
        <h4 class="alert alert-dismissible alert-success">You are now signed in.</h4>
    <?php
    endif;
endif;
if (isset($_GET['logOut'])) :
    if ($_GET['logOut'] == "success") : ?>
        <h4 class="alert alert-dismissible alert-success">You successfully logged out.</h4>
    <?php
    endif;
endif;
?>

<h3>Welcome to Chatty</h3>
<h4>The best social network, like... ever!</h4>

<?php
if(isset($params["profile"])) :
    $profile = $params['profile'];
    ?>
<h3> Hello <?php echo $profile->getFirstName(); ?></h3>
<?php endif; ?>