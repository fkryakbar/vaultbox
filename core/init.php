<?php
require_once 'config.php';
require_once 'Route.php';
require_once 'Database.php';
require_once 'User.php';
require_once 'App.php';

$route = new Route();
$db = new Database('localhost', 'root', '', 'vaultbox');
$user = new User($db->db);
$app = new App($db->db);
