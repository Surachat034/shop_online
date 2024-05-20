<?php

    require_once('../connections/mysqli.php');

    session_start();

    if($_SESSION == NULL){
        header("location:../login.php");
        exit();
    }

    if($_SESSION['member_level'] != "admin")
    {
        header("location:../index.php");
        exit();
    }

    $order_id = $_GET["order_id"];

    $strSQL = "UPDATE order_list SET order_status = 'อยู่ระหว่างจัดส่งสินค้า' WHERE order_id = '".$order_id."' ";
    $objQuery = mysqli_query($Connection,$strSQL);

    header("location:order_list.php");

    mysqli_close($Connection);

?>
