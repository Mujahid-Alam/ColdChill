<?php
$connect = mysqli_connect('localhost','root','','coldchill');


function redirect($page){
    echo "<script>open('$page.php','_self')</script>";
}


?>