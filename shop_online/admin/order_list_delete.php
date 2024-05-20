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
    $product_id = $_GET["product_id"];

    $strSQL = "SELECT * FROM product WHERE product_id = '".$product_id."'";
    $objQuery = mysqli_query($Connection,$strSQL);
    $objResult = mysqli_fetch_array($objQuery,MYSQLI_ASSOC);

    $strSQL2 = "SELECT * FROM order_list WHERE order_id = '".$order_id."'";
    $objQuery2 = mysqli_query($Connection,$strSQL2);
    $objResult2 = mysqli_fetch_array($objQuery2,MYSQLI_ASSOC);

    $stock = $objResult["product_stock"] + $objResult2["order_amount"];

    $strSQL3 = "UPDATE product SET product_stock = '".$stock."' WHERE product_id = '".$product_id."' ";
    $objQuery3 = mysqli_query($Connection,$strSQL3);

    $strSQL4 = "DELETE FROM order_list WHERE order_id = '".$order_id."' ";
    $objQuery4 = mysqli_query($Connection,$strSQL4);

    header("location:order_list.php");

    mysqli_close($Connection);

?>
