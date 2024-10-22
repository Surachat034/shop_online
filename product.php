<?php

    require_once('connections/mysqli.php');

    session_start();

    $strSQL = "SELECT * FROM shop_information";
    $objQuery = mysqli_query($Connection,$strSQL);
    $objResult = mysqli_fetch_array($objQuery,MYSQLI_ASSOC);

    $strSQL10 = "SELECT * FROM category ORDER BY category_num ASC";
    $objQuery10 = mysqli_query($Connection,$strSQL10);

    $product_code = null;

    if(isset($_GET["product_code"])){
        $product_code = $_GET["product_code"];
    }

    $strSQL2 = "SELECT * FROM product WHERE product_code = '".$product_code."'";
    $objQuery2 = mysqli_query($Connection,$strSQL2);
    $objResult2 = mysqli_fetch_array($objQuery2,MYSQLI_ASSOC);

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

  <style>
  .slideshow-container {
    position: relative;
  }
  .prev, .next {
    cursor: pointer;
    position: absolute;
    top: 50%;
    width: auto;
    padding: 16px;
    margin-top: -22px;
    color: white;
    font-weight: bold;
    font-size: 18px;
    transition: 0.6s ease;
    border-radius: 0 3px 3px 0;
    user-select: none;
  }
  .next {
    right: 0;
    border-radius: 3px 0 0 3px;
  }
  .prev:hover, .next:hover {
    background-color: rgba(0,0,0,0.3);
  }
  .fade {
    -webkit-animation-name: fade;
    -webkit-animation-duration: 1.5s;
    animation-name: fade;
    animation-duration: 1.5s;
  }
  @-webkit-keyframes fade {
    from {opacity: .4}
    to {opacity: 1}
  }
  @keyframes fade {
    from {opacity: .4}
    to {opacity: 1}
  }
  </style>

</head>
<body>
  <?php include 'includes/navbar.php';?>
  <div class="shop_div_3">
    <table width="90%" align="center" cellpadding="10">
      <tr>
        <td width="30%" valign="top">
          <div class="slideshow-container">
            <?php
            if ($objResult2["product_img1"] != NULL) {
            ?>
            <div class="mySlides fade">
              <img src="images/product/<?php echo $objResult2["product_img1"];?>" style="width:100%" height="600px">
            </div>
            <?php
            }
            if ($objResult2["product_img2"] != NULL) {
            ?>
            <div class="mySlides fade">
              <img src="images/product/<?php echo $objResult2["product_img2"];?>" style="width:100%" height="600px">
            </div>
            <?php
            }
            if ($objResult2["product_img3"] != NULL) {
            ?>
            <div class="mySlides fade">
              <img src="images/product/<?php echo $objResult2["product_img3"];?>" style="width:100%" height="600px">
            </div>
            <?php
            }
            if ($objResult2["product_img4"] != NULL) {
            ?>
            <div class="mySlides fade">
              <img src="images/product/<?php echo $objResult2["product_img4"];?>" style="width:100%" height="600px">
            </div>
            <?php
            }
            ?>
            <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
            <a class="next" onclick="plusSlides(1)">&#10095;</a>
          </div>
        </td>
        <td width="40%" valign="top">
          <span class="shop_span_3"><i class="fa fa-hand-o-right"></i> ชื่อสินค้า</span>
          <p class="shop_p_1"><?php echo $objResult2["product_name"]; ?></p>
          <span class="shop_span_3"><i class="fa fa-list-alt"></i> รายละเอียดสินค้า</span>
          <p class="shop_p_1"><?php echo nl2br($objResult2["product_detail"]); ?></p>
          <span class="shop_span_3"><i class="fa fa-money"></i> ราคาสินค้า</span>
          <p class="shop_p_1"><?php echo $objResult2["product_price"];?> บาท</p>
          <div class="shop_div_4">
            <a href="product_order.php?product_id=<?php echo $objResult2["product_id"];?>"><button class="shop_button_1">ชื้อสินค้า</button></a>
          </div>
        </td>
        <!--
        <td width="20%" valign="top">
          <span class="shop_span_4">Logo ของร้าน</span>
          <img src="images/shop_information/<?php echo $objResult["shop_information_logo"];?>" style="width:100%" height="300px"/>
          <span class="shop_span_5"><i class="fa fa-check-square-o"></i> ข้อมูลเจ้าของร้าน</span>
          <p class="shop_p_2">ที่อยู่ : <?php echo $objResult["shop_information_address"];?></p>
          <p class="shop_p_2">อีเมล์ : <?php echo $objResult["shop_information_email"];?></p>
          <p class="shop_p_2">เบอร์โทรศัพท์ : <?php echo $objResult["shop_information_tel"];?></p>
        </td> -->
      </tr>
    </table>
  </div>
  <hr>
  <?php include 'includes/footer.php';?>
  <script>
  var slideIndex = 1;
  showSlides(slideIndex);

  function plusSlides(n) {
    showSlides(slideIndex += n);
  }

  function showSlides(n) {
    var i;
    var slides = document.getElementsByClassName("mySlides");
    if (n > slides.length) {slideIndex = 1}
    if (n < 1) {slideIndex = slides.length}
    for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
    }
    slides[slideIndex-1].style.display = "block";
  }
  </script>
  <?php mysqli_close($Connection); ?>
</body>
</html>
