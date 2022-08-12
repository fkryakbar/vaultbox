<?php
require_once 'core/init.php';


$route->get('home', 'home');
$route->get('login', 'login');
$route->get('register', 'register');
$route->get('vault', 'vaultbox');
$route->get('open', 'open');
$route->get('logout', 'logout');
$route->get('setting', 'setting');



$route->notfound('notfound');
