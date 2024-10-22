

<ul>
  <li><a href="index.php"><i class="fa fa-home"></i> TP ร้านค้าออนไลน์</a></li>
  <li class="dropdown">
    <a href="javascript:void(0)" class="dropbtn"><i class="fa fa-list-alt"></i> หมวดหมู่ทั้งหมด <i class="fa fa-caret-down"></i></a>
    <div class="dropdown-content">
      <?php
      while ($objResult10 = mysqli_fetch_array($objQuery10, MYSQLI_ASSOC)) {
      ?>
      <a href="product_list.php?category_id=<?php echo $objResult10["category_id"];?>"><i class="fa fa-angle-double-right"></i> <?php echo $objResult10["category_name"]; ?></a>
      <?php
      }
      ?>
    </div>
  </li>
  <?php
  if ($_SESSION != NULL) {
  ?>
  <li><a href="profile.php"><i class="fa fa-id-card"></i> โปรไฟล์ส่วนตัว</a></li>
  <li><a href="basket.php"><i class="fa fa-shopping-basket"></i> ตะกร้าสินค้าของคุณ</a></li>
  <li><a href="order.php"><i class="fa fa-shopping-cart"></i> รายการสั่งชื้อของคุณ</a></li>
  
  <?php
  if ($_SESSION['member_level'] == "admin") {
  ?>
  <li><a href="admin/index.php"><i class="fa fa-cogs"></i> ระบบหลังบ้าน</a></li>
  <?php
  }
  ?>
  <li style="float:right"><a href="logout.php"><i class="fa fa-sign-out"></i> ออกจากระบบ</a></li>
  <li style="float:right"><a href="profile.php"><i class="fa fa-user"></i> สวัสดี  <?php echo $_SESSION["member_name"]; ?></a></li>
  <?php
  }
  ?>
  <?php
  if ($_SESSION == NULL) {
  ?>
  <li style="float:right"><a href="login.php"><i class="fa fa-sign-in"></i> เข้าสู่ระบบ</a></li>
  <?php
  }
  ?>
</ul>
