<?php
session_start();
require 'core/init.php';
if (isset($_SESSION['login'])) {
    $id = (int)$_SESSION['login'];
    $data = $db->query("SELECT * FROM users WHERE id = $id");
    $data = mysqli_fetch_assoc($data);
    $username = $data['username'];
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once 'component/head.php' ?>
    <title>Get to know | Vaultbox</title>
</head>

<body>
    <!-- navbar -->
    <?php require_once 'component/navbar.php' ?>
    <!-- endnavbar -->
    <div class="container" style="margin-top: 70px;">
        <div class="row">
            <div class="col-lg">
                <span class="badge rounded-pill ms-4 mb-2" style="font-size: 15px; background-color: #039be5;">
                    Get to know!
                </span>
                <br>
                <img src="<?= BASEURL ?>public/assets/logo.png" width="350px">
                <p class="mb-4 ms-4" style="font-size: 20px;">
                    Secure your file on Vaultbox, copy link, and share it to anyone who knows the keyword!. Vaultbox can provide encrypted and secure access to your files.
                </p>
                <div class="ms-4 mb-4">
                    <a href="<?= BASEURL ?>register" type="button" style="background-color: #039be5; border: #039be5;" class="btn btn-primary btn-lg m-2">Get Started!</a>
                    <a href="<?= BASEURL ?>login" type="button" class="btn btn-outline-secondary btn-lg">Login</a>
                </div>
                <hr width="30%" class="ms-4  mb-5">
                <span class="badge rounded-pill ms-4" style="font-size: 20px; background-color: #039be5;">
                    Powered By :
                </span>

                <img src="<?= BASEURL ?>public/assets/Firebase_Logo.png" width="350px">
            </div>
            <div class="col-lg">

                <img width="500px" class="img-fluid" src="<?= BASEURL ?>public/assets/Vault-rafiki.svg">
            </div>

        </div>
    </div>



















    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-kjU+l4N0Yf4ZOJErLsIcvOU2qSb74wXpOhqTvwVx3OElZRweTnQ6d31fXEoRD1Jy" crossorigin="anonymous"></script>
</body>

</html>