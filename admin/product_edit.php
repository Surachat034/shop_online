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

    $strSQL4 = "SELECT * FROM category ORDER BY category_num ASC";
    $objQuery4 = mysqli_query($Connection,$strSQL4);

    $strSQL10 = "SELECT * FROM category ORDER BY category_num ASC";
    $objQuery10 = mysqli_query($Connection,$strSQL10);

    $product_id = null;

    if(isset($_GET["product_id"])){
        $product_id = $_GET["product_id"];
    }

    $strSQL2 = "SELECT * FROM product WHERE product_id = '".$product_id."' ";
    $objQuery2 = mysqli_query($Connection,$strSQL2);
    $objResult2 = mysqli_fetch_array($objQuery2,MYSQLI_ASSOC);

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

      if ($_FILES["product_img1"]["name"] != NULL) {

        $strSQL3 = "UPDATE product SET product_img1 = '".$_FILES["product_img1"]["name"]."' WHERE product_id = '".$_POST["product_id"]."' ";
        $objQuery3 = mysqli_query($Connection,$strSQL3);

      }

      if ($_FILES["product_img2"]["name"] != NULL) {

        $strSQL3 = "UPDATE product SET product_img2 = '".$_FILES["product_img2"]["name"]."' WHERE product_id = '".$_POST["product_id"]."' ";
        $objQuery3 = mysqli_query($Connection,$strSQL3);

      }

      if ($_FILES["product_img3"]["name"] != NULL) {

        $strSQL3 = "UPDATE product SET product_img3 = '".$_FILES["product_img3"]["name"]."' WHERE product_id = '".$_POST["product_id"]."' ";
        $objQuery3 = mysqli_query($Connection,$strSQL3);

      }

      if ($_FILES["product_img4"]["name"] != NULL) {

        $strSQL3 = "UPDATE product SET product_img4 = '".$_FILES["product_img4"]["name"]."' WHERE product_id = '".$_POST["product_id"]."' ";
        $objQuery3 = mysqli_query($Connection,$strSQL3);

      }

      $strSQL3 = "UPDATE product SET product_code = '".$_POST["product_code"]."' , product_name = '".$_POST["product_name"]."' , product_detail = '".$_POST["product_detail"]."' , product_price = '".$_POST["product_price"]."' , product_stock = '".$_POST["product_stock"]."' , category_id = '".$_POST["category_id"]."' WHERE product_id = '".$_POST["product_id"]."' ";
      $objQuery3 = mysqli_query($Connection,$strSQL3);

      header("location:product.php");
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
    <span class="shop_span_7">สินค้า ID : <?php echo $objResult2["product_id"]; ?></span>
    <form name="product_edit" method="post" enctype="multipart/form-data">
      <div class="shop_div_5">
        <span class="shop_span_8">รหัสสินค้า</span>
        <input type="text" name="product_code" id="product_code" class="shop_input_1" value="<?php echo $objResult2["product_code"]; ?>"/>
        <span class="shop_span_8">ชื่อสินค้า</span>
        <input type="text" name="product_name" id="product_name" class="shop_input_1" value="<?php echo $objResult2["product_name"]; ?>"/>
        <span class="shop_span_8">รายละเอียดสินค้า</span>
        <textarea name="product_detail" id="product_detail" class="shop_textarea_1"><?php echo $objResult2["product_detail"]; ?></textarea>
        <span class="shop_span_8">รูปที่ 1 :
        <?php
        if ($objResult2["product_img1"] == NULL) {
          echo "ว่าง";
        }else{
          ?>
          <a class="shop_a_4" href="JavaScript:if(confirm('คุณแน่ใจใช่หรือไม่')==true){window.location='product_delete_img.php?product_id=<?php echo $objResult2["product_id"];?>&product_img1=<?php echo $objResult2["product_img1"];?>';}">ลบรูปภาพเดิม</a>
          <?php
        }
        ?>
        </span>
        <input type="file" name="product_img1" id="product_img1" class="shop_input_3"/>
        <span class="shop_span_8">รูปที่ 2 :
        <?php
        if ($objResult2["product_img2"] == NULL) {
          echo "ว่าง";
        }else{
          ?>
          <a class="shop_a_4" href="JavaScript:if(confirm('คุณแน่ใจใช่หรือไม่')==true){window.location='product_delete_img.php?product_id=<?php echo $objResult2["product_id"];?>&product_img2=<?php echo $objResult2["product_img2"];?>';}">ลบรูปภาพเดิม</a>
          <?php
        }
        ?>
        </span>
        <input type="file" name="product_img2" id="product_img2" class="shop_input_3"/>
        <span class="shop_span_8">รูปที่ 3 :
        <?php
        if ($objResult2["product_img3"] == NULL) {
          echo "ว่าง";
        }else{
          ?>
          <a class="shop_a_4" href="JavaScript:if(confirm('คุณแน่ใจใช่หรือไม่')==true){window.location='product_delete_img.php?product_id=<?php echo $objResult2["product_id"];?>&product_img3=<?php echo $objResult2["product_img3"];?>';}">ลบรูปภาพเดิม</a>
          <?php
        }
        ?>
        </span>
        <input type="file" name="product_img3" id="product_img3" class="shop_input_3"/>
        <span class="shop_span_8">รูปที่ 4 :
        <?php
        if ($objResult2["product_img4"] == NULL) {
          echo "ว่าง";
        }else{
          ?>
          <a class="shop_a_4" href="JavaScript:if(confirm('คุณแน่ใจใช่หรือไม่')==true){window.location='product_delete_img.php?product_id=<?php echo $objResult2["product_id"];?>&product_img4=<?php echo $objResult2["product_img4"];?>';}">ลบรูปภาพเดิม</a>
          <?php
        }
        ?>
        </span>
        <input type="file" name="product_img4" id="product_img4" class="shop_input_3"/>
        <span class="shop_span_8">ราคาสินค้า</span>
        <input type="text" name="product_price" id="product_price" class="shop_input_1" value="<?php echo $objResult2["product_price"]; ?>"/>
        <span class="shop_span_8">สต๊อก</span>
        <input type="text" name="product_stock" id="product_stock" class="shop_input_1" value="<?php echo $objResult2["product_stock"]; ?>"/>
        <span class="shop_span_8">หมวดหมู่</span>
        <select name="category_id" id="category_id" class="shop_select_1">
        <?php
        while ($objResult4 = mysqli_fetch_array($objQuery4)) {
        ?>
        <option value="<?php echo $objResult4[0];?>" <?php if($objResult4["category_id"] == $objResult2["category_id"]) echo 'selected="selected"'; ?>><?php echo $objResult4[2];?></option>
        <?php
        }
        ?>
        </select>
        <input type="submit" name="submit" id="submit" class="shop_input_4" value="บันทึกข้อมูล"/>
      </div>
      <input type="hidden" name="product_id" id="product_id" value="<?php echo $objResult2["product_id"];?>">
    </form>
  </div>
  <hr>
  <?php include '../includes/footer.php';?>
  <?php mysqli_close($Connection); ?>
</body>
</html>
