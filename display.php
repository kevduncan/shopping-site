<?php

echo "
  <!DOCTYPE HTML>
  <html>

  <head>
    <title>Nanozon</title>
    <link rel=\"shortcut icon\" href=\"favicon.ico\">
    <!-- Latest compiled and minified CSS -->
    <link rel=\"stylesheet\" href=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css\" integrity=\"sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u\" crossorigin=\"anonymous\">
    <!-- Optional theme -->
    <link rel=\"stylesheet\" href=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css\" integrity=\"sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp\" crossorigin=\"anonymous\">
  </head>
";

echo "
    <nav class=\"navbar navbar-inverse navbar-fixed-top\" id=\"topnav\">
                <div class=\"container-fluid\">
                    <div class=\"navbar-header\">
                        <a class=\"navbar-brand\">Nanozon</a>
                    </div>

                <ul class=\"nav navbar-nav navbar-left\">
                    <li id=\"home\"><a href=\"home.html\">Home</a></li> 
                </ul>
                <ul class=\"nav navbar-nav navbar-center\">
                    <li id=\"search\" class=\"text-left\">
                       <form class=\"navbar-form\" id=\"search\" role=\"search\" action=\"display.php\" method=\"post\">
                        <div class=\"form-group\">
                           <input type=\"text\" name=\"filter2\" class=\"form-control\" placeholder=\"Search...\">
                           <input type=\"submit\">
                        </div>
                  </form>
                    </li>
                </ul>
                <ul class=\"nav navbar-nav navbar-right\">
                    <li id=\"login\" class=\"pop\"><a href=\"#\">Login</a></li> <!--login.php as href-->
                    <li id=\"cart\"><a href=\"cart.php\"><span class=\"glyphicon glyphicon-shopping-cart\"></span></a></li>
                </ul>
              </div>
            </nav>
      <div id=\"loginContainer\" class=\"container-fluid\">
        <div class=\"modal fade bs-modal-lg\" id=\"myModal\" tabindex=\"-1\" role=\"dialog\">
          <div class=\"modal-dialog\" role=\"document\">
            <div class=\"modal-content\">
              <div class=\"modal-header\">
                <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>
                <h4 class=\"modal-title text-center\">LOGIN</h4>
              </div>
              <div class=\"modal-body\">
                <h3 class=\"text-center text-info\">USERNAME</h3>
                <input class=\"inp-center text-muted\" type=\"text\" placeholder=\"username\">
                <br>
                <h3 class=\"text-center text-info\">PASSWORD</h3>
                <input class=\"inp-center text-muted\" type=\"password\" placeholder=\"password\">
                <br>
                <button class=\"center text-primary\" type=\"submit\" onclick=\"\">SUBMIT</button>
              </div>
            </div>
          </div>
        </div>
      </div>
";

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
  // echo "<div style=\"padding-top:75px;\">
  //         <p>" . $filter . "</p>
  //       </div>
  // ";

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
      <div class=\"row\">
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
                  <td><select>
                        <option value=\"0\">0</option>
                        <option value=\"1\">1</option>
                        <option value=\"2\">2</option>
                     </select>
                  </td>
                </tr>
      ";
    }
} else if ($details2->num_rows > 0){
      echo "
      <div style=\"padding-top: 20px;\" class=\"page-header\">
        <h1>". $filter2 . "</h1>
      </div>
      <div class=\"row\">
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
                  <td><select>
                        <option value=\"0\">0</option>
                        <option value=\"1\">1</option>
                        <option value=\"2\">2</option>
                     </select>
                  </td>
                </tr>
      ";
    }
} else {
  echo "<br><br><br>No results found for \"" . $filter2 . "\"";
}



echo "        
        </tbody>
      </table>
  </div>
  <footer>
      <p style=\"color: #9d9d9d;\">&copy;NanoZon 2016 -- Kevin, Hector, Maneesh</p>
    </footer>
  </div>
  <script src=\"https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js\"></script>
    <script src=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js\" integrity=\"sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa\" crossorigin=\"anonymous\"></script>
  </body>


  <script type=\"text/javascript\">
    $(function() {
      $('.pop').on('click', function() {
        $('#myModal').modal('show');  
      });   
    });
  </script>
    <style>
      body {
          position: relative;
          height: 100%;
      }
      img.car-center{
        padding-top:75px;
        display: block;
        margin-left: auto;
        margin-right: auto;
      }
      input.inp-center{
        color: #000000;
        display: block;
        margin-left: auto;
        margin-right: auto;
      }
      .center{
        display: block;
        margin-left: auto;
        margin-right: auto;
      }
      footer {
       position: fixed;
       right: 0;
       bottom: 0;
       left: 0;
       padding: 1rem;
       background-color: #3c3c3c;
       text-align: center;
      }

  </style>

</html>
";

$conn->close();

?>
