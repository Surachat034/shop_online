<ul>
  <li><a><?php echo $objResult['shop_information_name']; ?></a></li>
  <li><a href="index.php"><i class="fa fa-home"></i> หน้าแรก</a></li>
  <?php
  if ($_SESSION != NULL) {
  ?>
  <li><a href="profile.php"><i class="fa fa-id-card"></i> โปรไฟล์ส่วนตัว</a></li>
  <li><a href="order.php"><i class="fa fa-shopping-basket"></i> รายการสั่งชื้อของคุณ</a></li>
  <?php
  if ($_SESSION['member_level'] == "admin") {
  ?>
  <li><a href="admin/index.php"><i class="fa fa-cogs"></i> ระบบหลังบ้าน</a></li>
  <?php
  }
  ?>
  <li style="float:right"><a href="logout.php"><i class="fa fa-sign-out"></i> ออกจากระบบ</a></li>
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
