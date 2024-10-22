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

    $strSQL2 = "SELECT * FROM category ORDER BY category_num ASC";
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
    <span class="shop_span_7_2">ข้อมูลหมวดหมู่สินค้าทั้งหมด <a class="shop_a_5" href="category_add.php">เพิ่มหมวดหมู่สินค้า <i class="fa fa-plus-circle"></i></a></span>
    <table class="shop_table_1">
      <tr>
        <td bgcolor="#33CCFF">ลำดับที่</td>
        <td bgcolor="#33CCFF">ชื่อหมวดหมู่</td>
        <td bgcolor="#33CCFF" width="60px">ตัวเลือก</td>
      </tr>
      <?php
      while ($objResult2 = mysqli_fetch_array($objQuery2,MYSQLI_ASSOC)) {
      ?>
      <tr>
        <td valign="top"><?php echo $objResult2["category_num"];?></td>
        <td valign="top"><?php echo $objResult2["category_name"];?></td>
        <td valign="top"><a class="shop_a_3" href="category_edit.php?category_id=<?php echo $objResult2["category_id"];?>"><i class="fa fa-pencil-square"></i></a> , <a class="shop_a_3" href="JavaScript:if(confirm('คุณต้องการลบข้อมูลใช่หรือไม่')==true){window.location='category_delete.php?category_id=<?php echo $objResult2["category_id"];?>';}"><i class="fa fa-trash"></i></a></td>
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