<?php

$ServerName = 'localhost';
$username = 'root';
$password = '';
$dbName = 'ggshopp';

$db = mysqli_connect($ServerName, $username, $password) or die(mysqli_error($conn));

if($db) {
  $checkDB = "SELECT SCHEMA_NAME FROM information_schema.SCHEMATA WHERE SCHEMA_NAME = '$dbName'";
  $result = $db->query($checkDB);
  if($result->num_rows > 0) {
    // echo "Database name: $dbName already exist\n";
  } else {
    // SQL query to create new database
    $createDB = "CREATE DATABASE $dbName";
    if ($db->query($createDB) === TRUE) {
      // echo "ggshopp database created successfully.";
    } else {
      die("Error creating database: ". $db->error);
    }
  }


   // Connecting to the Wishlist database
   $conn = mysqli_connect($ServerName, $username, $password, $dbName);
   if($conn) {
    $accoutTable = "account";
    $tableCheckQuery = "SHOW TABLES LIKE '$accoutTable'";
    $result = $conn->query($tableCheckQuery);
    // Check if the table exists
    if ($result->num_rows > 0) {
      // echo "Table already exists.";
    } else {
      // Creating wishlist table
      $createTable = "CREATE TABLE $accoutTable (
        id INT(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
        fullname VARCHAR(50) NOT NULL,
        email VARCHAR(100) NOT NULL,
        password VARCHAR(255) NOT NULL,
        token VARCHAR(255) NOT NULL,
        hash VARCHAR(255) NOT NULL,
      )";

      if (mysqli_query($conn, $createTable)) {
        echo "Table created successfully.";
        mysqli_close($dbWishlist);
      } else {
        echo "Error creating table: " . mysqli_error($conn);
      }
    }
      
   } else {
     die("Error: could not connect to the wishlist database");
   }

   $conn->close();
}