<?php
$servername = "localhost";
$username = "root";
$password = "Ashhar@3019";
$database_name = "login_db";

$conn = mysqli_connect($servername, $username, $password, $database_name);

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

$Username = $_POST['User_name'];
$Email = $_POST['Email'];
$Password = $_POST['Pass_word'];

// Check if user or email already exists
$sql_check = "SELECT * FROM `signup` WHERE `username` = '$Username' OR `email` = '$Email'";
$request_check = mysqli_query($conn, $sql_check);
if (mysqli_num_rows($request_check) > 0) {
  echo '<script>alert("User already exists");</script>';
  echo '<meta http-equiv="refresh" content="0;URL=login.html">';
}
else{
  // Insert user data into signup table
$sql_signup = "INSERT INTO `signup` (`username`, `email`, `password`) VALUES ('$Username','$Email','$Password')";
$request_signup = mysqli_query($conn, $sql_signup);

if($request_signup)
{
  // Create table for user
  $table_name = str_replace("@", "_", $Email); // replace "@" in email with "_"
  $table_name = str_replace(".com", "", $table_name);
  $sql_create_table = "CREATE TABLE `$table_name` (`product_name` VARCHAR(255), `product_link` VARCHAR(255))";
  mysqli_query($conn, $sql_create_table);
  
  echo '<script>alert("User Registered!");</script>';
  echo '<meta http-equiv="refresh" content="0;URL=login.html">';
  exit;
}
}

mysqli_close($conn);
?>
