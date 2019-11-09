<?php use SocialNetwork\Models\ProfileError; ?>
<?php
/**
 * @var array $params
 */
?>
<div class="row">
    <div class="col-lg-5">

        <div class="jumbotron text-center">
            <h3>PROFILE EDIT</h3>
            <form action="/profile/edit" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="firstName">
                    <input type="text" name="firstName" class="form-control" placeholder="First Name...">
                    </label>
                </div>
                <div class="form-group">
                    <label for="lastName">
                    <input type="text" name="lastName" class="form-control" placeholder="Last Name...">
                    </label>
                </div>
                <div class="form-group">
                    <label for="yearOfBirth">
                    <input type="number" name="yearOfBirth" class="form-control" placeholder="Year of Birth...">
                    </label>
                </div>
                <div class="form-group">
                    <label for="image">
                    <input type="file" name="image" class="form-control-file"
                           id="exampleInputFile" aria-describedby="fileHelp">
                    </label>
                    <small id="fileHelp" class="form-text text-muted">Chosen image name is displayed</small>
                </div>

                <div class="form-group">

                    <div>Select gender</div>
                    <div class="row center">

                        <div class="form-check col-lg-4">
                            <label for="gender">
                                <input type="radio" class="form-check-input " name="gender"
                                       id="optionsRadios1" value="M" checked>Male
                            </label>
                        </div>
                        <div class="form-check col-lg-4">
                            <label class="gender">
                                <input type="radio" class="form-check-input" name="gender"
                                       id="optionsRadios2" value="F">Female
                            </label>
                        </div>
                        <div class="form-check col-lg-4">
                            <label class="gender">
                                <input type="radio" class="form-check-input" name="gender"
                                       id="optionsRadios2" value="O">Other
                            </label>
                        </div>
                    </div>
                </div>
                <div class="center">
                    <button type="submit" name="edit" class="btn btn-secondary">Edit Profile</button>
                </div>
            </form>
        </div>
    </div>

    <div class="col-lg-7">
        <?php
        if ($params["status"] == "profile-edit-error") : ?>
            <?php $errors = $params["errors"];
                $errorMessages = array(
                    ProfileError::INVALID_FIRST_NAME => "First name can only have letters and from 2 to 32 characters.",
                    ProfileError::INVALID_LAST_NAME => "Last name can only have letters and from 1 to 64 characters.",
                    ProfileError::INVALID_YEAR_OF_BIRTH => "Birth year can be from 1900 until current year",
                    ProfileError::INVALID_EXTENSION => "Invalid extension! You can upload only jpeg,png and jpg",
                    ProfileError::ERROR_UPLOADING => "Error occurred while uploading image",
                    ProfileError::IMAGE_TOO_LARGE => "Chosen image is too large! Pick another smaller"
                ); ?>

            <?php foreach ($errors as $errorCode) : ?>
                <h4 class="alert alert-dismissible alert-danger">
                    <?php echo $errorMessages[$errorCode] . "<br>"; ?>
                </h4>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
