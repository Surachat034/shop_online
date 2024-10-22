<?php

    require_once('connections/mysqli.php');

    session_start();

    if ($_SESSION == NULL) {
        header("location:login.php");
    }

    $strSQL = "SELECT * FROM shop_information";
    $objQuery = mysqli_query($Connection, $strSQL);
    $objResult = mysqli_fetch_array($objQuery, MYSQLI_ASSOC);

    $strSQL10 = "SELECT * FROM category ORDER BY category_num ASC";
    $objQuery10 = mysqli_query($Connection, $strSQL10);

    $strSQL2 = "SELECT * FROM order_list INNER JOIN member ON order_list.member_id = member.member_id WHERE member_username = '".$_SESSION['member_username']."'";
    $objQuery2 = mysqli_query($Connection, $strSQL2);
    $objResult2 = mysqli_fetch_array($objQuery2, MYSQLI_ASSOC);

    $strSQL3 = "SELECT * FROM order_list INNER JOIN (member, transport) ON (order_list.member_id = member.member_id AND order_list.transport_id = transport.transport_id) WHERE member_username = '".$_SESSION['member_username']."'";
    $objQuery3 = mysqli_query($Connection, $strSQL3);

    $strSQL3 .= " ORDER BY order_id DESC";
    $objQuery3 = mysqli_query($Connection, $strSQL3);

    $a = 1;
    $total = 0;

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?php echo $objResult["shop_information_title"]; ?></title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="assets/css/body.css">
  <link rel="stylesheet" type="text/css" href="assets/css/navigationbar.css">
  <link rel="stylesheet" type="text/css" href="assets/css/shop.css">
</head>
<body>
  <?php include 'includes/navbar.php';?>
  <div class="shop_div_2">
    <?php
    if ($objResult2["order_id"] == NULL) {
    ?>
    <span class="shop_span_7">ไม่มีรายการสั่งชื้อสินค้าของคุณ</span>
    <?php
    } else {
    ?>
    <span class="shop_span_7">รายการสั่งชื้อสินค้าของคุณทั้งหมด</span>
    <div class="shop_div_7">
      <table class="shop_table_1">
        <tr>
          <td bgcolor="#33CCFF"></td>
          <td bgcolor="#33CCFF">เลขออเดอร์</td>
          <td bgcolor="#33CCFF">วันเวลาที่สั่งชื้อ</td>
          <td bgcolor="#33CCFF">ยอดสั่งซื้อ</td>
          <td bgcolor="#33CCFF">จัดส่ง</td>
          <td bgcolor="#33CCFF">รวมเป็นเงิน</td>
          <td bgcolor="#33CCFF">Tracking Number</td>
          <td bgcolor="#33CCFF">สถานะการสั่งซื้อ</td>
          <td bgcolor="#33CCFF">รายละเอียด</td>
          <td bgcolor="#33CCFF">หลักฐานการโอนเงิน</td>
        </tr>
        <?php
        while ($objResult3 = mysqli_fetch_array($objQuery3, MYSQLI_ASSOC)) {
        ?>
        <tr>
          <td>
            <?php
            // แสดงปุ่มลบเฉพาะเมื่อสถานะไม่ใช่ 'ส่งสินค้าสำเร็จ'
            if ($objResult3["order_status"] != 'ส่งสินค้าสำเร็จ') {
            ?>
            <a class="shop_a_3" href="JavaScript:if(confirm('คุณต้องการลบออเดอร์ใช่หรือไม่')==true){window.location='order_delete.php?order_id=<?php echo $objResult3["order_id"];?>&order_ordernumber=<?php echo $objResult3["order_ordernumber"];?>';}"><i class="fa fa-times"></i></a>
            <?php
            }
            ?>
          </td>
          <td><?php echo $objResult3["order_ordernumber"]; ?></td>
          <td><?php echo $objResult3["order_date"]; ?></td>
          <td><?php echo $objResult3["order_price"] . " บาท"; ?></td>
          <td><?php echo $objResult3["transport_name"] . " ค่าจัดส่ง " . $objResult3["transport_price"] . " บาท"; ?></td>
          <td><?php echo $objResult3["order_price"] + $objResult3["transport_price"] . " บาท"; ?></td>
          <td><?php echo $objResult3["tracking_number"]; ?></td>
          <td>
            <?php
            if ($objResult3["order_status"] == 'อยู่ระหว่างรอการส่งหลักฐานการโอนเงิน') {
            ?>
              <span><b style="color:red;">อยู่ระหว่างรอการส่งหลักฐานการโอนเงิน </b><a class="shop_a_4" href="payment.php">ข้อมูลการชำระเงิน</a></span>
            <?php
            } else {
              // แสดงข้อความในสีเขียว
              echo '<span style="color:#00E676;">' . htmlspecialchars($objResult3["order_status"]) . '</span>';
            }
            ?>
          </td>
          <td><a class="shop_a_2" href="order_view.php?order_ordernumber=<?php echo $objResult3["order_ordernumber"];?>"><i class="fa fa-eye"></i></a></td>
          <td><a class="shop_a_2" href="money_transfer_slip.php?order_id=<?php echo $objResult3["order_id"];?>"><i class="fa fa-clipboard"></i></a></td>
        </tr>
        <?php
        }
        ?>
      </table>
    </div>
    <?php
    }
    ?>
  </div>
  <hr>
  <?php include 'includes/footer.php';?>
  <?php mysqli_close($Connection); ?>
</body>
</html>
