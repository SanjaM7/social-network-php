<div class="row">

    <div class="col-lg-5">

        <div class="jumbotron">
            <h3 class="center">PROFILE EDIT</h3>
            <form action="/profile/edit" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <input type="text" name="firstName" class="form-control" placeholder="First Name...">
                </div>
                <div class="form-group">
                    <input type="text" name="lastName" class="form-control" placeholder="Last Name...">
                </div>
                <div class="form-group">
                    <input type="number" name="yearOfBirth" class="form-control" placeholder="Year of Birth...">
                </div>
                <div class="form-group">
                    <input type="file" name="image" class="form-control-file" id="exampleInputFile" aria-describedby="fileHelp">
                    <small id="fileHelp" class="form-text text-muted">Chosen image name is displayed</small>
                </div>

                <div class="form-group">
                    
                <div>Select gender</div>
                    <div class="row center">
 
                        <div class="form-check col-lg-4">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input " name="gender" id="optionsRadios1" value="M" checked>Male
                            </label>
                        </div>
                        <div class="form-check col-lg-4">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="gender" id="optionsRadios2" value="F">Female
                            </label>
                        </div>
                        <div class="form-check col-lg-4">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="gender" id="optionsRadios2" value="O">Other
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
        if (isset($params["errors"])) :
            $errors = $params["errors"];
            $errorMessages = array(
                ProfileError::InvalidFirstName => "First name can only have letters and from 2 to 32 characters.",
                ProfileError::InvalidLastName => "Last name can only have letters and from 1 to 64 characters.",
                ProfileError::InvalidYearOfBirth => "Birth year can be from 1900 until current year",
                ProfileError::InvalidExtention => "Invalid extention! You can upload only jpeg,png and jpg",
                ProfileError::ErrorUploading => "Error occurred while uploading image",
                ProfileError::ImageTooLarge => "Choosen image is too large! Pick another smaller"
            );

            foreach ($errors as $errorCode) : ?>
        <h4 class="alert alert-dismissible alert-danger">
            <?php echo $errorMessages[$errorCode] . "<br>"; ?>
        </h4>
        <?php
            endforeach;
        endif;
        ?>
    </div>
</div>