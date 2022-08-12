<?php
require 'core/init.php';
session_start();
session_destroy();
setcookie('user', '', time() - 1000);
setcookie('user', '', time() - 1000, '/');
header('Location:' . BASEURL . '');
