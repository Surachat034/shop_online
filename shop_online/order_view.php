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

    $order_ordernumber = null;

    if(isset($_GET["order_ordernumber"])){
        $order_ordernumber = $_GET["order_ordernumber"];
    }

    $strSQL2 = "SELECT * FROM basket INNER JOIN product ON basket.product_id = product.product_id WHERE order_ordernumber = '".$order_ordernumber."'";
    $objQuery2 = mysqli_query($Connection,$strSQL2);

    $strSQL3 = "SELECT * FROM basket WHERE order_ordernumber = '".$order_ordernumber."'";
    $objQuery3 = mysqli_query($Connection,$strSQL3);
    $objResult3 = mysqli_fetch_array($objQuery3,MYSQLI_ASSOC);

    $a = 1;
    $total = 0;

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
    <span class="shop_span_7">รายละเอียดออเดอร์ <?php echo $objResult3["order_ordernumber"]; ?></span>
    <div class="shop_div_7">
      <table class="shop_table_1">
        <tr>
          <td bgcolor="#33CCFF">ลำดับ</td>
          <td bgcolor="#33CCFF">ชื่อสินค้า</td>
          <td bgcolor="#33CCFF">ราคา</td>
          <td bgcolor="#33CCFF">จำนวนที่สั่งชื้อ</td>
          <td bgcolor="#33CCFF">รวมเป็นเงิน</td>
        </tr>
        <?php
        while ($objResult2 = mysqli_fetch_array($objQuery2,MYSQLI_ASSOC)) {
        ?>
        <tr>
          <td><?php echo $a; ?></td>
          <td><?php echo $objResult2["product_name"]; ?></td>
          <td><?php echo $objResult2["product_price"]." บาท"; ?></td>
          <td><?php echo $objResult2["basket_amount"]; ?></td>
          <td><?php echo $objResult2["product_price"] * $objResult2["basket_amount"]." บาท"; ?></td>
        </tr>
        <?php
        $total = $total + ($objResult2["product_price"] * $objResult2["basket_amount"]);
        $a++;
        }
        ?>
        <tr>
          <td bgcolor="#BEBEBE"></td>
          <td bgcolor="#BEBEBE"></td>
          <td bgcolor="#BEBEBE"></td>
          <td bgcolor="#BEBEBE" style="color:#FF0000">รวมเป็นเงินทั้งหมด</td>
          <td bgcolor="#BEBEBE" style="color:#FF0000"><?php echo $total." บาท"; ?></td>
        </tr>
      </table>
    </div>
  </div>
  <hr>
  <?php include 'includes/footer.php';?>
  <?php mysqli_close($Connection); ?>
</body>
</html>
