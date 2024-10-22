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

    $strSQL = "SELECT * FROM shop_information";
    $objQuery = mysqli_query($Connection,$strSQL);
    $objResult = mysqli_fetch_array($objQuery,MYSQLI_ASSOC);

    $strSQL10 = "SELECT * FROM category ORDER BY category_num ASC";
    $objQuery10 = mysqli_query($Connection,$strSQL10);

    if (isset($_POST["submit"])) {

      $strSQL2 = "UPDATE shop_information SET shop_information_title = '".$_POST["shop_information_title"]."' WHERE shop_information_id = '".$_POST["shop_information_id"]."'";
      $objQuery2 = mysqli_query($Connection,$strSQL2);

      header("location:title.php");

    }

?>
<!DOCTYPE html>
<html lang="en">
<head><!--
  <meta charset="UTF-8">
  <title><?php echo $objResult["shop_information_title"] ?></title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="../assets/css/body.css">
  <link rel="stylesheet" type="text/css" href="../assets/css/navigationbar.css">
  <link rel="stylesheet" type="text/css" href="../assets/css/shop.css">
</head>
<body>
  <?php include '../includes/navbar_admin.php';?>
  <div class="shop_div_2">
    <span class="shop_span_7">กำหนด Title ร้าน : <?php echo $objResult["shop_information_name"]; ?></span>
    <form name="title" method="post">
      <div class="shop_div_5_1">
        <span class="shop_span_8">Title เว็บไซต์</span>
        <input type="text" name="shop_information_title" id="shop_information_title" class="shop_input_1" value="<?php echo $objResult["shop_information_title"]; ?>"/>
        <input type="submit" name="submit" id="submit" class="shop_input_4" value="บันทึกข้อมูล"/>
      </div>
      <input type="hidden" name="shop_information_id" id="shop_information_id" value="<?php echo $objResult["shop_information_id"];?>">
    </form>
  </div>-->
</body>
  <hr>
  <?php include '../includes/footer.php';?>
  <?php mysqli_close($Connection); ?>  
</html>
