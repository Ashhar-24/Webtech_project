<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) &&$_POST['action'] === 'fetch'){
// Retrieve user's email address from cookies
$email = $_COOKIE['e_mail'];

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

// Create table name by replacing "@" and ".com" in email with "_"
$table_name = str_replace("@", "_", $email);
$table_name = str_replace(".com", "", $table_name);

// Fetch saved items from user's table
$sql = "SELECT * FROM $table_name";
$result = mysqli_query($conn, $sql);

// Build an HTML table with saved items
$table_name = "Saved Items"; // replace "your_table_name" with the actual name of your table
$table_html = "<table>";
$table_html .= "<caption>".$table_name."</caption>"; // add the table name as a caption
$table_html .= "<tr><th>Product Name</th><th>Product Link</th><th>Action</th></tr>";
while ($row = mysqli_fetch_assoc($result)) {
    $table_html .= "<tr>";
    $table_html .= "<td>".$row['product_name']."</td>";
    $table_html .= "<td><a href=".$row['product_link']." target=_blank>".$row['product_link']."</a></td>";
    $table_html .= "<td><button onclick=\"deleteItem('".$row['product_name']."','".$row['product_link']."')\">Delete</button></td>";
    $table_html .= "</tr>";
}
$table_html .= "</table>";

// Close the database connection
mysqli_close($conn);

// Load the existing HTML file and replace the contents of the <main> element with the new table
$saved_items_html = file_get_contents('saved_items.html');
$saved_items_html = preg_replace('#<main>.*?</main>#s', '<main>' . $table_html . '</main>', $saved_items_html);

// Save the updated HTML to the file
file_put_contents('saved_items.html', $saved_items_html);

 // Redirect the user to the saved_items.html file
 header('Location: saved_items.html');
 exit;
}
?>