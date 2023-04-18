<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name']) && isset($_POST['link'])) {
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

  // Delete the item from the user's table
  
  $name = mysqli_real_escape_string($conn, $_POST['name']);
  $link = mysqli_real_escape_string($conn, $_POST['link']);

  $sql = "DELETE FROM $table_name WHERE product_name='$name' AND product_link='$link'";
  // mysqli_query($conn, $sql);
  if (mysqli_query($conn, $sql)) {
    echo '<script>alert("Item deleted successfully!");</script>';
    echo '<meta http-equiv="refresh" content="0;URL=index.html">';
  } else {
    echo "Error deleting item: " . mysqli_error($conn);
  }

  // Fetch saved items from user's table
  $sql = "SELECT * FROM $table_name";
  $result = mysqli_query($conn, $sql);

  // Build an HTML table with saved items
  $table_name = "Saved Items"; // replace "your_table_name" with the actual name of your table
  $table_html = "<table>";
  $table_html .= "<caption>".$table_name."</caption>"; // add the table name as a caption
  $table_html .= "<tr><th>Product Name</th><th>Product Link</th></tr>";
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
  if (isset($_POST['delete']) && $_POST['delete'] === 'true') {
      // If delete button was clicked, remove the table from the HTML file
      $saved_items_html = preg_replace('#<main>.*?</main>#s', '', $saved_items_html);
  } else {
      // If delete button was not clicked, add the table to the HTML file along with the delete button
      $delete_button = '<form method="post"><input type="hidden" name="action" value="fetch"><input type="hidden" name="delete" value="true"><button type="submit">Delete Items</button></form>';
      $saved_items_html = preg_replace('#<main>.*?</main>#s', '<main>' . $table_html . $delete_button . '</main>', $saved_items_html);
  }

  // Redirect the user to the saved_items.html file
//   header('Location: saved_items.html');
//   exit;

//   echo ("<script>window.location='saved_items.html'; </script>");
// echo "<script>window.location = 'saved_items.html';</script>";
}
?>
