<?php
//THIS PHP IS CALLED WHEN THE CART ICON BUTTON IS PRESSED
//JUST SELECT
session_start();

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "shopping_db";
$total = 0;
$u_id = $_SESSION['user_id'];

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$to_delete = $_POST["delete_prod_id"];
$sql2 = "DELETE FROM shopping_db.cart WHERE p_id = \"$to_delete\";";
$deleted = $conn->query($sql2);

$sql = "SELECT c.u_id, c.c_qty, c.p_id, p.item_name, p.item_desc, p.item_price
FROM shopping_db.cart c LEFT JOIN shopping_db.products p ON c.p_id = p.item_id WHERE c.u_id = \"$u_id\";";
$details = $conn->query($sql);

if ($details->num_rows > 0) {
    echo "
      <div style=\"padding-top: 20px;\" class=\"page-header\">
        <h1>My Cart<h1>
      </div>
      <div class=\"row\" style=\"padding-bottom: 25px;\">
      <div class=\"col-md-8\">
        <table class=\"table\">
          <thead>
            <tr>
              <th>Item#</th>
              <th>Image</th>
              <th>Product Name</th>
              <th>Description</th>
              <th>Price</th>
              <th>Qty</th>
            </tr>
          </thead>
          <tbody>
    ";

    while($row = $details->fetch_assoc()) {
        echo "
                <tr>
                  <td>" . $row["p_id"] . "</td>
                  <td>
                    <img src=\"" . $row["p_id"] . ".jpg\"/>
                  </td>
                  <td>" . $row["item_name"] . "</td>
                  <td>" . $row["item_desc"] . "</td>
                  <td>$" . $row["item_price"] . "</td>
                  <td>
                      " . $row["c_qty"] . "
                  </td>
                  <td>
                    <form action=\"viewCart.php\" method=\"post\">
                      <input type=\"hidden\" name=\"delete_prod_id\" value=\"" . $row["p_id"] . "\">
                      <button type=\"submit\" class=\"btn btn-sm btn-primary\" >Remove From Cart</button>
                    </form>
                  </td>
                </tr>
      ";

      $total = $total + $row["item_price"]*$row["c_qty"];

    }
      echo "
               <tr>
                  <td><h3>Total</h3></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td><h3>$" . $total . ".00</h3></td>
                </tr>
      ";
} 
else{
  echo "<h1 style=\"padding-top:50px;\">NOTHING IN CART</h1>";
}


echo "
      </tbody>
            </table>
";

include('navbar.html');
$conn->close();
?>