<?php

use Core\Session;

?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" type="text/css" href="<?= STATIC_FILES; ?>css/custom.css">
    <link rel="stylesheet" type="text/css" href="<?= STATIC_FILES; ?>css/bootstrap.min.css">

    <title>Students Club App</title>
  </head>
  <body>

    <?php include 'main_menu.php'; ?>
    <div class="container mt-5">
       <?= Session::displayMessage();  ?>
       <?= $this->content("body") ?>
    </div>
    <script type="text/javascript" src="<?= STATIC_FILES; ?>js/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" src="<?= STATIC_FILES; ?>js/popper.min.js"></script>
    <script type="text/javascript" src="<?= STATIC_FILES; ?>js/bootstrap.min.js"></script>
  </body>
</html>
