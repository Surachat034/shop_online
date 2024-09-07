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

    $product_id = null;

    if(isset($_GET["product_id"])){
        $product_id = $_GET["product_id"];
    }

    $strSQL2 = "SELECT * FROM product WHERE product_id = '".$product_id."' ";
    $objQuery2 = mysqli_query($Connection,$strSQL2);
    $objResult2 = mysqli_fetch_array($objQuery2,MYSQLI_ASSOC);

    $strSQL3 = "SELECT * FROM member WHERE member_username = '".$_SESSION['member_username']."' ";
    $objQuery3 = mysqli_query($Connection,$strSQL3);
    $objResult3 = mysqli_fetch_array($objQuery3,MYSQLI_ASSOC);

    if(isset($_POST["submit"])){

      if ($_POST["basket_amount"] > $objResult2["product_stock"]) {

        header("location:product_order.php?product_id=$product_id");

      }elseif ($_POST["basket_amount"] <= $objResult2["product_stock"]) {

        $stock = $objResult2["product_stock"] - $_POST["basket_amount"];

        $strSQL4 = "UPDATE product SET product_stock = '".$stock."' WHERE product_id = '".$product_id."' ";
        $objQuery4 = mysqli_query($Connection,$strSQL4);

        $strSQL5 = "INSERT INTO basket (basket_amount,product_id,category_id,member_id) VALUES ('".$_POST["basket_amount"]."','".$_POST["product_id"]."','".$_POST["category_id"]."','".$_POST["member_id"]."')";
        $objQuery5 = mysqli_query($Connection,$strSQL5);

        header("location:basket.php");
        exit();

      }

    }

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
    <span class="shop_span_7">ชื่อสินค้า : <?php echo $objResult2["product_name"]; ?></span>
    <form name="product_order" method="post">
      <div class="shop_div_6">
        <span class="shop_span_7_1">จำนวนที่ต้องการสั่งซื้อ <span class="shop_span_10">(เหลือในสต๊อกจำนวน <?php echo $objResult2["product_stock"]; ?>)</span></span>
        <input type="text" name="basket_amount" id="basket_amount" class="shop_input_1" value="1" required=""/>
        <input type="submit" name="submit" id="submit" class="shop_input_2" value="ชื้อสินค้า"/>
      </div>
      <input type="hidden" name="category_id" id="category_id" value="<?php echo $objResult2["category_id"];?>">
      <input type="hidden" name="product_id" id="product_id" value="<?php echo $objResult2["product_id"];?>">
      <input type="hidden" name="member_id" id="member_id" value="<?php echo $objResult3["member_id"];?>">
    </form>
  </div>
  <hr>
  <?php include 'includes/footer.php';?>
  <?php mysqli_close($Connection); ?>
</body>
</html>
