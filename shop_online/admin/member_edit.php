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

    $member_id = null;

    if(isset($_GET["member_id"])){
        $member_id = $_GET["member_id"];
    }

    $strSQL2 = "SELECT * FROM member WHERE member_id = '".$member_id."' ";
    $objQuery2 = mysqli_query($Connection,$strSQL2);
    $objResult2 = mysqli_fetch_array($objQuery2,MYSQLI_ASSOC);

    if (isset($_POST["submit"])) {
      $strSQL3 = "UPDATE member SET member_username = '".$_POST["member_username"]."' , member_password = '".$_POST["member_password"]."' , member_name = '".$_POST["member_name"]."' , member_email = '".$_POST["member_email"]."' , member_address = '".$_POST["member_address"]."' , member_tel = '".$_POST["member_tel"]."' , member_level = '".$_POST["member_level"]."' WHERE member_id = '".$_POST["member_id"]."' ";
      $objQuery3 = mysqli_query($Connection,$strSQL3);

      header("location:member.php");
      exit();
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
    <span class="shop_span_7">ผู้ใช้ ID : <?php echo $objResult2["member_id"]; ?></span>
    <form name="profile_edit" method="post" enctype="multipart/form-data">
      <div class="shop_div_5">
        <span class="shop_span_8">ชื่อผู้ใช้</span>
        <input type="text" name="member_username" id="member_username" class="shop_input_1" value="<?php echo $objResult2["member_username"]; ?>"/>
        <span class="shop_span_8">รหัสผ่าน</span>
        <input type="text" name="member_password" id="member_password" class="shop_input_1" value="<?php echo $objResult2["member_password"]; ?>"/>
        <span class="shop_span_8">ชื่อ - นามสกุล</span>
        <input type="text" name="member_name" id="member_name" class="shop_input_1" value="<?php echo $objResult2["member_name"]; ?>"/>
        <span class="shop_span_8">อีเมล์</span>
        <input type="text" name="member_email" id="member_email" class="shop_input_1" value="<?php echo $objResult2["member_email"]; ?>"/>
        <span class="shop_span_8">ที่อยู่</span>
        <textarea name="member_address" id="member_address" class="shop_textarea_1"><?php echo $objResult2["member_address"]; ?></textarea>
        <span class="shop_span_8">เบอร์โทรศัพท์</span>
        <input type="text" name="member_tel" id="member_tel" class="shop_input_1" value="<?php echo $objResult2["member_tel"]; ?>"/>
        <span class="shop_span_8">ระดับ</span>
        <select name="member_level" id="member_level" class="shop_select_1">
          <option value="user" <?php if($objResult2["member_level"] == "user") echo 'selected="selected"'; ?>>User</option>
          <option value="admin" <?php if($objResult2["member_level"] == "admin") echo 'selected="selected"'; ?>>Admin</option>
        </select>
        <input type="submit" name="submit" id="submit" class="shop_input_4" value="บันทึกข้อมูล"/>
      </div>
      <input type="hidden" name="member_id" id="member_id" value="<?php echo $objResult2["member_id"];?>">
    </form>
  </div>
  <hr>
  <?php include '../includes/footer.php';?>
  <?php mysqli_close($Connection); ?>
</body>
</html>
