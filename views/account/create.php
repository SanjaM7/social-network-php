<?php use SocialNetwork\Models\AccountError; ?>
<?php
/**
 * @var array $params
 */
?>
<div class="row">

    <div class="col-lg-5">
        <div class="jumbotron text-center">
            <h3>CREATE ACCOUNT</h3>
            <p>It’s quick and easy.</p>
            <form action="/account/create" method="POST">
                <div class="form-group">
                    <label for="username">
                    <input type="text" name="username" class="form-control" placeholder="Username..." >
                    </label>
                </div>
                <div class="form-group">
                    <label for="email">
                    <input type="text" name="email" class="form-control" placeholder="Email...">
                    </label>
                </div>
                <div class="form-group">
                    <label for="password">
                    <input type="password" name="password" class="form-control" placeholder="Password...">
                    </label>
                </div>
                <div class="form-group">
                    <label for="passwordRepeat">
                    <input type="password" name="passwordRepeat" class="form-control" placeholder="Repeat password...">
                    </label>
                </div>
                <button type="submit" name="createAccount" class="btn btn-primary">Create account</button><br>
            </form>
        </div>
    </div>

    <div class="col-lg-7">
        <?php if ($params["status"] == 'createAccount-error') : ?>
            <?php $errors = $params["errors"];
                $errorMessages = array(
                    AccountError::INVALID_USERNAME => "Username can only have letters, numbs, length 3-32!",
                    AccountError::INVALID_EMAIL=> "Invalid e-mail!",
                    AccountError::INVALID_PASSWORD => "Password length must be 6-60!",
                    AccountError::INVALID_PASSWORD_REPEAT => "Your passwords do not match!",
                    AccountError::USERNAME_TAKEN => "Username is already taken!",
                    AccountError::EMAIL_TAKEN => "You already have account, log in",
                ); ?>

            <?php foreach ($errors as $errorCode) : ?>
                <h4 class="alert alert-dismissible alert-danger">
                    <?php echo $errorMessages[$errorCode]; ?>
                </h4>
            <?php endforeach; ?>

        <?php endif; ?>
    </div>

</div>
