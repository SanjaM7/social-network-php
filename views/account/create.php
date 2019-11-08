<div class="row">

    <div class="col-lg-5">
        <div class="jumbotron text-center">
            <h3>CREATE ACCOUNT</h3>
            <p>It’s quick and easy.</p>
            <form action="/account/create" method="POST">
                <div class="form-group">
                    <input type="text" name="username" class="form-control" placeholder="Username...">
                </div>
                <div class="form-group">
                    <input type="text" name="email" class="form-control" placeholder="Email...">
                </div>
                <div class="form-group">
                    <input type="password" name="password" class="form-control" placeholder="Password...">
                </div>
                <div class="form-group">
                    <input type="password" name="passwordRepeat" class="form-control" placeholder="Repeat password...">
                </div>
                <button type="submit" name="createAccount" class="btn btn-primary">Create account</button><br>
            </form>
        </div>
    </div>

    <div class="col-lg-7">
        <?php if ($params["status"] == 'createAccount-error') : ?>

            <?php $errors = $params["errors"];
                $errorMessages = array(
                    AccountError::InvalidUsername => "Username can only have letters, numbs, length 3-32!",
                    AccountError::InvalidEmail => "Invalid e-mail!",
                    AccountError::InvalidPassword => "Password length must be 6-60!",
                    AccountError::InvalidPasswordRepeat => "Your passwords do not match!",
                    AccountError::UsernameTaken => "Username is already taken!",
                    AccountError::EmailTaken => "You already have account, log in",
                ); ?>

            <?php foreach ($errors as $errorCode) : ?>
                <h4 class="alert alert-dismissible alert-danger">
                    <?php echo $errorMessages[$errorCode]; ?>
                </h4>
            <?php endforeach; ?>

        <?php endif; ?>
    </div>

</div>