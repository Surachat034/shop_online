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

    $category_id = $_GET["category_id"];
    $strSQL = "DELETE FROM category WHERE category_id = '".$category_id."' ";
    $objQuery = mysqli_query($Connection,$strSQL);

    if (mysqli_affected_rows($Connection)) {
        header("location:category.php");
        exit();
    }

    mysqli_close($Connection);

?>
