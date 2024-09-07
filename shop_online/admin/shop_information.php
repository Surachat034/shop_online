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

      if ($_FILES["shop_information_logo"]["name"] != NULL) {

        $target_dir = "../images/shop_information/";
        $target_file = $target_dir . basename($_FILES["shop_information_logo"]["name"]);

        move_uploaded_file($_FILES["shop_information_logo"]["tmp_name"], $target_file);

        $strSQL3 = "UPDATE shop_information SET shop_information_name = '".$_POST["shop_information_name"]."' , shop_information_email = '".$_POST["shop_information_email"]."' , shop_information_address = '".$_POST["shop_information_address"]."' , shop_information_tel = '".$_POST["shop_information_tel"]."' , shop_information_logo = '".$_FILES["shop_information_logo"]["name"]."' WHERE shop_information_id = '".$_POST["shop_information_id"]."' ";
        $objQuery3 = mysqli_query($Connection,$strSQL3);

        header("location:shop_information.php");

      }else{

        $strSQL3 = "UPDATE shop_information SET shop_information_name = '".$_POST["shop_information_name"]."' , shop_information_email = '".$_POST["shop_information_email"]."' , shop_information_address = '".$_POST["shop_information_address"]."' , shop_information_tel = '".$_POST["shop_information_tel"]."' WHERE shop_information_id = '".$_POST["shop_information_id"]."' ";
        $objQuery3 = mysqli_query($Connection,$strSQL3);

        header("location:shop_information.php");

      }

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
<body> <!--
  <?php include '../includes/navbar_admin.php';?>
  <div class="shop_div_2">
    <span class="shop_span_7">ข้อมูลร้าน : <?php echo $objResult["shop_information_name"]; ?></span>
    <form name="shop_information" method="post" enctype="multipart/form-data">
      <div class="shop_div_5_1">
        <span class="shop_span_8">ชื่อร้านค้า</span>
        <input type="text" name="shop_information_name" id="shop_information_name" class="shop_input_1" value="<?php echo $objResult["shop_information_name"]; ?>"/>
        <span class="shop_span_8">อีเมล์</span>
        <input type="text" name="shop_information_email" id="shop_information_email" class="shop_input_1" value="<?php echo $objResult["shop_information_email"]; ?>"/>
        <span class="shop_span_8">ที่อยู่</span>
        <textarea name="shop_information_address" id="shop_information_address" class="shop_textarea_1"><?php echo $objResult["shop_information_address"]; ?></textarea>
        <span class="shop_span_8">เบอร์โทรศัพท์</span>
        <input type="text" name="shop_information_tel" id="shop_information_tel" class="shop_input_1" value="<?php echo $objResult["shop_information_tel"]; ?>"/>
        <span class="shop_span_8">โลโก้</span>
        <input type="file" name="shop_information_logo" id="shop_information_logo" class="shop_input_3"/>
        <input type="submit" name="submit" id="submit" class="shop_input_4" value="บันทึกข้อมูล"/>
      </div>
      <input type="hidden" name="shop_information_id" id="shop_information_id" value="<?php echo $objResult["shop_information_id"];?>">
    </form>
  </div>
  <hr> -->
  <?php include '../includes/footer.php';?>
  <?php mysqli_close($Connection); ?>
</body>
</html>
