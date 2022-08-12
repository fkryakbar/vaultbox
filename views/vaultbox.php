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
if (isset($_POST['create'])) {
    if (!isset($_POST['keyword'])) {
        $_POST['keyword'] = "";
    }
    $create = $app->create($_POST['vaultname'], $id, $_POST['withkeyword'], $_POST['keyword'], $_POST['access']);
}

if (isset($_POST['save'])) {
    if (!isset($_POST['keyword'])) {
        $_POST['keyword'] = "";
    }
    $create = $app->update($_POST['vaultname'], $_POST['withkeyword'], $_POST['keyword'], $_POST['uid'], $_POST['oldname'], $id, $_POST['access']);
}


$data = $app->getvault($id);


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once 'component/head.php' ?>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>My Vault | Vaultbox</title>
</head>

<body>
    <!-- navbar -->
    <?php require_once 'component/navbar.php' ?>
    <!-- endnavbar -->
    <div class="thisflex" style="margin-top: 50px;">
        <div class="container thisflex">
            <div style="width: 100%; max-width: 1000px; margin-bottom: 0px;" class="border rounded">
                <div style="display: flex;justify-content: center;">
                    <img class="text-center" src="<?= BASEURL ?>public/assets/logo.png" width="200px">
                </div>
                <p><i style="font-size: 1.3rem;" class="bi bi-safe me-2"></i> Total Vault(s) : <?= mysqli_num_rows($data) ?></p>
                <button data-bs-toggle="modal" data-bs-target="#create" type="button" style="background-color: #039be5; border: #039be5;" class="btn btn-primary"><i class="bi bi-plus me-2"></i>Create</button>
            </div>
            <div style="width: 100%; max-width: 1000px; padding: 5px;" class="border rounded">
                <?php if (mysqli_num_rows($data) > 0) : ?>
                    <div class="list-group" style="position: relative;">
                        <ul class="list-group list-group-flush">
                            <?php while ($dt = mysqli_fetch_assoc($data)) : ?>
                                <li class="list-group-item">
                                    <a style="text-decoration: none;color: black;" href="<?= BASEURL ?>open/<?= $dt['uid'] ?>"><?= $dt['name'] ?></a>
                                    <button data-bs-toggle="modal" data-bs-target="#option" onclick="clickoption('<?= $dt['uid'] ?>')" style="border: none; background-color: white;" class="float-end more"><i class="bi bi-three-dots-vertical"></i></button>
                                </li>
                            <?php endwhile; ?>

                        </ul>
                    </div>
                <?php endif; ?>
                <?php if (mysqli_num_rows($data) == 0) : ?>
                    <div style="display: flex; align-items: center; justify-content: center;flex-direction: column;">
                        <img width="300px" src="<?= BASEURL ?>public/assets/Empty-amico.svg">
                        <h6 class="text-center" style="color: #039be5;">You don't have any vaults, maybe create a new one?</h6>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <!-- Modal create -->
    <div class="modal fade" id="create" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><i style="font-size: 1.3rem;" class="bi bi-safe me-2"></i> Create Vault</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST">
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Vault Name</label>
                            <input type="vault" name="vaultname" class="form-control" id="exampleInputEmail1" autocomplete="nope" required>
                        </div>
                        <label class="form-label">Access to modify</label>
                        <select name="access" class="form-select mb-3" aria-label="Default select example">
                            <option value="owner" selected>Only owner</option>
                            <option value="anyone">Anyone</option>
                        </select>
                        <div class="form-check">
                            <input class="form-check-input" onclick="nokeyword()" type="radio" name="withkeyword" value="0" id="flexRadioDefault1" checked>
                            <label class="form-check-label" for="flexRadioDefault1">
                                Without keyword (You can change it later)
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" onclick="withkeywords()" type="radio" name="withkeyword" value="1" id="flexRadioDefault2">
                            <label class="form-check-label" for="flexRadioDefault2">
                                Keep it safe with keyword
                            </label>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Keyword</label>
                            <input id="keyword" type="password" name="keyword" class="form-control" id="exampleInputPassword1" disabled>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" name="create" style="background-color: #039be5; border: #039be5;" class="btn btn-primary">Create!</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- endmodal -->

    <!-- modal option -->
    <div class="modal fade" id="option" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><i style="font-size: 1.3rem;" class="bi bi-gear"></i> Vault Setting</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST">
                        <div id="setting" class="setting">
                            <div class="mb-3">
                                <label for="vaultname" class="form-label">Vault Name</label>
                                <input type="vault" name="vaultname" class="form-control" id="vaultname" autocomplete="nope" required>
                            </div>
                            <div id="access" class="radio">

                            </div>
                            <div class="form-check">
                                <input class="form-check-input" onclick="nokeyword()" type="radio" name="withkeyword" value="0" id="radio1" checked>
                                <label class="form-check-label" for="radio1">
                                    Without keyword (You can change it later)
                                </label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" onclick="withkeywords()" type="radio" name="withkeyword" value="1" id="radio2">
                                <label class="form-check-label" for="radio2">
                                    Keep it safe with keyword
                                </label>
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputPassword1" class="form-label">Keyword</label>
                                <input id="keywordsetting" type="password" name="keyword" class="form-control" id="exampleInputPassword1" disabled>
                            </div>
                        </div>
                        <div class="mb-3">
                            <button id="deletevault" type="button" class="btn btn-danger"><i class="bi bi-trash3 me-2"></i>Delete</button>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" name="save" style="background-color: #039be5; border: #039be5;" class="btn btn-primary"><i class="bi bi-save me-2"></i>Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- endmodal option -->
    <script>
        <?php if (isset($create)) : ?>
            <?php if ($create[0]) : ?>
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                })

                Toast.fire({
                    icon: 'success',
                    title: '<?= $create[1] ?>'
                })

            <?php endif; ?>
            <?php if (!$create[0]) : ?>
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                })

                Toast.fire({
                    icon: 'error',
                    title: '<?= $create[1] ?>'
                })
            <?php endif; ?>
        <?php endif; ?>
    </script>

    <script>
        const keyword = document.getElementById('keyword');

        function nokeyword() {
            const keywordsetting = document.getElementById('keywordsetting');
            keyword.setAttribute('disabled', '');
            keywordsetting.setAttribute('disabled', '');

        }

        function withkeywords() {
            const keywordsetting = document.getElementById('keywordsetting');
            keyword.removeAttribute('disabled');
            keywordsetting.removeAttribute('disabled');

        }


        function clickoption(uid) {
            let setting = document.getElementById('setting');
            let deletevault = document.getElementById('deletevault');
            const ajax = new XMLHttpRequest()
            ajax.onreadystatechange = () => {
                if (ajax.status == 200 && ajax.readyState == 4) {
                    let data = JSON.parse(ajax.response);
                    setting.innerHTML = data.response;
                    deletevault.dataset.uid = data.uid;


                }
            }
            ajax.open('POST', '<?= BASEURL ?>core/endpoint.php')
            ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded")
            ajax.send(`uid=${uid}`)
        }
    </script>
    <script>
        const url = '<?= BASEURL ?>core/endpoint.php';
    </script>
    <script src="<?= BASEURL ?>public/js/open.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-kjU+l4N0Yf4ZOJErLsIcvOU2qSb74wXpOhqTvwVx3OElZRweTnQ6d31fXEoRD1Jy" crossorigin="anonymous"></script>

</body>

</html>