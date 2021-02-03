<?php  include "include/dbconnect.php" ;




if(isset($_GET['food_id'])){
    $f_id = $_GET['food_id'];

//cheching order

    $order = mysqli_query($connect, "SELECT * FROM orderss WHERE f_id='$f_id'");
    $order = mysqli_fetch_array($order);
    if (!empty($order)){
        $qty = $order['qty']+1;
        $query = mysqli_query($connect, "UPDATE orderss SET qty='$qty' WHERE f_id='$f_id' ");
    }
    else{
        $query = mysqli_query($connect, "INSERT INTO orderss(f_id, qty) value('$f_id','1') ");

    }
    redirect('index');

    
    
}



?>