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

    $strSQL3 = "SELECT * FROM category ORDER BY category_num ASC";
    $objQuery3 = mysqli_query($Connection,$strSQL3);

    $strSQL10 = "SELECT * FROM category ORDER BY category_num ASC";
    $objQuery10 = mysqli_query($Connection,$strSQL10);

    if (isset($_POST["submit"])) {

      $target_dir = "../images/product/";
      $target_file = $target_dir . basename($_FILES["product_img1"]["name"]);
      $target_file2 = $target_dir . basename($_FILES["product_img2"]["name"]);
      $target_file3 = $target_dir . basename($_FILES["product_img3"]["name"]);
      $target_file4 = $target_dir . basename($_FILES["product_img4"]["name"]);

      move_uploaded_file($_FILES["product_img1"]["tmp_name"], $target_file);
      move_uploaded_file($_FILES["product_img2"]["tmp_name"], $target_file2);
      move_uploaded_file($_FILES["product_img3"]["tmp_name"], $target_file3);
      move_uploaded_file($_FILES["product_img4"]["tmp_name"], $target_file4);

      $strSQL2 = "INSERT INTO product (product_code,product_name,product_detail,product_img1,product_img2,product_img3,product_img4,product_price,product_stock,category_id) VALUES ('".$_POST["product_code"]."','".$_POST["product_name"]."','".$_POST["product_detail"]."','".$_FILES["product_img1"]["name"]."','".$_FILES["product_img2"]["name"]."','".$_FILES["product_img3"]["name"]."','".$_FILES["product_img4"]["name"]."','".$_POST["product_price"]."','".$_POST["product_stock"]."','".$_POST["category_id"]."')";
      $objQuery2 = mysqli_query($Connection,$strSQL2);

      header("location:product.php");

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
    <span class="shop_span_7">เพิ่มสินค้าใหม่</span>
    <form name="product_add" method="post" enctype="multipart/form-data">
      <div class="shop_div_5_1">
        <span class="shop_span_8">รหัสสินค้า</span>
        <input type="text" name="product_code" id="product_code" class="shop_input_1" placeholder="เช่น / P001" required=""/>
        <span class="shop_span_8">ชื่อสินค้า</span>
        <input type="text" name="product_name" id="product_name" class="shop_input_1" required=""/>
        <span class="shop_span_8">รายละเอียดสินค้า</span>
        <textarea name="product_detail" id="product_detail" class="shop_textarea_1" required=""></textarea>
        <span class="shop_span_8">รูปที่ 1</span>
        <input type="file" name="product_img1" id="product_img1" class="shop_input_3" required=""/>
        <span class="shop_span_8">รูปที่ 2</span>
        <input type="file" name="product_img2" id="product_img2" class="shop_input_3"/>
        <span class="shop_span_8">รูปที่ 3</span>
        <input type="file" name="product_img3" id="product_img3" class="shop_input_3"/>
        <span class="shop_span_8">รูปที่ 4</span>
        <input type="file" name="product_img4" id="product_img4" class="shop_input_3"/>
        <span class="shop_span_8">ราคาสินค้า</span>
        <input type="text" name="product_price" id="product_price" class="shop_input_1" required=""/>
        <span class="shop_span_8">สต๊อก</span>
        <input type="text" name="product_stock" id="product_stock" class="shop_input_1" required=""/>
        <span class="shop_span_8">หมวดหมู่</span>
        <select name="category_id" id="category_id" class="shop_select_1">
        <?php
        while ($objResult3 = mysqli_fetch_array($objQuery3)) {
        ?>
        <option value="<?php echo $objResult3[0];?>"><?php echo $objResult3[2];?></option>
        <?php
        }
        ?>
        </select>
        <input type="submit" name="submit" id="submit" class="shop_input_4" value="บันทึกสินค้า"/>
      </div>
    </form>
  </div>
  <hr>
  <?php include '../includes/footer.php';?>
  <?php mysqli_close($Connection); ?>
</body>
</html>
