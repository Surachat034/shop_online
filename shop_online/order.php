<?php

    require_once('connections/mysqli.php');

    session_start();

    if ($_SESSION == NULL) {
        header("location:login.php");
    }

    $strSQL = "SELECT * FROM shop_information";
    $objQuery = mysqli_query($Connection,$strSQL);
    $objResult = mysqli_fetch_array($objQuery,MYSQLI_ASSOC);

    $strSQL2 = "SELECT * FROM order_list INNER JOIN (member,product) ON (order_list.member_id = member.member_id AND order_list.product_id = product.product_id) WHERE member_username = '".$_SESSION['member_username']."'";
    $objQuery2 = mysqli_query($Connection,$strSQL2);
    $objResult2 = mysqli_fetch_array($objQuery2,MYSQLI_ASSOC);

    $strSQL3 = "SELECT * FROM order_list INNER JOIN (member,product) ON (order_list.member_id = member.member_id AND order_list.product_id = product.product_id) WHERE member_username = '".$_SESSION['member_username']."'";
    $objQuery3 = mysqli_query($Connection,$strSQL3);

    $strSQL3 .= "ORDER BY order_id DESC";
    $objQuery3 = mysqli_query($Connection,$strSQL3);

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
    <?php
    if ($objResult2["order_id"] == NULL) {
    ?>
    <span class="shop_span_7">ไม่มีรายการสั่งชื้อสินค้าของคุณ</span>
    <?php
    }else{
    ?>
    <span class="shop_span_7">รายการสั่งชื้อสินค้าของคุณทั้งหมด</span>
    <div class="shop_div_7">
      <table class="shop_table_1">
        <tr>
          <td bgcolor="#33CCFF">ชื่อสินค้า</td>
          <td bgcolor="#33CCFF">ราคา</td>
          <td bgcolor="#33CCFF">จำนวนที่สั่งซื้อ</td>
          <td bgcolor="#33CCFF">รวมเป็นเงิน</td>
          <td bgcolor="#33CCFF">วันเวลาที่สั่งซื้อ</td>
          <td bgcolor="#33CCFF">สถานะการสั่งซื้อ</td>
          <td bgcolor="#33CCFF">หลักฐานการโอนเงิน</td>
        </tr>
        <?php
        while ($objResult3 = mysqli_fetch_array($objQuery3,MYSQLI_ASSOC)) {
        ?>
        <tr>
          <td><?php echo $objResult3["product_name"]; ?></td>
          <td><?php echo $objResult3["product_price"]; ?> บาท</td>
          <td><?php echo $objResult3["order_amount"]; ?></td>
          <td><?php echo $objResult3["product_price"] * $objResult3["order_amount"]; ?> บาท</td>
          <td><?php echo $objResult3["order_date"]; ?></td>
          <td>
            <?php
            if ($objResult3["order_status"] == 'อยู่ระหว่างรอการส่งหลักฐานการโอนเงิน') {
              ?>
              <span>อยู่ระหว่างรอการส่งหลักฐานการโอนเงิน <a class="shop_a_4" href="payment.php">ข้อมูลการชำระเงิน</a></span>
              <?php
            }else{
              echo $objResult3["order_status"];
            }
            ?>
          </td>
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
