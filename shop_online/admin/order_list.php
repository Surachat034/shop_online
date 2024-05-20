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

    $strSQL2 = "SELECT * FROM order_list INNER JOIN (member,product) ON (order_list.member_id = member.member_id AND order_list.product_id = product.product_id)";
    $objQuery2 = mysqli_query($Connection,$strSQL2);

    $strSQL2 .= "ORDER BY order_id DESC";
    $objQuery2 = mysqli_query($Connection,$strSQL2);

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
    <span class="shop_span_7_2">ข้อมูลการสั่งชื้อสินค้าทั้งหมด</span>
    <table class="shop_table_1">
      <tr>
        <td bgcolor="#33CCFF">ลำดับ</td>
        <td bgcolor="#33CCFF">รหัสสินค้า</td>
        <td bgcolor="#33CCFF">ชื่อผู้ใช้</td>
        <td bgcolor="#33CCFF">จำนวนที่สั่งซื้อ</td>
        <td bgcolor="#33CCFF">รวมเป็นเงิน</td>
        <td bgcolor="#33CCFF">วันเวลาที่สั่งซื้อ</td>
        <td bgcolor="#33CCFF">สถานะการสั่งซื้อ</td>
        <td bgcolor="#33CCFF">ยืนยันการสั่งซื้อ</td>
        <td bgcolor="#33CCFF" width="60px">ตัวเลือก</td>
      </tr>
      <?php
      while ($objResult2 = mysqli_fetch_array($objQuery2,MYSQLI_ASSOC)) {
      ?>
      <tr>
        <td><?php echo $objResult2["order_id"];?></td>
        <td><?php echo $objResult2["product_code"];?></td>
        <td><?php echo $objResult2["member_username"];?></td>
        <td><?php echo $objResult2["order_amount"];?></td>
        <td><?php echo $objResult2["product_price"] * $objResult2["order_amount"]; ?> บาท</td>
        <td><?php echo $objResult2["order_date"];?></td>
        <td>
          <?php
          if ($objResult2["order_status"] == 'อยู่ระหว่างรอการส่งหลักฐานการโอนเงิน') {
            echo "อยู่ระหว่างรอการส่งหลักฐานการโอนเงิน";
          }elseif ($objResult2["order_status"] == 'อยู่ระหว่างการตรวจหลักฐาน') {
            ?>
            <span>อยู่ระหว่างการตรวจหลักฐาน <a class="shop_a_4" target="_blank" href="../images/money_transfer_slip/<?php echo $objResult2["order_img"]; ?>">ตรวจหลักฐาน</a></span>
            <?php
          }elseif ($objResult2["order_status"] == 'อยู่ระหว่างจัดส่งสินค้า') {
            ?>
            <span>อยู่ระหว่างจัดส่งสินค้า <a class="shop_a_4" href="order_list_member.php?member_id=<?php echo $objResult2["member_id"];?>">ข้อมูลลูกค้า</a></span>
            <?php
          }
          ?>
        </td>
        <td><a class="shop_a_5" href="JavaScript:if(confirm('คุณแน่ใจใช่หรือไม่')==true){window.location='order_list_past.php?order_id=<?php echo $objResult2["order_id"];?>';}"><i class="fa fa-check"></i></a></td>
        <td><a class="shop_a_3" href="JavaScript:if(confirm('คุณต้องการลบข้อมูลใช่หรือไม่')==true){window.location='order_list_delete.php?order_id=<?php echo $objResult2["order_id"];?>&product_id=<?php echo $objResult2["product_id"];?>';}"><i class="fa fa-trash"></i></a></td>
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
