<?php
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

$filter = $_POST["filter"];
$sql1 = "SELECT * FROM shopping_db.products WHERE item_cat = \"$filter\";";
$details1 = $conn->query($sql1);

$filter2 = $_POST["filter2"];
$sql2 = "SELECT * FROM shopping_db.products WHERE item_name LIKE \"%$filter2%\";";
$details2 = $conn->query($sql2);
        
if ($details1->num_rows > 0) {
    echo "
      <div style=\"padding-top: 20px;\" class=\"page-header\">
        <h1>". $filter . "</h1>
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

    while($row = $details1->fetch_assoc()) {
        echo "
                <tr>
                  <td>" . $row["item_id"] . "</td>
                  <td>
                    <img src=\"" . $row["item_id"] . ".jpg\"/>
                  </td>
                  <td>" . $row["item_name"] . "</td>
                  <td>" . $row["item_desc"] . "</td>
                  <td>$" . $row["item_price"] . "</td>
                   <form action=\"myCart.php\" method=\"post\">
                    <td>
                    <select name=\"c_qty\">
                        <option value=\"1\">1</option>
                        <option value=\"2\">2</option>
                        <option value=\"3\">3</option>
                     </select>
                     </td>
                     <td>
                      <input type=\"hidden\" name=\"p_id\" value=\"" . $row["item_id"] . "\">
                      <button type=\"submit\" class=\"btn btn-sm btn-primary\" >Add to Cart!</button>
                     </td>
                  </form>
                </tr>
      ";
    }
} else if ($details2->num_rows > 0){
      echo "
      <div style=\"padding-top: 20px; padding-bottom: 20px;\" class=\"page-header\">
        <h1>". $filter2 . "</h1>
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

    while($row = $details2->fetch_assoc()) {
        echo "
                <tr>
                  <td>" . $row["item_id"] . "</td>
                  <td>
                    <img src=\"" . $row["item_id"] . ".jpg\"/>
                  </td>
                  <td>" . $row["item_name"] . "</td>
                  <td>" . $row["item_desc"] . "</td>
                  <td>$" . $row["item_price"] . "</td>
                  <form action=\"myCart.php\" method=\"post\">
                    <td>
                    <select name=\"c_qty\">
                        <option value=\"1\">1</option>
                        <option value=\"2\">2</option>
                        <option value=\"3\">3</option>
                     </select>
                     </td>
                     <td>
                      <input type=\"hidden\" name=\"p_id\" value=\"" . $row["item_id"] . "\">
                      <button type=\"submit\" class=\"btn btn-sm btn-primary\" >Add to Cart!</button>
                     </td>
                  </form>
                </tr>
      ";
    }
} else {
  echo "<br><br><br>No results found for \"" . $filter2 . "\"";
}
 
echo "        
        </tbody>
      </table>
";

include('navbar.html');
$conn->close();

?>
