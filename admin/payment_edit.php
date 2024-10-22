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

    $strSQL = "SELECT * FROM shop_information";
    $objQuery = mysqli_query($Connection,$strSQL);
    $objResult = mysqli_fetch_array($objQuery,MYSQLI_ASSOC);

    $strSQL10 = "SELECT * FROM category ORDER BY category_num ASC";
    $objQuery10 = mysqli_query($Connection,$strSQL10);

    $payment_id = null;

    if(isset($_GET["payment_id"])){
        $payment_id = $_GET["payment_id"];
    }

    $strSQL2 = "SELECT * FROM payment WHERE payment_id = '".$payment_id."' ";
    $objQuery2 = mysqli_query($Connection,$strSQL2);
    $objResult2 = mysqli_fetch_array($objQuery2,MYSQLI_ASSOC);

    if (isset($_POST["submit"])) {
      $strSQL3 = "UPDATE payment SET payment_number = '".$_POST["payment_number"]."' , payment_account_name = '".$_POST["payment_account_name"]."' WHERE payment_id = '".$_POST["payment_id"]."' ";
      $objQuery3 = mysqli_query($Connection,$strSQL3);

      header("location:payment.php");
      exit();
    }

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
  <div class="shop_div_2">
    <span class="shop_span_7"><?php echo $objResult2["payment_bank_name"]; ?></span>
    <form name="payment_edit" method="post">
      <div class="shop_div_5">
        <span class="shop_span_8">เลขบัญชี</span>
        <input type="text" name="payment_number" id="payment_number" class="shop_input_1" value="<?php echo $objResult2["payment_number"]; ?>"/>
        <span class="shop_span_8">ชื่อบัญชี</span>
        <input type="text" name="payment_account_name" id="payment_account_name" class="shop_input_1" value="<?php echo $objResult2["payment_account_name"]; ?>"/>
        <input type="submit" name="submit" id="submit" class="shop_input_4" value="บันทึกข้อมูล"/>
      </div>
      <input type="hidden" name="payment_id" id="payment_id" value="<?php echo $objResult2["payment_id"];?>">
    </form>
  </div>
  <hr>
  <?php include '../includes/footer.php';?>
  <?php mysqli_close($Connection); ?>
</body>
</html>
