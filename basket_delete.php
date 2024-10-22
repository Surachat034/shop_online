<?php

    require_once('connections/mysqli.php');

    session_start();

    if ($_SESSION == NULL) {
        header("location:login.php");
    }

    $basket_id = $_GET["basket_id"];
    $product_id = $_GET["product_id"];

    $strSQL = "SELECT * FROM product WHERE product_id = '".$product_id."'";
    $objQuery = mysqli_query($Connection,$strSQL);
    $objResult = mysqli_fetch_array($objQuery,MYSQLI_ASSOC);

    $strSQL2 = "SELECT * FROM basket WHERE basket_id = '".$basket_id."'";
    $objQuery2 = mysqli_query($Connection,$strSQL2);
    $objResult2 = mysqli_fetch_array($objQuery2,MYSQLI_ASSOC);

    $stock = $objResult["product_stock"] + $objResult2["basket_amount"];

    $strSQL3 = "UPDATE product SET product_stock = '".$stock."' WHERE product_id = '".$product_id."' ";
    $objQuery3 = mysqli_query($Connection,$strSQL3);

    $strSQL4 = "DELETE FROM basket WHERE basket_id = '".$basket_id."' ";
    $objQuery4 = mysqli_query($Connection,$strSQL4);

    header("location:basket.php");

    mysqli_close($Connection);

?>
