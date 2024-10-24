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

    $strSQL2 = "SELECT * FROM member";
    $objQuery2 = mysqli_query($Connection,$strSQL2);

    $strSQL10 = "SELECT * FROM category ORDER BY category_num ASC";
    $objQuery10 = mysqli_query($Connection,$strSQL10);

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
  <div class="shop_div_10">
    <span class="shop_span_7_2">ข้อมูลสมาชิกทั้งหมด</span>
    <table class="shop_table_1">
      <tr>
        <td bgcolor="#33CCFF">ลำดับ</td>
        <td bgcolor="#33CCFF">ชื่อผู้ใช้</td>
        <td bgcolor="#33CCFF">รหัสผ่าน</td>
        <td bgcolor="#33CCFF">ชื่อ - นามสกุล</td>
        <td bgcolor="#33CCFF">อีเมล์</td>
        <td bgcolor="#33CCFF">ที่อยู่</td>
        <td bgcolor="#33CCFF">ที่อยู่ที่2</td>
        <td bgcolor="#33CCFF">เบอร์โทรศัพท์</td>
        <td bgcolor="#33CCFF">รูปภาพ</td>
        <td bgcolor="#33CCFF">วันเวลาที่สมัครเป็นสมาชิก</td>
        <td bgcolor="#33CCFF">ระดับ</td>
        <td bgcolor="#33CCFF">ตัวเลือก</td>
      </tr>
      <?php
      while ($objResult2 = mysqli_fetch_array($objQuery2,MYSQLI_ASSOC)) {
      ?>
      <tr>
        <td><?php echo $objResult2["member_id"];?></td>
        <td><?php echo $objResult2["member_username"];?></td>
        <td><?php echo $objResult2["member_password"];?></td>
        <td><?php echo $objResult2["member_name"];?></td>
        <td><?php echo $objResult2["member_email"];?></td>
        <td><?php echo nl2br($objResult2["member_address"]);?></td>
        <td><?php echo nl2br($objResult2["member_address2"]);?></td>
        <td><?php echo $objResult2["member_tel"];?></td>
        <td><a class="shop_a_4" href="../images/member/<?php echo $objResult2["member_img"]; ?>" target="_blank"><i class="fa fa-camera-retro"></i></a></td>
        <td><?php echo $objResult2["member_date"];?></td>
        <td><?php echo $objResult2["member_level"];?></td>
        <td><a class="shop_a_3" href="member_edit.php?member_id=<?php echo $objResult2["member_id"];?>"><i class="fa fa-pencil-square"></i></a> , <a class="shop_a_3" href="JavaScript:if(confirm('คุณต้องการลบข้อมูลใช่หรือไม่')==true){window.location='member_delete.php?member_id=<?php echo $objResult2["member_id"];?>';}"><i class="fa fa-trash"></i></a></td>
      </tr>
      <?php
      }
      ?>
    </table>
  </div>
  <hr>
  <?php include '../includes/footer.php';?>
  <?php mysqli_close($Connection); ?>
</body>
</html>
