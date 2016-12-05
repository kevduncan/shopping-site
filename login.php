<?php
session_start();

echo "
  <!DOCTYPE HTML>
  <html>";

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "shopping_db";

$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$username = $_POST["usern"];
$password = $_POST["passwd"];
$_SESSION['user'] = $username; 

echo "<div style=\"padding-top: 50px;\"><p class=\"text-center\">";
echo "username entered: " . $username . "<br>";
echo "password entered: " . $password . "<br>";

$sql = "SELECT u_id, u_login, u_pass FROM users WHERE u_login = \"$username\" AND u_pass = \"$password\"";
$result = $conn->query($sql);

if($result->num_rows > 0){
	while($row = $result->fetch_assoc()) {
		echo "Account information:<br> User Id: " . $row["u_id"] . "<br>Username: " . $row["u_login"] . "<br>Password: " . $row["u_pass"];
		$_SESSION['user_id'] = $row["u_id"];
	}
}else {
	echo "<br><h1>invalid login</h1>";
}

echo "</p></div>";

include('navbar.html');
?>
