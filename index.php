<?php
require_once ('functions/system_function.php');
require_once (rootPath().'class/Objects.php');
session_start();
?>
<!doctype html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link rel="stylesheet" type="text/css" href="css/common_style.css"/>
        <style  type="text/css">
            #loginOut{
                float:right;
            }
        </style>
    </head>
    <body>
        <header class="row">
            <h1 id="site_logo">Laboratory asset tracking system</h1>
            <?php include dirname(__FILE__) . "/common_content/login_panel.php"; // div of login panel?>
        </header>

        <ul>
            <li><a href="forms/experiment_reservation_form.php">Reserve an experiment</a></li>
        </ul>

    </body>
</html>