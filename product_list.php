<?php

    require_once('connections/mysqli.php');

    session_start();

    $strSQL = "SELECT * FROM shop_information";
    $objQuery = mysqli_query($Connection,$strSQL);
    $objResult = mysqli_fetch_array($objQuery,MYSQLI_ASSOC);

    $category_id = null;

    if(isset($_GET["category_id"])){
        $category_id = $_GET["category_id"];
    }

    $strSQL2 = "SELECT * FROM product WHERE category_id = '".$category_id."'";
    $objQuery2 = mysqli_query($Connection,$strSQL2);

    $strSQL2 .= "ORDER BY product_id DESC";
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
  <link rel="stylesheet" type="text/css" href="assets/css/body.css">
  <link rel="stylesheet" type="text/css" href="assets/css/navigationbar.css">
  <link rel="stylesheet" type="text/css" href="assets/css/shop.css">
</head>
<body>
  <?php include 'includes/navbar.php';?>
  <div class="shop_div_1">
    <?php
    while ($objResult2 = mysqli_fetch_array($objQuery2,MYSQLI_ASSOC)) {
    ?>
    <a class="shop_a_1" href="product.php?product_code=<?php echo $objResult2["product_code"];?>">
      <span class="shop_span_1">
        <span class="shop_span_1_1"><?php echo iconv_substr($objResult2["product_name"], 0, 25, "UTF-8");?>...</span>
        <span class="shop_span_1_2"><img width="100%" height="300" src="images/product/<?php echo $objResult2["product_img1"];?>"></span>
        <span class="shop_span_1_3">ราคา : <?php echo $objResult2["product_price"]; ?> บาท</span>
      </span>
    </a>
    <?php
    }
    ?>
  </div>
  <hr>
  <?php include 'includes/footer.php';?>
  <?php mysqli_close($Connection); ?>
</body>
</html>
