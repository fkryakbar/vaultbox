<?php
require 'init.php';
if (isset($_POST['uid'])) {
    $uid = $_POST['uid'];
    $data = $db->query("SELECT * FROM vault WHERE uid = '$uid'");
    $data = mysqli_fetch_assoc($data);
    $response = '';
    $response .= '<div class="mb-3">
    <label for="vaultname" class="form-label">Vault Name</label>
    <input type="vault" name="vaultname" value="' . $data["name"] . '" class="form-control" id="vaultname" autocomplete="nope" required>
    </div>';
    if ($data['access'] == 'owner') {
        $response .= '<label class="form-label">Access to modify</label>
        <select name="access" class="form-select mb-3" aria-label="Default select example">
            <option value="owner" selected>Only owner</option>
            <option value="anyone">Anyone</option>
        </select>';
    } else {
        $response .= '<label class="form-label">Access to modify</label>
        <select name="access" class="form-select mb-3" aria-label="Default select example">
            <option value="owner" >Only owner</option>
            <option value="anyone" selected>Anyone</option>
        </select>';
    }

    if ($data['withkeyword'] == 1) {
        $response .= '<div class="form-check">
        <input class="form-check-input" onclick="nokeyword()" type="radio" name="withkeyword" value="0" id="radio1">
        <label class="form-check-label" for="radio1">
            Without keyword (You can change it later)
        </label>
    </div>
    
    <div class="form-check">
        <input class="form-check-input" onclick="withkeywords()" type="radio" name="withkeyword" value="1" id="radio2" checked>
        <label class="form-check-label" for="radio2">
            Keep it safe with keyword
        </label>
    </div>
    <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">Keyword</label>
        <input id="keywordsetting" value="' . $data["keyword"] . '"  type="password" name="keyword" class="form-control" id="exampleInputPassword1">
    </div>   
    <input name="uid" value="' . $data["uid"] . '" style="display: none;">
    <input name="oldname" value="' . $data["name"] . '" style="display: none;">';
    } else {
        $response .= '<div class="form-check">
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
        <input id="keywordsetting" value="' . $data["keyword"] . '"  type="password" name="keyword" class="form-control" id="exampleInputPassword1" disabled>
    </div>
   
    <input name="uid" value="' . $data["uid"] . '" style="display: none;">
    <input name="oldname" value="' . $data["name"] . '" style="display: none;">';
    }

    $arr = array(
        "oldname" => $data["name"],
        "uid" => $data['uid'],
        "withkeyword" => $data['withkeyword'],
        "keyword" => $data["keyword"],
        "response" => $response
    );

    echo json_encode($arr);
}

if (isset($_POST['delete'])) {
    $uid = $_POST['delete'];
    $db->query("DELETE FROM vault WHERE uid = '$uid'");
    $db->query("DELETE FROM file WHERE folder = '$uid'");
}

if (isset($_POST['filename'])) {
    $filename = $_POST['filename'];
    $uid = $_POST['folder'];
    $size = $_POST['size'];
    $path = $_POST['path'];
    $query = "SELECT * FROM file WHERE folder = '$uid' AND filename = '$filename'";
    $data = $db->query($query);
    if (mysqli_num_rows($data) > 0) {
        echo 'false';
    } else {
        $filename = htmlspecialchars($filename);
        $query = "INSERT INTO file VALUES (0 , '$filename', '$uid', '$size', '$path', '')";
        $db->query($query);
        echo 'true';
    }
}

if (isset($_POST['fileinfo'])) {
    $id = (int)$_POST['fileinfo'];
    $query = "SELECT * FROM file WHERE id = $id";
    $data = $db->query($query);
    $data = mysqli_fetch_assoc($data);

    $arr = array(
        "id" => $data['id'],
        "filename" => $data['filename'],
        "ref" => $data['folder'] . '/' . $data['filename'],
        "filesize" => $data['size']
    );

    echo json_encode($arr);
}


if (isset($_POST['deletefile'])) {
    $id = (int)$_POST['deletefile'];
    $query = "DELETE FROM file WHERE id = $id";
    mysqli_query($db->db, $query);
}

if (isset($_POST['inserturl'])) {
    $endofurl = $_POST['path'] . '?alt=media&token=' . $_POST['token'];
    $endofurl = str_replace('/', '%2F', $endofurl);
    $url = "https://firebasestorage.googleapis.com/v0/b/vaultbox-f39f3.appspot.com/o/" . $endofurl;
    $path = $_POST['path'];
    $query = "UPDATE file SET link = '$url' WHERE path = '$path' ";
    $db->query($query);
    echo 'true';
}
