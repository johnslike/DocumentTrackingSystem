<?php

require_once('../db/connect_db.php');
$userdetails = $store->get_userdata();
$id = $userdetails['id'];

$store->logout();

header("Location: login.php")

?>