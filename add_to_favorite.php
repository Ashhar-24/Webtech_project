<?php
// Retrieve user's name from session or login information
// $user_name = "Username";

// Establish connection to the MySQL database
$servername = "localhost";
$username = "root";
$password = "Ashhar@3019";
$dbname = "login_db";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch user's email address from the cookie
if(isset($_COOKIE['e_mail'])) {
  $Email = $_COOKIE['e_mail'];
  $table_name = str_replace("@", "_", $Email);
  $table_name = str_replace(".com", "", $table_name);

} else {
  die("Email address not found in cookie!");
}


//get prod name and link
// $product_name = $_POST['product_name'];
$product_link = mysqli_real_escape_string($conn, $_POST['product_link']);
$product_name = mysqli_real_escape_string($conn, $_POST['product_name']);


// Check if the product already exists in the user's table
$sql = "SELECT * FROM $table_name WHERE product_name = '$product_name'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
  // Product already exists, display an alert
  echo '<script>alert("Product already exists in the list!"); history.go(-1); </script>';
} else {
  // Insert the product into the user's table
  $sql = "INSERT INTO $table_name (product_name, product_link) VALUES ('$product_name', '$product_link')";
  echo '<script>alert("Product added!"); history.go(-1); </script>';
  mysqli_query($conn, $sql);
}

// Close the database connection
mysqli_close($conn);

?>








