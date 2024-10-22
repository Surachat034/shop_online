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

    $category_id = null;

    if(isset($_GET["category_id"])){
        $category_id = $_GET["category_id"];
    }

    $strSQL2 = "SELECT * FROM category WHERE category_id = '".$category_id."' ";
    $objQuery2 = mysqli_query($Connection,$strSQL2);
    $objResult2 = mysqli_fetch_array($objQuery2,MYSQLI_ASSOC);

    if (isset($_POST["submit"])) {
      $strSQL3 = "UPDATE category SET category_num = '".$_POST["category_num"]."' , category_name = '".$_POST["category_name"]."' WHERE category_id = '".$_POST["category_id"]."' ";
      $objQuery3 = mysqli_query($Connection,$strSQL3);

      header("location:category.php");
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
    <span class="shop_span_7">ID หลัก : <?php echo $objResult2["category_id"]; ?></span>
    <form name="category_edit" method="post">
      <div class="shop_div_5">
        <span class="shop_span_8">ลำดับที่</span>
        <input type="text" name="category_num" id="category_num" class="shop_input_1" value="<?php echo $objResult2["category_num"]; ?>"/>
        <span class="shop_span_8">ชื่อหมวดหมู่</span>
        <input type="text" name="category_name" id="category_name" class="shop_input_1" value="<?php echo $objResult2["category_name"]; ?>"/>
        <input type="submit" name="submit" id="submit" class="shop_input_4" value="บันทึกข้อมูล"/>
      </div>
      <input type="hidden" name="category_id" id="category_id" value="<?php echo $objResult2["category_id"];?>">
    </form>
  </div>
  <hr>
  <?php include '../includes/footer.php';?>
  <?php mysqli_close($Connection); ?>
</body>
</html>
