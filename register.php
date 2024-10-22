<?php

  require_once('connections/mysqli.php');

  session_start();

  if($_SESSION != NULL){
    header("location:index.php");
  }

  $strSQL = "SELECT * FROM shop_information";
  $objQuery = mysqli_query($Connection,$strSQL);
  $objResult = mysqli_fetch_array($objQuery,MYSQLI_ASSOC);

  $strSQL10 = "SELECT * FROM category ORDER BY category_num ASC";
  $objQuery10 = mysqli_query($Connection,$strSQL10);

  if(isset($_POST["submit"])){

    $strSQL1 = "SELECT * FROM member WHERE member_username = '".trim($_POST['member_username'])."'";
    $objQuery1 = mysqli_query($Connection,$strSQL1);
    $objResult1 = mysqli_fetch_array($objQuery1,MYSQLI_ASSOC);

    if($objResult1){
      echo "<center>";
      echo '<br><br><font size="+2">ชื่อผู้ใช้ : นี้มีผู้ใช้แล้ว กรุณากรอก ชื่อผู้ใช้ ใหม่</font><br><br>';
      echo "<font size='+2'><a href='javascript:history.back()'>ย้อนกลับ</a></font>";
      echo "</center>";
      exit();
    }else{
      $strSQL1 = "INSERT INTO member (member_username,member_password,member_name,member_email,member_address,member_tel,member_img,member_date) VALUES ('".$_POST["member_username"]."','".$_POST["member_password"]."','".$_POST["member_name"]."','".$_POST["member_email"]."','".$_POST["member_address"]."','".$_POST["member_tel"]."','".$_POST["member_img"]."','".$_POST["member_date"]."')";
      $objQuery1 = mysqli_query($Connection,$strSQL1);

      echo "<center>";
      echo '<br><br><font size="+2">สมัครสมาชิกสำเร็จ</font><br><br>';
      echo "<font size='+2'><a href='login.php'>เข้าสู่ระบบ</a></font>";
      echo "</center>";
      exit();
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
  <div class="shop_div_5">
    <span class="shop_span_6"><i class="fa fa-id-card"></i> Register System</span>
    <form name="register" method="post">
      <input type="text" name="member_username" id="member_username" class="shop_input_1" placeholder="ชื่อผู้ใช้ / Username" required=""/>
      <input type="password" name="member_password" id="member_password" class="shop_input_1" placeholder="รหัสผ่าน / Password" required=""/>
      <input type="text" name="member_name" id="member_name" class="shop_input_1" placeholder="ชื่อ - นามสกุล / Myname" required=""/>
      <input type="text" name="member_email" id="member_email" class="shop_input_1" placeholder="อีเมล์ / Email" required=""/>
      <textarea name="member_address" id="member_address" class="shop_textarea_1" placeholder="ที่อยู่ / Address" required=""></textarea>
      <input type="text" name="member_tel" id="member_tel" class="shop_input_1" placeholder="เบอร์โทรศัพท์ / Tel." required=""/>
      <input type="submit" name="submit" id="submit" class="shop_input_2" value="สมัครสมาชิก / Signup"/>
      <input type="hidden" name="member_img" id="member_img" value="<?php echo "default.png";?>">
      <input type="hidden" name="member_date" id="member_date" value="<?php echo date('Y-m-d H:i:s');?>">
    </form>
  </div>
  <hr>
  <?php include 'includes/footer.php';?>
  <?php mysqli_close($Connection); ?>
</body>
</html>
