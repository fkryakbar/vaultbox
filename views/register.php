<?php
require 'core/init.php';
$db->query('SELECT * FROM users');
if (isset($_POST['submit'])) {
    $register = $user->register($_POST['email'], $_POST['username'], $_POST['password'], $_POST['conpassword']);
}

?>
<!doctype html>
<html lang="en">

<head>
    <?php require_once 'component/head.php' ?>
    <title>Create Account</title>
</head>

<body>
    <!-- navbar -->
    <?php require_once 'component/navbar.php' ?>
    <!-- end navbar -->
    <!-- register -->
    <div class="box">
        <img class="mb-3" src="<?= BASEURL ?>public/assets/logo.png" width="300px">
        <div style="width: 350px; margin: 10px;" class="container border rounded">
            <form action="" method="POST">
                <div class="register">
                    <h4 style="font-weight: bold;color:#039be5"><i style="font-size: 1.5rem;" class="bi bi-person-plus-fill me-2"></i>Register</h4>
                    <hr>
                </div>
                <div class="form-floating mb-3">
                    <input type="email" name="email" class="form-control" id="floatingInput" placeholder="name@example.com" autocomplete="off" required>
                    <label for="floatingInput">Email address</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="username" name="username" class="form-control" id="floatingInput" placeholder="name@example.com" autocomplete="off" required>
                    <label for="floatingInput">Username</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password" required>
                    <label for="floatingPassword">Password</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="password" name="conpassword" class="form-control" id="floatingPassword" placeholder="Password Confirmation" required>
                    <label for="floatingPassword">Password Confirmation</label>
                </div>
                <?php if (isset($register)) : ?>
                    <?php if ($register[0]) : ?>
                        <div class="alert alert-success" role="alert">
                            <?= $register[1] ?>
                        </div>
                    <?php endif; ?>
                    <?php if (!$register[0]) : ?>
                        <div class="alert alert-danger" role="alert">
                            <?= $register[1] ?>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
                <button type="submit" name="submit" style="background-color: #039be5; border: none;" class="btn btn-primary mb-3 ">Create Account!</button>

                <p class='text-center'>Already have an account? Click <a style="text-decoration: none;" href="login">here</a> to Login</p>
            </form>
        </div>

    </div>


    <!-- endregister -->









    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-kjU+l4N0Yf4ZOJErLsIcvOU2qSb74wXpOhqTvwVx3OElZRweTnQ6d31fXEoRD1Jy" crossorigin="anonymous"></script>
</body>

</html>