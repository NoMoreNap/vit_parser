<?php
require('./db.php');


$db = new DB('127.0.0.1:3306','root','123','vitanova');
$all = "SELECT * FROM catalog";
$all = mysqli_fetch_all($db->query($all),1);
var_dump($all);
