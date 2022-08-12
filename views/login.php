<?php
session_start();
require 'core/init.php';
if (isset($_COOKIE['user'])) {
    $cookie = $user->checkcookie($_COOKIE['user']);
    if ($cookie[0]) {
        $_SESSION['login'] = $cookie[1];
    }
}
if (isset($_POST['login'])) {
    if (isset($_POST['remember'])) {
        $_POST['remember'];
    } else {
        $_POST['remember'] = 0;
    }
    $login = $user->login($_POST['email'], $_POST['password'], $_POST['remember']);
    if ($login[0]) {
        $_SESSION['login'] = $login[2];
    } else {
        $status = $login;
    }
}
if (isset($_SESSION['login'])) {
    header('Location:' . BASEURL . 'vault');
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once 'component/head.php' ?>
    <title>Login</title>
</head>

<body>
    <!-- navbar -->
    <?php require_once 'component/navbar.php' ?>
    <!-- endnavbar -->
    <!-- register -->
    <div class="box">
        <img class="mb-3" src="<?= BASEURL ?>public/assets/logo.png" width="300px">
        <div style="width: 350px; margin: 10px;" class="container border rounded">
            <form action="" method="POST">
                <div class="register">
                    <h4 style="font-weight: bold;color:#039be5"><i style="font-size: 1.5rem;" class="bi bi-person-check-fill me-2"></i>Login</h4>
                    <hr>
                </div>
                <div class="form-floating mb-3">
                    <input type="email" name="email" class="form-control" id="floatingInput" placeholder="name@example.com" autocomplete="off" required>
                    <label for="floatingInput">Email address</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password" required>
                    <label for="floatingPassword">Password</label>
                </div>
                <div class="form-check mb-2">
                    <input class="form-check-input" name="remember" value=1 type="checkbox" value="" id="flexCheckDefault">
                    <label class="form-check-label" for="flexCheckDefault">
                        Remember Me
                    </label>
                </div>
                <?php if (isset($status)) : ?>
                    <?php if ($status[0]) : ?>
                        <div class="alert alert-success" role="alert">
                            <?= $status[1] ?>
                        </div>
                    <?php endif; ?>
                    <?php if (!$status[0]) : ?>
                        <div class="alert alert-danger" role="alert">
                            <?= $status[1] ?>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
                <button type="submit" name="login" style="background-color: #039be5; border: none;" class="btn btn-primary mb-3 ">Login</button>
                <p class='text-center'>Don't have an account? Click <a style="text-decoration: none;" href="register">here</a> to create an account</p>
            </form>
        </div>

    </div>


    <!-- endregister -->




    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-kjU+l4N0Yf4ZOJErLsIcvOU2qSb74wXpOhqTvwVx3OElZRweTnQ6d31fXEoRD1Jy" crossorigin="anonymous"></script>
</body>

</html>