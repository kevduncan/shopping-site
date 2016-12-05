<?php
session_start();
session_destroy();

echo '<div style="padding-top:100px;"><h3 class="text-center">YOU HAVE SUCCESSFULLY LOGGED OUT</h3></div>';

include('navbar.html');
?>