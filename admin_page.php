<!DOCTYPE html>
<?php
require_once 'class/Objects.php';
require_once ('functions/system_function.php');
session_start();
if (checkLogined() == true && $_SESSION['object']->getUserLevel() == 3) {
    $object = $_SESSION['object'];
    ?>
    <html>
        <head>
            <meta charset="UTF-8">
            <title></title>
            <link rel="stylesheet" type="text/css" href="css/common_style.css"/>
        </head>
        <body>
            <header class="row">
                <h1 id="site_logo"><a href="">Laboratory asset tracking system</a></h1>
                <h2 id="page_name">Admin page</h2>
                <?php include dirname(__FILE__) . "/common_content/login_panel.php"; // div of login panel?>
            </header>
            <ul>
                <li><a href="edit_asset.php">Asset management</a></li>
                <li><a href="forms/experiment_reservation_form.php">Reserve an experiment</a></li>
            </ul>

        </body>
    </html>
    <?php
} else {
    echo "must login as admin";
    header('Refresh: 3;url=index.php');
}
?>