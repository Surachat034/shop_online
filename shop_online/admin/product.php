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

    $strSQL2 = "SELECT * FROM product INNER JOIN category ON product.category_id = category.category_id";
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
    <span class="shop_span_7_2">ข้อมูลสินค้าทั้งหมด <a class="shop_a_5" href="product_add.php">เพิ่มสินค้า <i class="fa fa-plus-circle"></i></a></span>
    <table class="shop_table_1">
      <tr>
        <td bgcolor="#33CCFF">ลำดับ</td>
        <td bgcolor="#33CCFF">รหัสสินค้า</td>
        <td bgcolor="#33CCFF">หมวดหมู่</td>
        <td bgcolor="#33CCFF">ชื่อสินค้า</td>
        <td bgcolor="#33CCFF">รายละเอียดสินค้า</td>
        <td bgcolor="#33CCFF" width="40px">รูปที่ 1</td>
        <td bgcolor="#33CCFF" width="40px">รูปที่ 2</td>
        <td bgcolor="#33CCFF" width="40px">รูปที่ 3</td>
        <td bgcolor="#33CCFF" width="40px">รูปที่ 4</td>
        <td bgcolor="#33CCFF">ราคาสินค้า</td>
        <td bgcolor="#33CCFF">สต๊อก</td>
        <td bgcolor="#33CCFF" width="60px">ตัวเลือก</td>
      </tr>
      <?php
      while ($objResult2 = mysqli_fetch_array($objQuery2,MYSQLI_ASSOC)) {
      ?>
      <tr>
        <td valign="top"><?php echo $objResult2["product_id"];?></td>
        <td valign="top"><?php echo $objResult2["product_code"];?></td>
        <td valign="top"><?php echo $objResult2["category_name"];?></td>
        <td valign="top"><?php echo $objResult2["product_name"];?></td>
        <td align="left" valign="top"><?php echo nl2br($objResult2["product_detail"]);?></td>
        <td valign="top">
          <?php
          if ($objResult2["product_img1"] == NULL) {
            echo "ว่าง";
          }else{
          ?>
          <a class="shop_a_4" href="../images/product/<?php echo $objResult2["product_img1"];?>" target="_blank"><i class="fa fa-camera-retro"></i></a>
          <?php
          }
          ?>
        </td>
        <td valign="top">
          <?php
          if ($objResult2["product_img2"] == NULL) {
            echo "ว่าง";
          }else{
          ?>
          <a class="shop_a_4" href="../images/product/<?php echo $objResult2["product_img2"];?>" target="_blank"><i class="fa fa-camera-retro"></i></a>
          <?php
          }
          ?>
        </td>
        <td valign="top">
          <?php
          if ($objResult2["product_img3"] == NULL) {
            echo "ว่าง";
          }else{
          ?>
          <a class="shop_a_4" href="../images/product/<?php echo $objResult2["product_img3"];?>" target="_blank"><i class="fa fa-camera-retro"></i></a>
          <?php
          }
          ?>
        </td>
        <td valign="top">
          <?php
          if ($objResult2["product_img4"] == NULL) {
            echo "ว่าง";
          }else{
          ?>
          <a class="shop_a_4" href="../images/product/<?php echo $objResult2["product_img4"];?>" target="_blank"><i class="fa fa-camera-retro"></i></a>
          <?php
          }
          ?>
        </td>
        <td valign="top"><?php echo $objResult2["product_price"];?> บาท</td>
        <td valign="top"><?php echo $objResult2["product_stock"];?></td>
        <td valign="top"><a class="shop_a_3" href="product_edit.php?product_id=<?php echo $objResult2["product_id"];?>"><i class="fa fa-pencil-square"></i></a> , <a class="shop_a_3" href="JavaScript:if(confirm('คุณต้องการลบข้อมูลใช่หรือไม่')==true){window.location='product_delete.php?product_id=<?php echo $objResult2["product_id"];?>';}"><i class="fa fa-trash"></i></a></td>
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
