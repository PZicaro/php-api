<?php
require('./var.php');
$pdo = new PDO("mysql:dbname=$db_name;host=$db_host", $db_user, $db_pass);
$array = [];