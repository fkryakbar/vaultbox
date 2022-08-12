<?php
session_start();
require 'core/init.php';
if (isset($_SESSION['login'])) {
    $id = $_SESSION['login'];
    $data = $db->query("SELECT * FROM users WHERE id = $id");
    $data = mysqli_fetch_assoc($data);
    $username = $data['username'];
} else {
    $id = 0;
}

$root = $app->root();
if (isset($root[1])) {
    $isvaultexist = $app->isvaultexist($root[1]);
    if ($isvaultexist[0]) {
        $access = $app->access($root[1], $id);
        if ($access[0]) {
            $check = false;
        } else {
            $check = $app->iswithkeyword($root[1]);
        }
        if (isset($_SESSION['open'])) {
            if ($_SESSION['open'] == $root[1]) {
                $check = false;
            }
        }
        if (isset($_POST['crack'])) {
            $test = $app->openvault($root[1], $_POST['keyword']);
            if ($test[0]) {
                $_SESSION['open'] = $root[1];
                $check = false;
            } else {
                $check = true;
            }
        }
    } else {
        $error = $isvaultexist[1];
    }
    $file = $app->getfile($root[1]);
} else {
    $error = 'There is no vault here, maybe something wrong with your URL, i guess?';
}




?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once 'component/head.php' ?>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Open | Vaultbox</title>
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
                <?php if (isset($check)) : ?>
                    <?php if (!$check) : ?>
                        <div class="input-group mb-3">
                            <input id="link" type="text" value="<?= BASEURL ?>open/<?= $root[1] ?>" class="form-control" placeholder="Vault link" aria-label="Recipient's username" aria-describedby="button-addon2" disabled>
                            <button onclick="copylink()" style="background-color: #039be5; border: #039be5;" class="btn btn-primary" type="button" id="button-addon2">Copy Link</button>
                        </div>
                        <?php if ($access[0]) : ?>
                            <button id="flush" data-bs-toggle="modal" data-bs-target="#upload" type="button" style="background-color: #039be5; border: #039be5;" class="btn btn-primary"><i class="bi bi-cloud-plus me-2"></i>Upload</button>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
            <?php if (isset($check)) : ?>
                <?php if ($check) : ?>
                    <div style="width: 100%; max-width: 1000px; padding: 20px;" class="border rounded">
                        <p style="color: #039be5;">I think this vault has keyword to open it</p>
                        <form method="POST" action="">
                            <div class="input-group mb-3">

                                <input id="password" name="keyword" type="password" class="form-control" placeholder="Enter keyword" aria-label="Recipient's username" aria-describedby="button-addon2">
                                <button style="background-color: #039be5; border: #039be5;" class="btn btn-primary" type="submit" name="crack" id="button-addon2">Crack the vault!</button>

                            </div>
                        </form>
                        <?php if (isset($test)) : ?>
                            <?php if ($test[0]) : ?>
                                <div class="alert alert-success" role="alert">
                                    <?= $test[1] ?>
                                </div>
                            <?php endif; ?>
                            <?php if (!$test[0]) : ?>
                                <div class="alert alert-danger" role="alert">
                                    <?= $test[1] ?>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
            <?php if (isset($check)) : ?>
                <?php if (!$check) : ?>
                    <div style="width: 100%; max-width: 1000px; padding: 20px;" class="border rounded">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a style="text-decoration: none;" href="<?= BASEURL ?>vault">Vault</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><?= $isvaultexist[2] ?></li>
                        </ol>
                        <?php if (mysqli_num_rows($file) > 0) : ?>
                            <div class="list-group" style="position: relative;">
                                <ol class="list-group list-group-flush list-group-numbered">
                                    <?php while ($dt = mysqli_fetch_assoc($file)) : ?>
                                        <li class="list-group-item">
                                            <a onclick="fileinfo(<?= $dt['id'] ?>)" type="button" data-bs-toggle="modal" data-bs-target="#fileinfo" style="text-decoration: none;color: black;"><?= $dt['filename'] ?></a>
                                            <button data-bs-toggle="modal" data-bs-target="#fileinfo" onclick="fileinfo(<?= $dt['id'] ?>)" style="border: none; background-color: white;" class="float-end more"><i class="bi bi-three-dots-vertical"></i></button>
                                        </li>
                                    <?php endwhile; ?>

                                </ol>
                            </div>
                        <?php endif; ?>
                        <?php if (mysqli_num_rows($file) == 0) : ?>
                            <div style="display: flex; align-items: center; justify-content: center;flex-direction: column;">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a style="text-decoration: none;" href="<?= BASEURL ?>vault">Back to Vault</a></li>
                                </ol>
                                <img width="300px" src="<?= BASEURL ?>public/assets/searching-amico.svg">
                                <h6 class="text-center" style="color: #039be5;">Your vault is empty, let's upload some files</h6>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
            <?php if (isset($error)) : ?>
                <div style="width: 100%; max-width: 1000px; padding: 20px; display: flex; align-items: center; justify-content: center; flex-direction: column;" class="border rounded">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a style="text-decoration: none;" href="<?= BASEURL ?>vault">Back to Vault</a></li>
                        </ol>
                    </nav>
                    <img width="300px" src="<?= BASEURL ?>public/assets/Empty-amico.svg">
                    <h6 class="text-center" style="color: #039be5;"><?= $error ?></h6>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <!-- Modal upload -->
    <div class="modal fade" id="upload" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><i style="font-size: 1.3rem;" class="bi bi-cloud-plus me-2"></i>Upload File</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div id="inputs" class="input-group mb-3">
                            <input type="file" class="form-control" id="file">
                            <label class="input-group-text" for="file">Upload</label>
                        </div>
                        <div id="progressbar">

                        </div>
                        <div class="progressbar">
                            <div class="progress">
                                <div class="progress-bar" id="bar" role="progressbar" aria-label="Example with label" style="width: 50%; display: none;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">0%</div>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button> -->
                    <!-- <button type="button" name="create" style="background-color: #039be5; border: #039be5;" class="btn btn-primary">Upload</button> -->
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- endmodal -->
    <!-- modal file info -->
    <div class="modal fade" id="fileinfo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div id="desc" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><i style="font-size: 1.3rem;" class="bi bi-list-ul me-2"></i>File properties</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-floating mb-3">
                        <input type="filename" readonly class="form-control-plaintext" id="filename" placeholder="filename" value="filename">
                        <label for="floatingPlaintextInput">Filename</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="Size" readonly class="form-control-plaintext" id="size" placeholder="Size" value="Size">
                        <label for="floatingPlaintextInput">Size</label>
                    </div>

                </div>
                <div id="buttongrup" class="modal-footer select">
                    <?php if ($access[0]) : ?>
                        <button id="delete" type="button" data-ref="" class="btn btn-danger delete">
                            <span id="spinnerdelete" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                            <i class="bi bi-trash3 me-2"></i>Delete
                        </button>
                    <?php endif; ?>
                    <button id="copy" type="button" data-ref="" style="background-color: #039be5; border: #039be5;" class="btn btn-primary copy">
                        <span id="copyspinner" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                        <i class="bi bi-clipboard me-2"></i>Copy Download Link
                    </button>
                    <button id="download" type="button" data-ref="" class="btn btn-success download">
                        <span id="spinnerdownload" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                        <i class="bi bi-download me-2"></i>Download
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- endmodal -->

















    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-kjU+l4N0Yf4ZOJErLsIcvOU2qSb74wXpOhqTvwVx3OElZRweTnQ6d31fXEoRD1Jy" crossorigin="anonymous"></script>
    <?php if (isset($check)) : ?>
        <?php if (!$check) : ?>
            <script>
                function copylink() {
                    const link = document.getElementById('link');
                    link.select();
                    link.setSelectionRange(0, 99999);
                    navigator.clipboard.writeText(link.value);
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
                        title: `link copied to clipboard`
                    })


                }

                function fileinfo(id) {
                    const filename = document.getElementById('filename');
                    const deletefile = document.getElementById('delete');
                    const copy = document.getElementById('copy');
                    const download = document.getElementById('download');
                    const size = document.getElementById('size');
                    const ajax = new XMLHttpRequest()
                    ajax.onreadystatechange = () => {
                        if (ajax.status == 200 && ajax.readyState == 4) {
                            let data = JSON.parse(ajax.response);
                            filename.value = data.filename;
                            if (document.body.contains(deletefile)) {
                                deletefile.dataset.ref = data.ref;
                                deletefile.dataset.id = data.id;
                            }
                            copy.dataset.ref = data.ref;
                            download.dataset.ref = data.ref;
                            size.value = data.filesize;


                        }
                    }
                    ajax.open('POST', '<?= BASEURL ?>core/endpoint.php');
                    ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                    ajax.send(`fileinfo=${id}`);
                }
            </script>
            <script>
                const folder = '<?= $root[1] ?>';
                const url = '<?= BASEURL ?>core/endpoint.php';
            </script>

            <script src="<?= BASEURL ?>public/js/main.js"></script>
        <?php endif; ?>
    <?php endif; ?>
</body>

</html>