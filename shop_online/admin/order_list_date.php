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

    $total = 0;

    $strSQL = "SELECT * FROM shop_information";
    $objQuery = mysqli_query($Connection,$strSQL);
    $objResult = mysqli_fetch_array($objQuery,MYSQLI_ASSOC);

    $strSQL10 = "SELECT * FROM category ORDER BY category_num ASC";
    $objQuery10 = mysqli_query($Connection,$strSQL10);

    $strSQL2 = "SELECT * FROM order_list INNER JOIN (member,transport) ON (order_list.member_id = member.member_id AND order_list.transport_id = transport.transport_id) WHERE order_date >= '".$_POST["startdate"]."' and order_date <= '".date($_POST["enddate"]." 23:59:00")."'";
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
    <span class="shop_span_7_2">ข้อมูลการสั่งชื้อสินค้าวันที่ <?php echo $_POST["startdate"]; ?> ถึง <?php echo $_POST["enddate"]; ?></span>
    <div class="shop_div_4_1">
      <a href="order_list.php"><button class="shop_button_3">ย้อนกลับ</button></a>
    </div>
    <table class="shop_table_1">
      <tr>
        <td bgcolor="#33CCFF">เลขออเดอร์</td>
        <td bgcolor="#33CCFF">วันเวลาที่สั่งชื้อ</td>
        <td bgcolor="#33CCFF">ชื่อผู้ใช้ (ผู้ชื้อ)</td>
        <td bgcolor="#33CCFF">จัดส่ง</td>
        <td bgcolor="#33CCFF">รวมเป็นเงิน</td>
        <td bgcolor="#33CCFF">สถานะการสั่งซื้อ</td>
        <td bgcolor="#33CCFF">ยืนยันการสั่งซื้อ</td>
        <td bgcolor="#33CCFF">รายละเอียด</td>
        <td bgcolor="#33CCFF" width="60px">ตัวเลือก</td>
      </tr>
      <?php
      while ($objResult2 = mysqli_fetch_array($objQuery2,MYSQLI_ASSOC)) {
      ?>
      <tr>
        <td><?php echo $objResult2["order_ordernumber"];?></td>
        <td><?php echo $objResult2["order_date"];?></td>
        <td><?php echo $objResult2["member_username"];?></td>
        <td><?php echo $objResult2["transport_name"]." ค่าจัดส่ง ".$objResult2["transport_price"]." บาท"; ?></td>
        <td><?php echo $objResult2["order_price"] + $objResult2["transport_price"]." บาท";?></td>
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
        <td><a class="shop_a_5" href="../order_view.php?order_ordernumber=<?php echo $objResult2["order_ordernumber"];?>"><i class="fa fa-eye"></i></a></td>
        <td><a class="shop_a_3" href="JavaScript:if(confirm('คุณต้องการลบข้อมูลใช่หรือไม่')==true){window.location='order_list_delete.php?order_id=<?php echo $objResult2["order_id"];?>&order_ordernumber=<?php echo $objResult2["order_ordernumber"];?>';}"><i class="fa fa-trash"></i></a></td>
      </tr>
      <?php
      $total = $total + ($objResult2["order_price"] + $objResult2["transport_price"]);
      }
      ?>
    </table>
    <span class="shop_span_7_4"><span class="shop_span_7_4_1">สรุป</span> การสั่งชื้อสินค้าของวันที่ <?php echo $_POST["startdate"]; ?> ถึง <?php echo $_POST["enddate"]; ?> <span class="shop_span_7_4_1">ยอดรวมทั้งหมด</span> <?php echo $total; ?> บาท</span>
  </div>
  <hr>
  <?php include '../includes/footer.php';?>
  <?php mysqli_close($Connection); ?>
</body>
</html>
