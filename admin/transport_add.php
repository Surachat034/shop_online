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

      $strSQL2 = "INSERT INTO transport (transport_name,transport_price) VALUES ('".$_POST["transport_name"]."','".$_POST["transport_price"]."')";
      $objQuery2 = mysqli_query($Connection,$strSQL2);

      header("location:transport.php");

    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
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
    <span class="shop_span_7">เพิ่มการขนส่งสินค้าใหม่</span>
    <form name="transport_add" method="post">
      <div class="shop_div_5_1">
        <span class="shop_span_8">ขนส่ง (บริษัท)</span>
        <input type="text" name="transport_name" id="transport_name" class="shop_input_1" required=""/>
        <span class="shop_span_8">ราคาขนส่ง</span>
        <input type="text" name="transport_price" id="transport_price" class="shop_input_1" required=""/>
        <input type="submit" name="submit" id="submit" class="shop_input_4" value="บันทึกสินค้า"/>
      </div>
    </form>
  </div>
  <hr>
  <?php include '../includes/footer.php';?>
  <?php mysqli_close($Connection); ?>
</body>
</html>
