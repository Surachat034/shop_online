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

    $product_img1 = $_GET["product_img1"];
    $product_img2 = $_GET["product_img2"];
    $product_img3 = $_GET["product_img3"];
    $product_img4 = $_GET["product_img4"];

    if ($product_img1 != NULL) {
        $strSQL = "UPDATE product SET product_img1 = NULL WHERE product_id = '".$product_id."' ";
        $objQuery = mysqli_query($Connection,$strSQL);
    }

    if ($product_img2 != NULL) {
        $strSQL = "UPDATE product SET product_img2 = NULL WHERE product_id = '".$product_id."' ";
        $objQuery = mysqli_query($Connection,$strSQL);
    }

    if ($product_img3 != NULL) {
        $strSQL = "UPDATE product SET product_img3 = NULL WHERE product_id = '".$product_id."' ";
        $objQuery = mysqli_query($Connection,$strSQL);
    }

    if ($product_img4 != NULL) {
        $strSQL = "UPDATE product SET product_img4 = NULL WHERE product_id = '".$product_id."' ";
        $objQuery = mysqli_query($Connection,$strSQL);
    }

    header("location:product_edit.php?product_id=$product_id");

    mysqli_close($Connection);

?>
