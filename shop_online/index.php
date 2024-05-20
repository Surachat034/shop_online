<?php

    require_once('connections/mysqli.php');

    session_start();

    $strSQL = "SELECT * FROM shop_information";
    $objQuery = mysqli_query($Connection,$strSQL);
    $objResult = mysqli_fetch_array($objQuery,MYSQLI_ASSOC);

    $strSQL2 = "SELECT * FROM product";
    $objQuery2 = mysqli_query($Connection,$strSQL2);

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
  img {
    vertical-align: middle;
  }
  .mySlides {
    display: none;
  }
  .slideshow-container {
    max-width: 95%;
    position: relative;
    margin: auto;
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
  <div class="shop_div_1_1">
    <div class="slideshow-container">
    <div class="mySlides fade">
        <img src="images/slideshow/sl2.jpg" width="100%" height="800px">
      </div>
      <div class="mySlides fade">
        <img src="images/slideshow/sl1.jpg" width="100%" height="800px">
      </div>
      
    </div>
    <div>
      <span class="dot"></span>
      <span class="dot"></span>
      <span class="dot"></span>
    </div>
  </div>
  <div class="shop_div_2">
    <span class="shop_span_7_3"><?php echo $objResult['shop_information_name']; ?> | ยินดีต้อนรับ <i class="fa fa-cart-plus"></i></span>
  </div>
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
  <script>
  var slideIndex = 0;
  showSlides();

  function showSlides() {
    var i;
    var slides = document.getElementsByClassName("mySlides");
    var dots = document.getElementsByClassName("dot");
    for (i = 0; i < slides.length; i++) {
      slides[i].style.display = "none";
    }
    slideIndex++;
    if (slideIndex > slides.length) {slideIndex = 1}
    for (i = 0; i < dots.length; i++) {
      dots[i].className = dots[i].className.replace(" active", "");
    }
    slides[slideIndex-1].style.display = "block";
    dots[slideIndex-1].className += " active";
    setTimeout(showSlides, 4000);
  }
  </script>
  <?php mysqli_close($Connection); ?>
</body>
</html>
