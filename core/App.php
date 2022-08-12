<?php

class App
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function root()
    {
        $url = ["home", "index"];
        if (isset($_GET["method"])) {
            $url = rtrim($_GET["method"], "/");
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode("/", $url);
        }
        return $url;
    }


    private function uid()
    {
        $word = array_merge(range('A', 'Z'), range('a', 'z'), range(0, 9));
        shuffle($word);
        return substr(implode($word), 0, 12);
    }

    private function checkuid($uid)
    {
        $query = "SELECT * FROM vault WHERE uid = '$uid'";
        $data = mysqli_query($this->db, $query);
        if (mysqli_num_rows($data) == 0) {
            return true;
        } else {
            return false;
        }
    }

    private function checkvaultname($name, $owner)
    {
        $query = "SELECT * FROM vault WHERE name = '$name' AND owner = '$owner'";
        $data = mysqli_query($this->db, $query);
        if (mysqli_num_rows($data) == 0) {
            return true;
        } else {
            return false;
        }
    }

    private function wordcount($name)
    {
        if (strlen($name) <= 25) {
            return true;
        } else {
            return false;
        }
    }

    public function create($name, $owner, $withkeyword, $keyword, $access)
    {
        $name = htmlspecialchars($name);
        $uid = $this->uid();
        if ($this->checkvaultname($name, $owner)) {
            if ($this->checkuid($uid)) {
                if ($this->wordcount($name)) {
                    $query = "INSERT INTO vault VALUES (0, '$uid','$name', '$owner', '$withkeyword', '$keyword' , '$access')";
                    mysqli_query($this->db, $query);
                    return [true, 'Vault Created'];
                } else {
                    return [false, 'Max 25 characters long'];
                }
            } else {
                return [false, 'Something wrong, maybe you should try again'];
            }
        } else {
            return [false, 'Vault name already used'];
        }
    }

    public function getvault($owner)
    {
        $query = "SELECT * FROM vault WHERE owner = '$owner'";
        $data = mysqli_query($this->db, $query);
        return $data;
    }

    public function update($name, $withkeyword, $keyword, $uid, $oldname, $owner, $access)
    {
        if ($name == $oldname) {
            if ($this->wordcount($name)) {
                $query = "UPDATE vault SET withkeyword = '$withkeyword', keyword = '$keyword', access = '$access' WHERE uid = '$uid'";
                mysqli_query($this->db, $query);
                return [true, 'New changes saved!'];
            } else {
                return [false, 'Max 25 characters long'];
            }
        } else {
            if ($this->checkvaultname($name, $owner)) {
                if ($this->wordcount($name)) {
                    $name = htmlspecialchars($name);
                    $query = "UPDATE vault SET name = '$name', withkeyword = '$withkeyword', keyword = '$keyword' WHERE uid = '$uid'";
                    mysqli_query($this->db, $query);
                    return [true, 'New changes saved!'];
                } else {
                    return [false, 'Max 25 characters long'];
                }
            } else {
                return [false, 'Vault name already used'];
            }
        }
    }

    public function iswithkeyword($uid)
    {
        $query = "SELECT * FROM vault WHERE uid = '$uid'";
        $data = mysqli_query($this->db, $query);
        $data = mysqli_fetch_assoc($data);
        if ($data['withkeyword'] == 0) {
            return false;
        } else {
            return true;
        }
    }
    public function openvault($uid, $password)
    {
        $query = "SELECT * FROM vault WHERE uid = '$uid'";
        $data = mysqli_query($this->db, $query);
        $data = mysqli_fetch_assoc($data);
        if ($data['keyword'] == $password) {
            return [true, 'Opened'];
        } else {
            return [false, 'Well, your keyword is incorrect'];
        }
    }

    public function isvaultexist($uid)
    {
        $query = "SELECT * FROM vault WHERE uid = '$uid'";
        $data = mysqli_query($this->db, $query);
        if (mysqli_num_rows($data) > 0) {
            $data = mysqli_fetch_assoc($data);
            return [true, "Exist", $data['name']];
        } else {
            return [false, "Hmmmm, the vault doesn't exist anymore..."];
        }
    }

    public function access($uid, $owner)
    {
        $query = "SELECT * FROM vault WHERE uid = '$uid' AND owner = '$owner'";
        $data  = mysqli_query($this->db, $query);
        if (mysqli_num_rows($data) > 0) {
            return [true, 'access allowed'];
        } else {
            $query = "SELECT * FROM vault WHERE uid = '$uid'";
            $data  = mysqli_query($this->db, $query);
            $data = mysqli_fetch_assoc($data);
            if ($data['access'] == 'owner') {
                return [false, 'access denied'];
            } else {
                return [true, 'access allowed'];
            }
        }
    }

    public function getfile($uid)
    {
        $query = "SELECT * FROM file WHERE folder = '$uid'";
        return mysqli_query($this->db, $query);
    }
}
