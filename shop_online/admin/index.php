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

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title> <?php echo $objResult["shop_information_title"] ?></title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="../assets/css/body.css">
  <link rel="stylesheet" type="text/css" href="../assets/css/navigationbar.css">
  <link rel="stylesheet" type="text/css" href="../assets/css/shop.css">
</head>
<body>
  <?php include '../includes/navbar_admin.php';?>
  <div class="shop_div_10">
    <span class="shop_span_7">ระบบหลังบ้าน Admin</span>
  </div>
  <div class="shop_div_10">
    <div class="shop_div_10_1">
      <span class="shop_span_9">หมวดหมู่ -> จัดการข้อมูล<i class="fa fa-shopping-basket"></i></span>
      
      <span class="shop_span_9_1"><a class="shop_a_6" href="product.php"><i class="fa fa-angle-double-right"></i> ข้อมูลสินค้า</a></span>
     
      <span class="shop_span_9_1"><a class="shop_a_6" href="category.php"><i class="fa fa-angle-double-right"></i> ข้อมูลหมวดหมู่สินค้า</a></span>
      
    </div>
    <div class="shop_div_10_1">
      <span class="shop_span_9">หมวดหมู่ -> จัดการการสั่งซื่อสินค้า <i class="fa fa-shopping-basket"></i></span>
      
    
      <span class="shop_span_9_1"><a class="shop_a_6" href="order_list.php"><i class="fa fa-angle-double-right"></i> รายการสั่งชื้อสินค้าทั้งหมด</a></span>
    </div>
    <div class="shop_div_10_1">
      <span class="shop_span_9">หมวดหมู่ -> จัดการข้อมูลทั่วไป <i class="fa fa-id-card"></i></span>
      <span class="shop_span_9_1"><a class="shop_a_6" href="member.php"><i class="fa fa-angle-double-right"></i> ข้อมูลสมาชิก</a></span>
      <span class="shop_span_9_1"><a class="shop_a_6" href="payment.php"><i class="fa fa-angle-double-right"></i> ข้อมูลธนาคารชำระเงิน</a></span>
      <span class="shop_span_9_1"><a class="shop_a_6" href="transport.php"><i class="fa fa-angle-double-right"></i> ข้อมูลบริษัทจัดส่งสินค้า</a></span>
    </div>
    
   
   
  </div>
  <hr>
  <?php include '../includes/footer.php';?>
  <?php mysqli_close($Connection); ?>
</body>
</html>
