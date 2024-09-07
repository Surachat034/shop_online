<?php

    require_once('connections/mysqli.php');

    session_start();

    if ($_SESSION == NULL) {
        header("location:login.php");
    }

    $strSQL = "SELECT * FROM shop_information";
    $objQuery = mysqli_query($Connection,$strSQL);
    $objResult = mysqli_fetch_array($objQuery,MYSQLI_ASSOC);

    $strSQL2 = "SELECT * FROM payment";
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
  <div class="shop_div_2">
    <span class="shop_span_7">ข้อมูลการชำระเงิน</span>
    <table align="center" cellpadding="10">
      <tr>
       <!-- <td valign="top">
          <img src="images/shop_information/<?php echo $objResult["shop_information_logo"];?>" class="shop_img_1" width="300px" height="300px">
        </td> -->
        <td align="left" valign="top">
          <?php
          while ($objResult2 = mysqli_fetch_array($objQuery2,MYSQLI_ASSOC)) {
            if ($objResult2["payment_number"] != NULL) {
              ?>
              <p class="shop_p_3">
                <span class="shop_span_11"><img src="images/payment/<?php echo $objResult2["payment_img"]; ?>" width="40px"/> <?php echo $objResult2["payment_bank_name"]; ?></span>
                <span class="shop_span_11_1"><?php echo $objResult2["payment_number"]; ?></span>
                <span class="shop_span_11"><?php echo $objResult2["payment_account_name"]; ?></span>
              </p>
              <?php
            }
          }
          ?>
          <div class="shop_div_4">
            <a href="order.php"><button class="shop_button_2">ย้อนกลับ</button></a>
          </div>
        </td>
      </tr>
    </table>
  </div>
  <hr>
  <?php include 'includes/footer.php';?>
  <?php mysqli_close($Connection); ?>
</body>
</html>
