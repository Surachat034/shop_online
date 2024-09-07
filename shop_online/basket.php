<?php

require_once('connections/mysqli.php');

session_start();

if ($_SESSION == NULL) {
    header("location:login.php");
}

$strSQL = "SELECT * FROM shop_information";
$objQuery = mysqli_query($Connection, $strSQL);
$objResult = mysqli_fetch_array($objQuery, MYSQLI_ASSOC);

$strSQL9 = "SELECT * FROM member WHERE member_username = '".$_SESSION['member_username']."' ";
$objQuery9 = mysqli_query($Connection, $strSQL9);
$objResult9 = mysqli_fetch_array($objQuery9, MYSQLI_ASSOC);

$strSQL10 = "SELECT * FROM category ORDER BY category_num ASC";
$objQuery10 = mysqli_query($Connection, $strSQL10);

$strSQL2 = "SELECT * FROM basket INNER JOIN (product, category, member) ON (basket.product_id = product.product_id AND basket.category_id = category.category_id AND basket.member_id = member.member_id) WHERE member_username = '".$_SESSION['member_username']."'";
$objQuery2 = mysqli_query($Connection, $strSQL2);

$strSQL2 .= " ORDER BY basket_id DESC";
$objQuery2 = mysqli_query($Connection, $strSQL2);
$objResult2 = mysqli_fetch_array($objQuery2, MYSQLI_ASSOC);

$strSQL3 = "SELECT * FROM basket INNER JOIN (product, category, member) ON (basket.product_id = product.product_id AND basket.category_id = category.category_id AND basket.member_id = member.member_id) WHERE member_username = '".$_SESSION['member_username']."'";
$objQuery3 = mysqli_query($Connection, $strSQL3);

$strSQL7 = "SELECT * FROM transport";
$objQuery7 = mysqli_query($Connection, $strSQL7);

$strSQL8 = "SELECT `member_address`, `member_address2` FROM `member` WHERE `member_username` = '".$_SESSION['member_username']."'";
$objQuery8 = mysqli_query($Connection, $strSQL8);

$address = mysqli_fetch_array($objQuery8, MYSQLI_NUM);

$no = 1;
$total = 0;

$random_captcha = "";

function random_captcha($len) {
    srand((double)microtime()*10000000);
    $chars = "0123456789";
    $ret_str = "";
    $num = strlen($chars);
    for ($i = 0; $i < $len; $i++) {
        $ret_str .= $chars[rand() % $num];
    }
    return $ret_str;
}
$random_captcha = random_captcha(9);

