<?php
session_start();
require 'core/init.php';
if (isset($_SESSION['login'])) {
    $id = (int)$_SESSION['login'];
    $data = $db->query("SELECT * FROM users WHERE id = $id");
    $data = mysqli_fetch_assoc($data);
    $username = $data['username'];
} else {
    header("Location:" . BASEURL . "login");
    die;
}

if (isset($_POST['save'])) {
    $status = $user->accountsetting($id, $_POST['username'], $_POST['oldpassword'], $_POST['newpassword']);
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once 'component/head.php' ?>
    <title>Account Setting</title>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                    <h4 style="font-weight: bold;color:#7634fa"><i style="font-size: 1.2rem;" class="bi bi-gear me-2"></i>Account Setting</h4>
                    <hr>
                </div>
                <div class="form-floating mb-3">
                    <input type="email" class="form-control" value="<?= $data['email'] ?>" id="floatingInput" placeholder="name@example.com" disabled>
                    <label for="floatingInput">Email address</label>
                    <div id="emailHelp" class="form-text">You can't change your email</div>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" name="username" value="<?= $data['username'] ?>" class="form-control" id="username" placeholder="name@example.com" autocomplete="nope">
                    <label for="username">Username</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="password" name="oldpassword" class="form-control" id="oldpassword" placeholder="Old Password" required>
                    <label for="oldpassword">Old Password</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="password" name="newpassword" class="form-control" id="newpassword" placeholder="New Password" required>
                    <label for="newpassword">New Password</label>
                </div>
                <?php if (isset($status)) : ?>
                    <?php if ($status[0]) : ?>
                        <script>
                            Swal.fire(
                                'Updated!',
                                '<?= $status[1] ?>',
                                'success'
                            ).then(result => {
                                if (result.isConfirmed) {
                                    window.location.href = window.location.href;
                                }

                            })
                        </script>
                    <?php endif; ?>
                    <?php if (!$status[0]) : ?>
                        <script>
                            Swal.fire(
                                'Failed!',
                                '<?= $status[1] ?>',
                                'error'
                            ).then(result => {
                                if (result.isConfirmed) {
                                    window.location.href = window.location.href;
                                }

                            })
                        </script>
                    <?php endif; ?>
                <?php endif; ?>
                <button type="submit" name="save" style="background-color: #7634fa; border: none;" class="btn btn-primary mb-3 ">Save Changes</button>
            </form>
        </div>

    </div>


    <!-- endregister -->




    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-kjU+l4N0Yf4ZOJErLsIcvOU2qSb74wXpOhqTvwVx3OElZRweTnQ6d31fXEoRD1Jy" crossorigin="anonymous"></script>
</body>

</html>