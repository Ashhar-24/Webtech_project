<?php
$servername = "localhost";
$username = "root";
$password = "Ashhar@3019";
$database_name = "login_db";

$conn = mysqli_connect($servername, $username, $password, $database_name);

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

$Email = $_POST['Email'];
$Passowrd = $_POST['Password'];
$flag = 0;
$done = 0;
$sql = "SELECT * FROM `signup`";

$result = mysqli_query($conn, $sql);
while($row = mysqli_fetch_assoc($result)) {
    if($Email == $row['email'])
    {
        if($Passowrd == $row['password'])
        {
            $flag = 1;
            $txtName = $row['username'];
            $txtEmail = $row['email'];
            echo 'Redirecting.....';
        }
    }
}
if($flag == 1)
{
    echo '
        <script type="text/javascript">
            function setCookie(cName, cValue, expDays) {
                let date = new Date();
                date. setTime(date. getTime() + (expDays * 24 * 60 * 60 * 1000));
                const expires = "expires=" + date. toUTCString();
                document.cookie = cName + "=" + cValue + "; " + expires + "; path=/";
            }
            setCookie("Name", "'.$txtName.'", 30);
            setCookie("Email", "'.$txtEmail.'", 30);
        </script>
    ';
    echo("<script>window.location = 'index.html';</script>"); 
    // include 'studentportal.html';
    // header('Location: studentportal.html'); 
    // exit;
}   
else
{
    include 'login.html';
    echo '<script type="text/javascript">
    document.getElementById("email").value = "'.$Email.'";
    document.getElementById("match").innerHTML = "Incorrect email id/password. Try again";
    </script>';
    // echo '<h3 style="color:red; text-align:center" >Email Id and password did not match</h3>';
    // header('Location: index.html');
    // exit;
}
?>