<?php
/**
 * @var string $viewName
 */
?>
<!DOCTYPE html>

<head>
    <meta charset="unf-8">
    <title>Social Network</title>
    <link rel="stylesheet" type="text/css"
          href="https://stackpath.bootstrapcdn.com/bootswatch/4.3.1/flatly/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/css/layout.css">
</head>

<body>
    <header>
        <?php require_once "header.php"; ?>
    </header>

    <main>
        <div class="container">
            <?php require_once $viewName; ?>
        </div>
    </main>

    <footer>
        <?php require_once "footer.html"; ?>
    </footer>
</body>
