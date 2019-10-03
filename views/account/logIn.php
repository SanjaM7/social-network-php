<div class="row">

    <div class="col-lg-5">
        <div class="jumbotron text-center">
            <h3>LOG IN</h3>
            <p>Enter username and password.</p>
            <form action="/account/logIn" method="POST">
                <div class="form-group">
                    <input type="text" name="username" class="form-control" placeholder="Username...">
                </div>
                <div class="form-group">
                    <input type="password" name="password" class="form-control" placeholder="Password...">
                </div>
                <button type="submit" name="logIn" class="btn btn-primary">Log in</button><br>
            </form>
        </div>
    </div>

    <div class="col-lg-7">
        <?php if ($params["status"] == 'logIn-error') : ?>
            <?php $errors = $params["errors"];
                $errorMessages = array(
                    AccountError::AccountDoesNotExists => "Account doesn't exist!",
                    AccountError::InvalidPassword => "Invalid password!",
                ); ?>

            <?php foreach ($errors as $errorCode) : ?>
                <h4 class="alert alert-dismissible alert-danger">
                    <?php echo $errorMessages[$errorCode] . "<br>"; ?>
                </h4>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

</div>