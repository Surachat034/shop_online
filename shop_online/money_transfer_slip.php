<?php

    require_once('connections/mysqli.php');

    session_start();

    if ($_SESSION == NULL) {
        header("location:login.php");
    }

    $strSQL = "SELECT * FROM shop_information";
    $objQuery = mysqli_query($Connection,$strSQL);
    $objResult = mysqli_fetch_array($objQuery,MYSQLI_ASSOC);

    $strSQL10 = "SELECT * FROM category ORDER BY category_num ASC";
    $objQuery10 = mysqli_query($Connection,$strSQL10);

    $order_id = null;

    if(isset($_GET["order_id"])){
        $order_id = $_GET["order_id"];
    }

    $strSQL2 = "SELECT * FROM order_list WHERE order_id = '".$order_id."'";
    $objQuery2 = mysqli_query($Connection,$strSQL2);
    $objResult2 = mysqli_fetch_array($objQuery2,MYSQLI_ASSOC);

    if(isset($_POST["submit"])){

      $target_dir = "images/money_transfer_slip/";
      $target_file = $target_dir . basename($_FILES["order_img"]["name"]);

      move_uploaded_file($_FILES["order_img"]["tmp_name"], $target_file);

      $strSQL3 = "UPDATE order_list SET order_img = '".$_FILES["order_img"]["name"]."' , order_status = 'อยู่ระหว่างการตรวจหลักฐาน' WHERE order_id = '".$_POST["order_id"]."' ";
      $objQuery3 = mysqli_query($Connection,$strSQL3);

      header("location:money_transfer_slip.php?order_id=$order_id");
      exit();
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?php echo $objResult["shop_information_title"] ?></title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="assets/css/body.css">
  <link rel="stylesheet" type="text/css" href="assets/css/navigationbar.css">
  <link rel="stylesheet" type="text/css" href="assets/css/shop.css">
</head>
<body>
  <?php include 'includes/navbar.php';?>
  <div class="shop_div_8">
    <form name="money_transfer_slip" method="post" enctype="multipart/form-data">
      <span class="shop_span_8">ส่งหลักฐานการโอนเงิน</span>
      <input type="file" name="order_img" id="order_img" class="shop_input_3" required="">
      <input type="submit" name="submit" id="submit" class="shop_input_2" value="ส่งหลักฐาน"/>
      <input type="hidden" name="order_id" id="order_id" value="<?php echo $objResult2["order_id"];?>">
    </form>
  </div>
  <div class="shop_div_9">
    <?php
    if ($objResult2["order_img"] == "ยังไม่ได้ส่งหลักฐานการโอนเงิน") {
      echo "ยังไม่ได้ส่งหลักฐานการโอนเงิน";
    }else{
    ?>
    <img class="shop_img_1" src="images/money_transfer_slip/<?php echo $objResult2["order_img"]; ?>" width="100%" height="800px"/>
    <?php
    }
    ?>
  </div>
  <hr>
  <?php include 'includes/footer.php';?>
  <?php mysqli_close($Connection); ?>
</body>
</html>
