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

    $total = 0;

    $strSQL = "SELECT * FROM shop_information";
    $objQuery = mysqli_query($Connection,$strSQL);
    $objResult = mysqli_fetch_array($objQuery,MYSQLI_ASSOC);

    // ตรวจสอบว่ามีพารามิเตอร์ status ถูกส่งเข้ามาหรือไม่
    $statusCondition = "";
    if (isset($_GET['status'])) {
        if ($_GET['status'] == 'pending') {
            $statusCondition = "AND order_status = 'อยู่ระหว่างรอการส่งหลักฐานการโอนเงิน'";
        } elseif ($_GET['status'] == 'completed') {
            $statusCondition = "AND order_status = 'ส่งสินค้าสำเร็จ'";
        }
    }

    $strSQL2 = "SELECT * FROM order_list 
                INNER JOIN (member, transport) 
                ON (order_list.member_id = member.member_id AND order_list.transport_id = transport.transport_id) 
                WHERE 1 $statusCondition 
                ORDER BY order_id DESC";
    $objQuery2 = mysqli_query($Connection,$strSQL2);

    $strSQL10 = "SELECT * FROM category ORDER BY category_num ASC";
    $objQuery10 = mysqli_query($Connection,$strSQL10);

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?php echo $objResult["shop_information_title"] ?></title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="../assets/css/body.css">
  <link rel="stylesheet" type="text/css" href="../assets/css/navigationbar.css">
  <link rel="stylesheet" type="text/css" href="../assets/css/shop.css">
</head>
<body>
  <?php include '../includes/navbar_admin.php';?>
  
  <div class="shop_div_10">
    <span class="shop_span_7_2">จัดการการสั่งซื่อสินค้า</span> 
    <form name="order_list_date" method="post" action="order_list_date.php">
      <span class="shop_span_7_5">ตรวจสอบการสั่งชื้อ : จากวันที่ <input type="date" name="startdate" id="startdate"> ถึง <input type="date" name="enddate" id="enddate" value="<?php echo date("Y-m-d"); ?>"> <input type="submit" name="submit" id="submit" value="ตรวจสอบ"></span>
    </form>
    
    <button type="button" class="btn btn-danger" onclick="window.location.href='?status=pending'">อยู่ระหว่างรอการส่งหลักฐานการโอนเงิน</button>
    <button type="button" class="btn btn-success" onclick="window.location.href='?status=completed'">ส่งสินค้าสำเร็จ</button>
    
      <a href="order_list.php"><button type="button" class="btn btn-secondary">ย้อนกลับ</button></a>
      <br><br>
    
    <table class="shop_table_1">
      <tr>
        <td bgcolor="#33CCFF">เลขออเดอร์</td>
        <td bgcolor="#33CCFF">วันเวลาที่สั่งชื้อ</td>
        <td bgcolor="#33CCFF">ชื่อผู้ใช้ (ผู้ชื้อ)</td>
        <td bgcolor="#33CCFF">จัดส่ง</td>
        <td bgcolor="#33CCFF">Tracking Number</td>
        <td bgcolor="#33CCFF">รวมเป็นเงิน</td>
        <td bgcolor="#33CCFF">สถานะการสั่งซื้อ</td>
        <td bgcolor="#33CCFF">ยืนยันการสั่งซื้อ</td>
        <td bgcolor="#33CCFF">รายละเอียด</td>
        <td bgcolor="#33CCFF" width="60px">ตัวเลือก</td>
      </tr>
      <?php
      while ($objResult2 = mysqli_fetch_array($objQuery2,MYSQLI_ASSOC)) {
      ?>
      <tr>
        <td><?php echo $objResult2["order_ordernumber"];?></td>
        <td><?php echo $objResult2["order_date"];?></td>
        <td><?php echo $objResult2["member_name"];?></td>
        <td><?php echo $objResult2["transport_name"]." ค่าจัดส่ง ".$objResult2["transport_price"]." บาท"; ?></td>
        <td>
          <?php
          if ($objResult2["tracking_number"] == NULL) {
            // ไม่มี Tracking Number
          } else {
          ?>
          <?php echo $objResult2["tracking_number"];?> <a class="shop_a_3" href="tracking_number_edit.php?order_id=<?php echo $objResult2["order_id"];?>"><i class="fa fa-pencil-square"></i></a>
          <?php
          }
          ?>
        </td>
        <td><?php echo $objResult2["order_price"] + $objResult2["transport_price"]." บาท";?></td>
        <td>
          <?php
          if ($objResult2["order_status"] == 'อยู่ระหว่างรอการส่งหลักฐานการโอนเงิน') {
            echo "<b style='color:red'> อยู่ระหว่างรอการส่งหลักฐานการโอนเงิน </b>";
          } elseif ($objResult2["order_status"] == 'อยู่ระหว่างการตรวจหลักฐาน') {
          ?>
            <span><a class="shop_a_4" target="_blank" href="../images/money_transfer_slip/<?php echo $objResult2["order_img"]; ?>">ตรวจหลักฐาน</a></span>
          <?php
          } elseif ($objResult2["order_status"] == 'อยู่ระหว่างจัดส่งสินค้า') {
          ?>
            <span>อยู่ระหว่างจัดส่งสินค้า <a class="shop_a_4" href="order_list_member.php?member_id=<?php echo $objResult2["member_id"];?>">ข้อมูลลูกค้า</a></span>
          <?php
          } elseif ($objResult2["order_status"] == 'ส่งสินค้าสำเร็จ') {
          ?>
            <span><b style="color:#00E676;">ส่งสินค้าสำเร็จ</b></span>
          <?php
          }
          ?>
        </td>
        <td>
          <?php
          if ($objResult2["order_status"] != 'ส่งสินค้าสำเร็จ') {
          ?>
            <a class="shop_a_5" href="JavaScript:if(confirm('คุณแน่ใจใช่หรือไม่')==true){window.location='order_list_past.php?order_id=<?php echo $objResult2["order_id"];?>';}"><i class="fa fa-check"></i></a>
          <?php
          }
          ?>
        </td>
        <td>
  <a class="shop_a_5" href="../order_view.php?order_ordernumber=<?php echo $objResult2["order_ordernumber"];?>" target="_blank">
    <i class="fa fa-eye"></i>
  </a>
</td>

        <td>
          <?php
          // แสดงปุ่มลบข้อมูลเฉพาะเมื่อสถานะการสั่งซื้อไม่ใช่ 'ส่งสินค้าสำเร็จ'
          if ($objResult2["order_status"] != 'ส่งสินค้าสำเร็จ') {
          ?>
            <a class="shop_a_3" href="JavaScript:if(confirm('คุณต้องการลบข้อมูลใช่หรือไม่')==true){window.location='order_list_delete.php?order_id=<?php echo $objResult2["order_id"];?>&order_ordernumber=<?php echo $objResult2["order_ordernumber"];?>';}"><i class="fa fa-trash"></i></a>
          <?php
          }
          ?>
        </td>
      </tr>
      <?php
      $total = $total + ($objResult2["order_price"] + $objResult2["transport_price"]);
      }
      ?>
    </table>
    <span class="shop_span_7_4"><span class="shop_span_7_4_1">สรุป</span> ยอดรวมทั้งหมด <?php echo $total; ?> บาท</span>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <hr>
  <?php include '../includes/footer.php';?>
  <?php mysqli_close($Connection); ?>
</body>
</html>
