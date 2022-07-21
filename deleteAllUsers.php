<?php


  //Database connection
  include 'db_connection.php';
  //
  $sql = "TRUNCATE TABLE users";
    $conn->query($sql); 