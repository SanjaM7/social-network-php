<?php if ($params['status'] == "status-success") : ?>
    <h4 class="alert alert-dismissible alert-success">Status posted. </h4>
<?php endif; ?>
<?php if ($params['status'] == "reply-success") : ?>
    <h4 class="alert alert-dismissible alert-success">Comment posted. </h4>
<?php endif; ?>
<?php if ($params['status'] == "like-success") : ?>
    <h4 class="alert alert-dismissible alert-success">Post liked. </h4>
<?php endif; ?>
<?php if ($params['status'] == "unlike-success") : ?>
    <h4 class="alert alert-dismissible alert-danger">Post unliked. </h4>
<?php endif; ?>

<div class="row">
    <div class="col-lg-6 my-1">

        <form action="/timeline/postStatus" method="POST">
            <div class="form-group">
                <textarea name="text" class="form-control" placeholder="What's up?" rows="2"></textarea>
            </div>
            <button type="submit" name="postStatus" class="btn btn-primary">Post Status</button><br>
        </form>
        <br>

        <?php if ($params["status"] == 'status-error' || $params["status"] == 'reply-error') : ?>
            <?php $statusErrors = $params["statusErrors"];
                $errorMessages = array(
                    StatusError::RequiredText => "Field is required!",
                    StatusError::TextLimitExceed => "Limit is 140 chars!",
                    StatusError::StatusDoesNotExist => "You can't reply to post that does not exist!",
                    StatusError::CanNotReplyOnReply => "You can only reply to statuses",
                    StatusError::NotYourFriend => "You can only reply to your own or your friend's post!"
                );
                ?>
            <?php foreach ($statusErrors as $errorCode) : ?>
                <h4 class="alert alert-dismissible alert-danger">
                    <?php echo $errorMessages[$errorCode] . "<br>"; ?>
                </h4>
            <?php endforeach; ?>
        <?php endif; ?>

        <?php if ($params['status'] == 'like-error') : ?>
            <?php $likeErrors = $params["likeErrors"];
                $errorMessages = array(
                    LikeError::StatusDoesNotExist => "You can't like post that does not exist!",
                    LikeError::NotYourFriend => "You can only like your own or your friend's post",
                    LikeError::StatusAlreadyLiked => "You have already liked that post!",
                    LikeError::StatusIsNotLiked => "You haven't liked that post!"
                );
                ?>
            <?php foreach ($likeErrors as $errorCode) : ?>
                <h4 class="alert alert-dismissible alert-danger">
                    <?php echo $errorMessages[$errorCode] . "<br>"; ?>
                </h4>
            <?php endforeach; ?>
        <?php endif; ?>

    </div>

    <div class="col-lg-6 my-1">

        <h3>Statuses</h3>
        <hr class="my-4">

        <?php $statuses = $params['statuses']; ?>
        <?php if (empty($params["statuses"])) : ?>
            <p>There's nothing in your timeline, yet</p>
        <?php endif; ?>

        <?php foreach ($statuses as $status) : ?>
            <?php if ($status->parentId == NULL) : ?>
                <div>
                    <a href="/profile/view?profileId=<?php echo $status->profileId; ?>">
                        <?php echo $status->firstName; ?> <?php echo $status->lastName; ?>
                    </a>
                    <p><?php echo $status->text; ?></p>
                    <div class="row">
                        <div class="col-lg-6 my-1">
                            <small>Created on <?php echo $status->createdAt; ?></small>
                        </div>
                        <div class="col-lg-2 my-1">
                            <?php if ($status->hasMyLike == 0) : ?>
                                <form action="/timeline/like" method="POST">
                                    <div class="form-group">
                                        <input type="hidden" name="statusId" value="<?php echo $status->id; ?>" />
                                        <button type="submit" name="like" class="btn btn-link p-0">like</button>
                                    </div>
                                </form>
                            <?php elseif ($status->hasMyLike == 1) : ?>
                                <form action="/timeline/unlike" method="POST">
                                    <div class="form-group">
                                        <input type="hidden" name="statusId" value="<?php echo $status->id; ?>" />
                                        <button type="submit" name="like" class="btn btn-link p-0">unlike</button>
                                    </div>
                                </form>
                            <?php endif; ?>
                        </div>
                        <div class="col-lg-4 my-1">
                            <p><?php echo $status->countOfLikes; ?> like<?php echo $status->countOfLikes != 1 ? "s" : "" ?></p>
                        </div>
                    </div>

                    <?php $replies = $params['replies']; ?>
                    <?php $hasReplies = FALSE; ?>

                    <?php foreach ($replies as $reply) : ?>
                        <?php if ($reply->parentId == $status->id) : ?>
                            <?php $hasReplies = TRUE; ?>
                            <div class="offset-1">
                                <a href="/profile/view?profileId=<?php echo $reply->profileId; ?>">
                                    <?php echo $reply->firstName; ?> <?php echo $reply->lastName; ?>
                                </a>
                                <p><?php echo $reply->text; ?></p>
                                <div class="row">
                                    <div class="col-lg-6 my-1">
                                        <small>Created on <?php echo $reply->createdAt; ?></small>
                                    </div>
                                    <div class="col-lg-2 my-1">
                                        <?php if ($reply->hasMyLike == 0) : ?>
                                            <form action="/timeline/like" method="POST">
                                                <div class="form-group">
                                                    <input type="hidden" name="statusId" value="<?php echo $reply->id; ?>" />
                                                    <button type="submit" name="like" class="btn btn-link p-0">like</button>
                                                </div>
                                            </form>
                                        <?php elseif ($reply->hasMyLike == 1) : ?>
                                            <form action="/timeline/unlike" method="POST">
                                                <div class="form-group">
                                                    <input type="hidden" name="statusId" value="<?php echo $reply->id; ?>" />
                                                    <button type="submit" name="like" class="btn btn-link p-0">unlike</button>
                                                </div>
                                            </form>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-lg-4 my-1">
                                        <p><?php echo $reply->countOfLikes; ?> like<?php echo $reply->countOfLikes != 1 ? "s" : "" ?></p>
                                    </div>
                                </div>
                            </div>

                        <?php endif; ?>
                    <?php endforeach; ?>

                    <form action="/timeline/reply" method="POST">
                        <div class="form-group <?php echo $hasReplies ? 'offset-1' : '' ?>">
                            <input type="hidden" name="parentId" value="<?php echo $status->id; ?>" />
                            <textarea name="text" class="form-control" placeholder="Reply to this status" rows="2"></textarea>
                            <div class="pt-2">
                                <button type="submit" name="postReply" class="btn btn-secondary">Reply</button>
                            </div>
                        </div>
                    </form>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>

    </div>
</div>