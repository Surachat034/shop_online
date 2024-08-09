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

    $strSQL2 = "SELECT * FROM member WHERE member_username = '".$_SESSION['member_username']."' ";
    $objQuery2 = mysqli_query($Connection,$strSQL2);
    $objResult2 = mysqli_fetch_array($objQuery2,MYSQLI_ASSOC);

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
    <span class="shop_span_7">โปรไฟล์ข้อมูลส่วนตัวของคุณ</span>
    <table align="center" cellpadding="10">
      <tr>
        <td valign="top">
          <img src="images/member/<?php echo $objResult2["member_img"];?>" class="shop_img_1" width="300px" height="300px">
        </td>
        <td align="left" valign="top">
          <p class="shop_p_3">ชื่อผู้ใช้ : <?php echo $objResult2["member_username"]; ?></p>
          <p class="shop_p_3">รหัสผ่าน : <?php echo $objResult2["member_password"]; ?></p>
          <p class="shop_p_3">ชื่อ - นามสกุล : <?php echo $objResult2["member_name"]; ?></p>
          <p class="shop_p_3">อีเมล์ : <?php echo $objResult2["member_email"]; ?></p>
          <p class="shop_p_3">ที่อยู่ : <?php echo nl2br($objResult2["member_address"]); ?></p>
          <p class="shop_p_3">เบอร์โทรศัพท์ : <?php echo $objResult2["member_tel"]; ?></p>
          <p class="shop_p_3">วันเวลาที่สมัครเป็นสมาชิก : <?php echo $objResult2["member_date"]; ?></p>
          <div class="shop_div_4">
            <a href="profile_edit.php"><button class="shop_button_2">แก้ไขข้อมูล</button></a>
          </div>
        </td>
      </tr>
    </table>
  </div>
  <hr>
  <?php include 'includes/footer.php';?>
  <?php mysqli_close($Connection); ?>
</body>
</html>
