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
    $order_ordernumber = $_GET["order_ordernumber"];

    $strSQL = "SELECT * FROM basket WHERE order_ordernumber = '".$order_ordernumber."'";
    $objQuery = mysqli_query($Connection,$strSQL);

    while ($objResult = mysqli_fetch_array($objQuery,MYSQLI_ASSOC)) {

        $strSQL2 = "SELECT * FROM product WHERE product_id = '".$objResult["product_id"]."'";
        $objQuery2 = mysqli_query($Connection,$strSQL2);
        $objResult2 = mysqli_fetch_array($objQuery2,MYSQLI_ASSOC);

        $stock = $objResult2["product_stock"] + $objResult["basket_amount"];

        $strSQL3 = "UPDATE product SET product_stock = '".$stock."' WHERE product_id = '".$objResult["product_id"]."' ";
        $objQuery3 = mysqli_query($Connection,$strSQL3);

        $strSQL4 = "DELETE FROM basket WHERE basket_id = '".$objResult["basket_id"]."' ";
        $objQuery4 = mysqli_query($Connection,$strSQL4);

    }

    $strSQL5 = "DELETE FROM order_list WHERE order_id = '".$order_id."' ";
    $objQuery5 = mysqli_query($Connection,$strSQL5);

    header("location:order_list.php");

    mysqli_close($Connection);

?>
