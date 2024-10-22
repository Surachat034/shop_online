<?php
// เริ่มคำสั่ง Export ไฟล์ PDF
require_once __DIR__ . '/vendor/autoload.php';

$defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
$fontDirs = $defaultConfig['fontDir'];

$defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
$fontData = $defaultFontConfig['fontdata'];

$mpdf = new \Mpdf\Mpdf([
    'fontDir' => array_merge($fontDirs, [
        __DIR__ . '/tmp',
    ]),
    'fontdata' => $fontData + [
        'sarabun' => [
            'R' => 'THSarabunNew.ttf',
            'I' => 'THSarabunNew Italic.ttf',
            'B' => 'THSarabunNew Bold.ttf',
            'BI' => 'THSarabunNew BoldItalic.ttf'
        ]
    ], 
    'default_font' => 'sarabun'
]);
// สิ้นสุดคำสั่ง Export ไฟล์ PDF ในส่วนบน เริ่มกำหนดตำแหน่งเริ่มต้นในการนำเนื้อหามาแสดงผลผ่าน
$mpdf->SetFont('sarabun','',14);
ob_start();  //ฟังก์ชัน ob_start()
?>

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

    $strSQL2 = "SELECT * FROM member 
                INNER JOIN order_list ON member.member_id = order_list.member_id 
                INNER JOIN transport ON order_list.transport_id = transport.transport_id
                WHERE order_list.order_ordernumber = '".$_GET["order_ordernumber"]."'";
    $objQuery2 = mysqli_query($Connection,$strSQL2);
    $objResult2 = mysqli_fetch_array($objQuery2,MYSQLI_ASSOC);

   

    // คำสั่ง SQL ใหม่ที่รวมการดึงข้อมูลจาก transport
     $strSQL2 = "SELECT * FROM order_list 
                INNER JOIN member ON order_list.member_id = member.member_id 
                INNER JOIN transport ON order_list.transport_id = transport.transport_id
                WHERE order_list.order_ordernumber = '".$_GET["order_ordernumber"]."'";
    $objQuery2 = mysqli_query($Connection,$strSQL2); 

    $order_ordernumber = null;

    if(isset($_GET["order_ordernumber"])){
        $order_ordernumber = $_GET["order_ordernumber"];
    }

    $strSQL2 = "SELECT * FROM basket 
                INNER JOIN product ON basket.product_id = product.product_id 
                WHERE order_ordernumber = '".$order_ordernumber."'";
    $objQuery2 = mysqli_query($Connection,$strSQL2);

    $strSQL3 = "SELECT * FROM basket WHERE order_ordernumber = '".$order_ordernumber."'";
    $objQuery3 = mysqli_query($Connection,$strSQL3);
    $objResult3 = mysqli_fetch_array($objQuery3,MYSQLI_ASSOC);

    $a = 1;
    $total = 0;

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
  
  <div class="shop_div_2">
    
    <span class="shop_span_7">หมายเลขสถานะการสั่งซื้อ <?php echo $objResult3["order_ordernumber"] ; ?>
    <br> ชื่อผู้สั่งซื้อสินค้า : <?php echo $objResult2["member_name"]; ?>  
    <br> ที่อยู่ : <?php echo nl2br($objResult2["order_address"]);  ?> 
    <br> เบอร์โทรศัพท์ : <?php echo $objResult2["member_tel"]; ?>
    <br> ขนส่ง : <?php echo $objResult2["transport_name"]; ?>
    
    
   </span>
    <div class="shop_div_7">
      <table class="shop_table_1">
        <tr>
          <td bgcolor="#33CCFF">ลำดับ</td>
          <td bgcolor="#33CCFF">ชื่อสินค้า</td>
          <td bgcolor="#33CCFF">ราคา</td>
          <td bgcolor="#33CCFF">จำนวนที่สั่งชื้อ</td>
          <td bgcolor="#33CCFF">รวมเป็นเงิน</td>
        </tr>
        <?php
        while ($objResult2 = mysqli_fetch_array($objQuery2,MYSQLI_ASSOC)) {
        ?>
        <tr>
          <td><?php echo $a; ?></td>
          <td><?php echo $objResult2["product_name"]; ?></td>
          <td><?php echo $objResult2["product_price"]." บาท"; ?></td>
          <td><?php echo $objResult2["basket_amount"]; ?></td>
          <td><?php echo $objResult2["product_price"] * $objResult2["basket_amount"]." บาท"; ?></td>
        </tr>
        <?php
        $total = $total + ($objResult2["product_price"] * $objResult2["basket_amount"]);
        $a++;
        }
        ?>
        <tr>
          <td bgcolor="#BEBEBE"></td>
          <td bgcolor="#BEBEBE"></td>
          <td bgcolor="#BEBEBE"></td>
          <td bgcolor="#BEBEBE" style="color:#FF0000">รวมเป็นเงินทั้งหมด</td>
          <td bgcolor="#BEBEBE" style="color:#FF0000"><?php echo $total." บาท"; ?></td>
        </tr>
      </table>
    </div>

    <?php
    // คำสั่งการ Export ไฟล์เป็น PDF
    $html = ob_get_contents();      // เรียกใช้ฟังก์ชัน รับข้อมูลที่จะมาแสดงผล
    $mpdf->WriteHTML($html);        // รับข้อมูลเนื้อหาที่จะแสดงผลผ่านตัวแปร $html
    $mpdf->Output('TPSHOP.pdf');  //สร้างไฟล์ PDF ชื่อว่า myReport.pdf
    ob_end_flush();                 // ปิดการแสดงผลข้อมูลของไฟล์ HTML ณ จุดนี้
    ?>
      <div class="shop_div_11">
       
      <a href="TPSHOP.pdf" target="_blank">
    <button class="shop_button_2">พิมพ์</button>
</a>

      </div>
      
      
    </form>
    <!--การสร้างลิงค์ เรียกไฟล์ myReport.pdf แสดงผลไฟล์ PDF  -->
    

  </div>
  <hr>
  <?php include 'includes/footer.php';?>
  <?php mysqli_close($Connection); ?>
</body>
</html>
