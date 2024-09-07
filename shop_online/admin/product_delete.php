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

    $product_id = $_GET["product_id"];
    $strSQL = "DELETE FROM product WHERE product_id = '".$product_id."' ";
    $objQuery = mysqli_query($Connection,$strSQL);

    if (mysqli_affected_rows($Connection)) {
        header("location:product.php");
        exit();
    }

    mysqli_close($Connection);

?>