if (isset($_POST["submit"])) {

    if ($_POST["transport_id"] == "select") {
        echo "<script type='text/javascript'>";
        echo "alert('กรุณาเลือกการขนส่งสินค้า !')";
        echo "</script>";
    } elseif ($_POST["order_address"] == "select") {
        echo "<script type='text/javascript'>";
        echo "alert('กรุณาเลือกที่อยู่การจัดส่ง !')";
        echo "</script>";
    } else {
        // อัปเดตสถานะตะกร้าสินค้า
        $strSQL4 = "SELECT * FROM basket INNER JOIN (product, category, member) ON (basket.product_id = product.product_id AND basket.category_id = category.category_id AND basket.member_id = member.member_id) WHERE member_username = '".$_SESSION['member_username']."'";
        $objQuery4 = mysqli_query($Connection, $strSQL4);

        while ($objResult4 = mysqli_fetch_array($objQuery4, MYSQLI_ASSOC)) {
            if ($objResult4["basket_status"] == "P0") {
                $strSQL5 = "UPDATE basket SET basket_status = 'P1', order_ordernumber = '".$random_captcha."' WHERE basket_id = '".$objResult4["basket_id"]."'";
                $objQuery5 = mysqli_query($Connection, $strSQL5);
            }
        }

        // สร้างคำสั่งซื้อใหม่
        $order_address = $_POST["order_address"];
        $transport_id = $_POST["transport_id"];
        $order_date = $_POST["order_date"];
        $order_price = $_POST["order_price"];
        $order_img = $_POST["order_img"];
        $member_id = $_POST["member_id"];

        $strSQL6 = "INSERT INTO order_list (order_ordernumber, order_date, order_price, order_img, member_id, transport_id, order_address) 
                    VALUES ('".$random_captcha."', '".$order_date."', '".$order_price."', '".$order_img."', '".$member_id."', '".$transport_id."', '".$order_address."')";
        $objQuery6 = mysqli_query($Connection, $strSQL6);

        header("location:order.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?php echo $objResult["shop_information_title"] ?></title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="assets/css/body.css">
  <link rel="stylesheet" type="text/css" href="assets/css/navigationbar.css">
  <link rel="stylesheet" type="text/css" href="assets/css/shop.css">
</head>
<body>
  <?php include 'includes/navbar.php';?>
  <div class="shop_div_2">
    <?php
    if ($objResult2["basket_id"] == NULL) {
    ?>
    <span class="shop_span_7">ไม่มีสินค้าในตะกร้าของคุณ</span>
    <?php
    } elseif ($objResult2["basket_status"] == "P1") {
    ?>
    <span class="shop_span_7">ไม่มีสินค้าในตะกร้าของคุณ</span>
    <?php
    } else {
    ?>
    <span class="shop_span_7">ตะกร้าสินค้าของคุณ</span>
    <div class="shop_div_7">
      <table class="shop_table_1">
        <tr>
          <td bgcolor="#33CCFF"></td>
          <td bgcolor="#33CCFF">ลำดับที่</td>
          <td bgcolor="#33CCFF">ชื่อสินค้า</td>
          <td bgcolor="#33CCFF">ราคา</td>
          <td bgcolor="#33CCFF">จำนวนที่สั่งซื้อ</td>
          <td bgcolor="#33CCFF">รวมเป็นเงิน</td>
        </tr>
        <?php
        while ($objResult3 = mysqli_fetch_array($objQuery3, MYSQLI_ASSOC)) {
          if ($objResult3["basket_status"] == "P0") {
          ?>
          <tr>
            <td><a class="shop_a_3" href="JavaScript:if(confirm('คุณต้องการยกเลิกสินค้าชิ้นนี้ใช่หรือไม่')==true){window.location='basket_delete.php?basket_id=<?php echo $objResult3["basket_id"];?>&product_id=<?php echo $objResult3["product_id"];?>';}"><i class="fa fa-trash"></i></a></td>
            <td><?php echo $no; ?></td>
            <td><?php echo $objResult3["product_name"]; ?></td>
            <td><?php echo $objResult3["product_price"]." บาท"; ?></td>
            <td><?php echo $objResult3["basket_amount"]; ?></td>
            <td><?php echo $objResult3["product_price"] * $objResult3["basket_amount"]; ?> บาท</td>
          </tr>
          <?php
          $total += ($objResult3["product_price"] * $objResult3["basket_amount"]);
          $no++;
          }
        }
        ?>
        <tr>
          <td bgcolor="#BEBEBE"></td>
          <td bgcolor="#BEBEBE"></td>
          <td bgcolor="#BEBEBE"></td>
          <td bgcolor="#BEBEBE"></td>
          <td bgcolor="#BEBEBE" style="color:#FF0000">รวมเป็นเงินทั้งหมด</td>
          <td bgcolor="#BEBEBE" style="color:#FF0000"><?php echo $total." บาท"; ?></td>
        </tr>
      </table>
    </div>
    <form name="basket" method="post">
      <div class="shop_div_11">
        <select name="order_address" id="order_address" class="shop_select_2">
          <option value="select">เลือกที่อยู่การจัดส่ง</option>
          <?php
          // Assuming $address is an array of addresses
          for ($x = 0; $x < count($address); $x++) {
          ?>
          <option value="<?php echo $address[$x];?>"><?php echo $address[$x]; ?></option>
          <?php
          }
          ?>
        </select>

        <select name="transport_id" id="transport_id" class="shop_select_2">
          <option value="select">เลือกการขนส่งสินค้าของคุณ</option>
          <?php
          while ($objResult7 = mysqli_fetch_array($objQuery7)) {
          ?>
          <option value="<?php echo $objResult7[0];?>"><?php echo $objResult7[1]." ค่าจัดส่ง ".$objResult7[2]." บาท"; ?></option>
          <?php
          }
          ?>
        </select>
        <a class="btn btn-primary" href="index.php" role="button">เพิ่มสินค้า</a>
     
        <input type="submit" name="submit" id="submit" class="shop_input_5" value="ยืนยันสั่งชื้อสินค้าทั้งหมด"/>
        
      </div>
      
      <input type="hidden" name="order_date" id="order_date" value="<?php echo date('Y-m-d H:i:s');?>">
      <input type="hidden" name="order_price" id="order_price" value="<?php echo $total;?>">
      <input type="hidden" name="order_img" id="order_img" value="ยังไม่ได้ส่งหลักฐานการโอนเงิน">
      <input type="hidden" name="member_id" id="member_id" value="<?php echo $objResult9["member_id"];?>">
    </form>

    <?php
    }
    ?>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <hr>
  <?php include 'includes/footer.php';?>
  <?php mysqli_close($Connection); ?>
</body>
</html>
