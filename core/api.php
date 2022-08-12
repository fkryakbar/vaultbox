<?php
require 'init.php';
header("Access-Control-Allow-Origin: https://himaptika-fkip-ulm.epizy.com");
header("Access-Control-Allow-Headers: *");

if (isset($_GET['token'])) {
    if ($_GET['token'] == 'webdev') {
        $folder = $_GET['vaultuid'];
        $query = "SELECT * FROM file WHERE folder = '$folder' ";
        $data = $db->query($query);
        $json = [];
        while ($dt = mysqli_fetch_assoc($data)) {
            array_push($json, $dt);
        }

        echo json_encode($json);
    } else {
        echo 'something went wrong';
    }
} else {
    echo 'api portal';
}
