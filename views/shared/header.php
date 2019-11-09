<nav class="navbar navbar-expand-lg fixed-top navbar-light bg-light">
    <a class="navbar-brand title">CHATTY</a>
    <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarColor03"
            aria-controls="navbarColor03" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="navbar-collapse collapse" id="navbarColor03" style="">
        <ul class="navbar-nav mr-auto">
            <?php if ($this->context->isLoggedIn) : ?>
            <li class="nav-item active">
                <a class="nav-link" href="/">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="/timeline/view">Timeline <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="/friend/view">Friends <span class="sr-only">(current)</span></a>
            </li>
            <form action="/profile/search" method="POST" class="form-inline my-2 my-lg-0">
                <label for="">
                <input type="text" name="searchName" placeholder="Enter name to search for..."
                       class="form-control mr-sm-2"></label>
                <button type="submit" name="search" class="btn btn-secondary my-2 my-sm-0">Search</button>
            </form>
            <li class="nav-item active">
                <a class="nav-link" href="/profile/view">View Profile <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="/profile/edit">Edit Profile <span class="sr-only">(current)</span></a>
            </li>
            <?php endif; ?>
        </ul>

        <?php if ($this->context->isLoggedIn) : ?>
        <form action="/account/logOut" method="POST" class="form-inline my-2 my-lg-0">
            <button type="submit" name="logOut" class="btn btn-danger my-2 my-sm-0">Log out</button>
        </form>
        <?php else : ?>
        <div><a href="/account/create" class="mr-sm-2">Create Account</a></div>
        <div><a href="/account/logIn" class="mr-sm-2">Log in</a></div>
        <?php endif; ?>
    </div>

</nav>