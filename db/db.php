<?php

$ServerName = 'localhost';
$username = 'root';
$password = '';
$dbName = 'ggshopp';

$conn = mysqli_connect($ServerName, $username, $password, $dbName) or die(mysqli_error($conn));
