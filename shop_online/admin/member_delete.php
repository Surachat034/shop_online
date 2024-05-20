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

    $member_id = $_GET["member_id"];
    $strSQL = "DELETE FROM member WHERE member_id = '".$member_id."' ";
    $objQuery = mysqli_query($Connection,$strSQL);

    if (mysqli_affected_rows($Connection)) {
        header("location:member.php");
        exit();
    }

    mysqli_close($Connection);

?>
