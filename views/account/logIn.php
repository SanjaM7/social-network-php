<?php use SocialNetwork\Models\AccountError; ?>
<?php
/**
 * @var array $params
 */
?>
<div class="row">
    <div class="col-lg-5">
        <div class="jumbotron text-center">
            <h3>LOG IN</h3>
            <p>Enter username and password.</p>
            <form action="/account/logIn" method="POST">
                <div class="form-group">
                    <label for="username">
                    <input type="text" name="username" class="form-control" placeholder="Username...">
                    </label>
                </div>
                <div class="form-group">
                    <label for="password">
                    <input type="password" name="password" class="form-control" placeholder="Password...">
                    </label>
                </div>
                <button type="submit" name="logIn" class="btn btn-primary">Log in</button><br>
            </form>
        </div>
    </div>

    <div class="col-lg-7">
        <?php if ($params["status"] == 'logIn-error') : ?>
            <?php $errors = $params["errors"];
                $errorMessages = array(
                    AccountError::ACCOUNT_DOES_NOT_EXISTS => "Account doesn't exist!",
                    AccountError::INVALID_PASSWORD => "Invalid password!",
                ); ?>

            <?php foreach ($errors as $errorCode) : ?>
                <h4 class="alert alert-dismissible alert-danger">
                    <?php echo $errorMessages[$errorCode] . "<br>"; ?>
                </h4>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

</div>
