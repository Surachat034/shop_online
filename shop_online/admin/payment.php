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

    $strSQL2 = "SELECT * FROM payment";
    $objQuery2 = mysqli_query($Connection,$strSQL2);

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
  <div class="shop_div_10">
    <span class="shop_span_7_2">ข้อมูลการชำระเงิน</span>
    <table class="shop_table_1">
      <tr>
        <td bgcolor="#33CCFF">ลำดับ</td>
        <td bgcolor="#33CCFF">ธนาคาร</td>
        <td bgcolor="#33CCFF">เลขบัญชี</td>
        <td bgcolor="#33CCFF">ชื่อบัญชี</td>
        <td bgcolor="#33CCFF">ตัวเลือก</td>
      </tr>
      <?php
      while ($objResult2 = mysqli_fetch_array($objQuery2,MYSQLI_ASSOC)) {
      ?>
      <tr>
        <td><?php echo $objResult2["payment_id"];?></td>
        <td><?php echo $objResult2["payment_bank_name"];?></td>
        <td><?php echo $objResult2["payment_number"];?></td>
        <td><?php echo $objResult2["payment_account_name"];?></td>
        <td><a class="shop_a_3" href="payment_edit.php?payment_id=<?php echo $objResult2["payment_id"];?>"><i class="fa fa-pencil-square"></i></a></td>
      </tr>
      <?php
      }
      ?>
    </table>
  </div>
  <hr>
  <?php include '../includes/footer.php';?>
  <?php mysqli_close($Connection); ?>
</body>
</html>
