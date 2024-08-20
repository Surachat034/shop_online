<?php

    require_once('connections/mysqli.php');

    session_start();

    $strSQL = "SELECT * FROM shop_information";
    $objQuery = mysqli_query($Connection,$strSQL);
    $objResult = mysqli_fetch_array($objQuery,MYSQLI_ASSOC);

    $strSQL10 = "SELECT * FROM category ORDER BY category_num ASC";
    $objQuery10 = mysqli_query($Connection,$strSQL10);

    $strSQL2 = "SELECT * FROM member WHERE member_username = '".$_SESSION['member_username']."' ";
    $objQuery2 = mysqli_query($Connection,$strSQL2);
    $objResult2 = mysqli_fetch_array($objQuery2,MYSQLI_ASSOC);

    if (isset($_POST["submit"])) {

      if ($_FILES["member_img"]["name"] != NULL) {

        $target_dir = "images/member/";
        $target_file = $target_dir . basename($_FILES["member_img"]["name"]);

        move_uploaded_file($_FILES["member_img"]["tmp_name"], $target_file);

        $strSQL3 = "UPDATE member SET member_password = '".$_POST["member_password"]."' , member_name = '".$_POST["member_name"]."' , member_email = '".$_POST["member_email"]."' , member_address = '".$_POST["member_address"]."' , member_address2 = '".$_POST["member_address2"]."' , member_tel = '".$_POST["member_tel"]."' , member_img = '".$_FILES["member_img"]["name"]."' WHERE member_username = '".$_SESSION['member_username']."' ";
        $objQuery3 = mysqli_query($Connection,$strSQL3);

        header("location:profile.php");

      }else{

        $strSQL3 = "UPDATE member SET member_password = '".$_POST["member_password"]."' , member_name = '".$_POST["member_name"]."' , member_email = '".$_POST["member_email"]."' , member_address = '".$_POST["member_address"]."' , member_address2 = '".$_POST["member_address2"]."', member_tel = '".$_POST["member_tel"]."' WHERE member_username = '".$_SESSION['member_username']."' ";
        $objQuery3 = mysqli_query($Connection,$strSQL3);

        header("location:profile.php");

      }

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
  <div class="shop_div_2">
    <span class="shop_span_7">ข้อมูลผู้ใช้ของ : <?php echo $objResult2["member_username"]; ?></span>
    <form name="profile_edit" method="post" enctype="multipart/form-data">
      <div class="shop_div_5">
        <span class="shop_span_8">รหัสผ่าน</span>
        <input type="text" name="member_password" id="member_password" class="shop_input_1" value="<?php echo $objResult2["member_password"]; ?>"/>
        <span class="shop_span_8">ชื่อ - นามสกุล</span>
        <input type="text" name="member_name" id="member_name" class="shop_input_1" value="<?php echo $objResult2["member_name"]; ?>"/>
        <span class="shop_span_8">อีเมล์</span>
        <input type="text" name="member_email" id="member_email" class="shop_input_1" value="<?php echo $objResult2["member_email"]; ?>"/>
        <span class="shop_span_8">ที่อยู่</span>
        <textarea name="member_address" id="member_address" class="shop_textarea_1"><?php echo $objResult2["member_address"]; ?></textarea>
        <span class="shop_span_8">ที่อยู่ที่2</span>
         <textarea name="member_address2" id="member_address2" class="shop_textarea_1"><?php echo $objResult2["member_address2"]; ?></textarea>
        <span class="shop_span_8">เบอร์โทรศัพท์</span>
        <input type="text" name="member_tel" id="member_tel" class="shop_input_1" value="<?php echo $objResult2["member_tel"]; ?>"/>
        <span class="shop_span_8">รูปภาพ</span>
        <input type="file" name="member_img" id="member_img" class="shop_input_3"/>
        <input type="submit" name="submit" id="submit" class="shop_input_4" value="บันทึกข้อมูล"/>
      </div>
    </form>
  </div>
  <hr>
  <?php include 'includes/footer.php';?>
  <?php mysqli_close($Connection); ?>
</body>
</html>
