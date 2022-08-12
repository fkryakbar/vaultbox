<?php

class User
{
    private $db;
    public function __construct($db)
    {
        $this->db = $db;
    }

    public function accountsetting($id, $username, $oldpassword, $newpassword)
    {
        $username = htmlspecialchars($username);
        $query = "SELECT * FROM users WHERE id = $id";
        $data = mysqli_query($this->db, $query);
        $data = mysqli_fetch_assoc($data);
        if (password_verify($oldpassword, $data['password'])) {
            $newpassword = password_hash($newpassword, PASSWORD_DEFAULT);
            $query = "UPDATE users SET username = '$username', password = '$newpassword' WHERE id = $id";
            $data = mysqli_query($this->db, $query);
            return [true, 'Your changes have been saved successfully'];
        } else {
            return [false, 'Incorrect Password'];
        }
    }

    public function register($email, $username, $password, $conpassword)
    {
        $email = htmlspecialchars($email);
        $username = htmlspecialchars($username);
        $password = htmlspecialchars($password);
        $conpassword = htmlspecialchars($conpassword);
        if ($password == $conpassword) {
            $query = "SELECT * FROM users WHERE email = '$email'";
            $check = mysqli_query($this->db, $query);
            if (mysqli_num_rows($check) == 0) {
                $password = password_hash($password, PASSWORD_DEFAULT);
                $query = "INSERT INTO users VALUES (0 , '$email', '$username', '$password')";
                mysqli_query($this->db, $query);
                return [true, 'Account Created!'];
            } else {
                return [false, 'Email already used'];
            }
        } else {
            return [false, 'Incorrect password confirmation'];
        }
    }

    private function addcookie($id)
    {
        $time = time() + 604800;
        $id = $id;
        $key = 'bismillahallahuakbar';
        $code = $time . '.' . $id . '.' . $id . '-' . $key;
        $token = base64_encode($code);
        $query = "INSERT INTO session VALUES(0, '$token')";
        mysqli_query($this->db, $query);
        setcookie('user', $token, time() + 604800);
    }

    public function checkcookie($token)
    {
        $query = "SELECT * FROM session WHERE token = '$token'";
        $data = mysqli_query($this->db, $query);
        if (mysqli_num_rows($data) > 0) {
            $decode = base64_decode($token);
            $decode = explode('.', $decode);
            $id = (int)$decode[1];
            $time = (int)$decode[0];
            $key = explode('-', $decode[2]);
            $secret = $key[1];
            $cookieid = (int)$key[0];
            $timenow = time();
            if ($cookieid == $id && $secret == 'bismillahallahuakbar' && $timenow <= $time) {
                return [true, $id];
            } else {
                return [false, 'incorrect'];
            }
        }
    }

    public function login($email, $password, $remember)
    {
        $query = "SELECT * FROM users WHERE email = '$email'";

        $data = mysqli_query($this->db, $query);
        if (mysqli_num_rows($data) > 0) {
            $dbpass = mysqli_fetch_assoc($data);
            $dbpass = $dbpass['password'];
            if (password_verify($password, $dbpass)) {
                $id = mysqli_query($this->db, $query);
                $id = mysqli_fetch_assoc($id)['id'];
                if ($remember == 1) {
                    $this->addcookie($id);
                }
                return [true, 'Login', (int) $id];
            } else {
                return [false, 'Incorrect Password'];
            }
        } else {
            return [false, "Account doesn't exist"];
        }
    }
}
