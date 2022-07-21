<?php



  //Database connection
  $servername = "localhost";
  $database = "dbtest";
  $username = "root";
  $password = "";
  
  // Create connection
  
  $conn = mysqli_connect($servername, $username, $password, $database);
  //
  
  // // Check connection
  
  // if (mysqli_connect_errno())
  // {
  // echo "Connection Failed; " . mysqli_connect_error();
  // }
  // else
  // {
  // echo "<div style='text-align:center;font-size:20px;font-weight:600;'>Connection Established</div> \n";
  // }
  