<?php
//THIS PHP PAGE IS CALLED WHEN THE "ADD TO CART" BUTTONS ARE PRESSED
//INSERT AND SELECT
session_start();

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "shopping_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$total = 0;
$u_id = $_SESSION['user_id']; //need to figure out how to post user id from each page
$p_id = $_POST["p_id"];
$c_qty = $_POST["c_qty"];

//REPLACE INTO works as INSERT except it will replace a record that has the same primary key which is u_p_id
//ensures the cart will only show one unique items 
$sql1 = "REPLACE INTO shopping_db.cart VALUES (\"$u_id\",\"$p_id\",\"$c_qty\",concat(\"$u_id\",\"$p_id\"));";
$insert = $conn->query($sql1);

$sql2 = "SELECT c.u_id, c.c_qty, c.p_id, p.item_name, p.item_desc, p.item_price
FROM shopping_db.cart c LEFT JOIN shopping_db.products p ON c.p_id = p.item_id WHERE c.u_id = \"$u_id\";";
$details = $conn->query($sql2);


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
                  <td>Total</td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td>$" . $total . ".00</td>
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
