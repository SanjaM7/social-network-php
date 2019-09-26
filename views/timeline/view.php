<?php if (isset($_GET['postStatus'])) :
    if ($_GET['postStatus'] == "success") : ?>
        <h4 class="alert alert-dismissible alert-success">Status posted. </h4>
<?php endif;
endif; ?>
<?php if (isset($_GET['reply'])) :
    if ($_GET['reply'] == "success") : ?>
        <h4 class="alert alert-dismissible alert-success">Comment posted. </h4>
<?php endif;
endif; ?>

<div class="row">
    <div class="col-lg-6 my-1">
        <form action="/timeline/postStatus" method="POST">
            <div class="form-group">
                <textarea name="text" class="form-control" placeholder="What's up?" rows="2"></textarea>
            </div>
            <button type="submit" name="postStatus" class="btn btn-primary">Post Status</button><br>
        </form>
        <?php
        if (isset($params["errors"])) :
            $errors = $params["errors"];
            $errorMessages = array(
                StatusError::RequiredText => "Field is required!",
                StatusError::TextLimitExceed => "Limit is 140 chars!",
                StatusError::CanNotReply => "You can only reply to your friends!"
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
    <div class="col-lg-6 my-1">
        <!-- Timeline statuses and replies-->
        <h3>Statuses</h3>
        <hr class="my-4">
        <?php

        if (isset($params["statuses"])) :
            $statuses = $params['statuses'];

            if (empty($params["statuses"])) {
                echo "There's nothing in your timeline, yet";
            }
            ?>

            <?php foreach ($statuses as $status) : ?>

                <?php if ($status->parentId == NULL) : ?>
                    <div>
                        <div class="row">
                            <div class="col-lg-6 my-1">
                                <a href="/profile/view?profileId=<?php echo $status->profileId; ?>"><?php echo $status->firstName; ?> <?php echo $status->lastName; ?></a>
                            </div>
                            <div class="col-lg-6 my-1">
                                <small>Created on <?php echo $status->createdAt; ?></small>
                            </div>
                        </div>
                        <p><?php echo $status->text; ?></p>
                    </div>
                    <?php
                                if (isset($params["replies"])) :
                                    $replies = $params['replies'];
                                    $hasReplies = false;
                                    ?>

                        <?php foreach ($replies as $reply) : ?>
                            <?php if ($reply->parentId == $status->id) : ?>
                                <?php $hasReplies = true; ?>
                                <div class="offset-1">
                                    <div class="row">
                                        <div class="col-lg-6 my-1">
                                            <a href="/profile/view?profileId=<?php echo $reply->profileId; ?>"><?php echo $reply->firstName; ?> <?php echo $reply->lastName; ?></a>
                                        </div>
                                        <div class="col-lg-6 my-1">
                                            <small>Created on <?php echo $reply->createdAt; ?></small>
                                        </div>
                                    </div>
                                    <p><?php echo $reply->text; ?></p>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>

                    <form action="/timeline/reply" method="POST">
                        <div class="form-group <?php echo $hasReplies ? 'offset-1' : '' ?>">
                            <input type="hidden" name="parentId" value="<?php echo $status->id; ?>" />
                            <textarea name="text" class="form-control" placeholder="Reply to this status" rows="2"></textarea>
                            <div class="pt-2">
                                <button type="submit" name="postReply" class="btn btn-secondary">Reply</button>
                            </div>
                        </div>   
                    </form>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>