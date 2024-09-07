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

    $transport_id = $_GET["transport_id"];
    $strSQL = "DELETE FROM transport WHERE transport_id = '".$transport_id."' ";
    $objQuery = mysqli_query($Connection,$strSQL);

    if (mysqli_affected_rows($Connection)) {
        header("location:transport.php");
        exit();
    }

    mysqli_close($Connection);

?>
