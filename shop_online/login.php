<?php

  require_once('connections/mysqli.php');

  session_start();

  if($_SESSION != NULL){
    header("location:index.php");
  }

  $strSQL = "SELECT * FROM shop_information";
  $objQuery = mysqli_query($Connection,$strSQL);
  $objResult = mysqli_fetch_array($objQuery,MYSQLI_ASSOC);

  if (isset($_POST["submit"])) {

    $strSQL2 = "SELECT * FROM member WHERE member_username = '".mysqli_real_escape_string($Connection, $_POST['member_username'])."'and member_password = '".mysqli_real_escape_string($Connection, $_POST['member_password'])."'";
    $objQuery2 = mysqli_query($Connection, $strSQL2);
    $objResult2 = mysqli_fetch_array($objQuery2, MYSQLI_ASSOC);

    if (!$objResult2) {
      echo "<center>";
      echo '<br><br><font size="+2">ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง กรุณาตรวจสอบใหม่อีกครั้ง !</font><br><br>';
      echo "<font size='+2'><a href='javascript:history.back()'>ย้อนกลับ</a></font>";
      echo "</center>";
      exit();
    }else{
      $_SESSION["member_username"] = $objResult2["member_username"];
      $_SESSION["member_level"] = $objResult2["member_level"];

      session_write_close();

      if ($objResult2["member_level"] == "admin") {
        header("location:admin/index.php");
      }else{
        header("location:index.php");
      }
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
  <ul>
    <li><a><?php echo $objResult['shop_information_name']; ?></a></li>
    <li><a href="index.php"><i class="fa fa-home"></i> หน้าแรก</a></li>
    <?php
    if ($_SESSION != NULL) {
    ?>
    <li><a href="profile.php"><i class="fa fa-id-card"></i> โปรไฟล์ส่วนตัว</a></li>
    <li><a href="order.php"><i class="fa fa-shopping-basket"></i> รายการสั่งชื้อของคุณ</a></li>
    <?php
    if ($_SESSION['member_level'] == "admin") {
    ?>
    <li><a href="admin/index.php"><i class="fa fa-cogs"></i> ระบบหลังบ้าน</a></li>
    <?php
    }
    ?>
    <li style="float:right"><a href="logout.php"><i class="fa fa-sign-out"></i> ออกจากระบบ</a></li>
    <?php
    }
    ?>
    <?php
    if ($_SESSION == NULL) {
    ?>
    <li style="float:right"><a href="register.php"><i class="fa fa-user-circle-o"></i> สมัครสมาชิก</a></li>
    <?php
    }
    ?>
  </ul>
  <div class="shop_div_5">
    <span class="shop_span_6"><i class="fa fa-id-card"></i> Login System</span>
    <form name="login" method="post">
      <input type="text" name="member_username" id="member_username" class="shop_input_1" placeholder="ชื่อผู้ใช้ / Username" required=""/>
      <input type="password" name="member_password" id="member_password" class="shop_input_1" placeholder="รหัสผ่าน / Password" required=""/>
      <input type="submit" name="submit" id="submit" class="shop_input_2" value="ล็อกอิน / Login"/>
    </form>
  </div>
  <hr>
  
  <?php mysqli_close($Connection); ?>
</body>
</html>
