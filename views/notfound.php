<?php
require 'core/init.php';


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once 'component/head.php' ?>
    <title>Page not Found</title>
</head>

<body style="height: 100vh;">
    <!-- navbar -->
    <?php require_once 'component/navbar.php' ?>
    <!-- endnavbar -->
    <div class="thisflex" style="flex-direction: column; height: 70%;">
        <img class="text-center" src="<?= BASEURL ?>public/assets/404.svg" width="400px">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a style="text-decoration: none; color: #039be5;" href="<?= BASEURL ?>home">Back to Home</a></li>
        </ol>

    </div>
</body>

</html>