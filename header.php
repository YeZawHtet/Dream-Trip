<?php session_start();
if (isset($_SESSION['customer_id'])) {
  $customer_id = $_SESSION['customer_id'];
} ?>
<!--header section start-->
<section class="header">
  <a href="index.php" class="logo"><img style="width: 80px; height: 80px; border-radius:40px;" src="images/DreamTrip.png" alt="Logo Image"></a>
  <nav class="navbar">
    <a href="index.php" <?php if (basename($_SERVER['PHP_SELF']) === 'index.php') echo 'class="active"'; ?>>Home</a>
    <div class="dropdown">
      <button class="dropbtn">Tours <i class="fas fa-angle-down"></i></button>
      <div class="dropdown-content">
        <a href="sightseeing.php">Sightseeing</a>
        <a href="package.php">Package tour</a>
      </div>
    </div>
    <a href="cruise.php" <?php if (basename($_SERVER['PHP_SELF']) === 'cruise.php') echo 'class="active"'; ?>>Cruises</a>
    <a href="about.php" <?php if (basename($_SERVER['PHP_SELF']) === 'about.php') echo 'class="active"'; ?>>About</a>
    <a href="contactus.php" <?php if (basename($_SERVER['PHP_SELF']) === 'contactus.php') echo 'class="active"'; ?>>Contact Us</a>
    <?php
    require_once 'db.php';
    if (isset($_SESSION['customer_id'])) {
      $customer_id = $_SESSION['customer_id']; ?>
      <div class="booking-list d-none bg-primary">
        <div class="cross" style="position: absolute; cursor:pointer; right: 30px; top: 0px; font-size: 2.5rem;
  color: red; font-weight: bold; padding: 2px 10px;">X</div>
        <table style="width: 100%; text-align:center;">
          <caption style="background-color: black; padding:10px; color:gold; font-size:1.5rem">Booking History</caption>
          <tr style="background-color: grey; font-size:1.2rem; font-weight:bold;">
            <td>Package Name</td>
            <td>Booking Date</td>
            <td>Status</td>
            <td>Action</td>
          </tr>
          <?php
          $q = mysqli_query($conn, "select * from booking where customer_id= $customer_id order by booking_date DESC");
          if (mysqli_num_rows($q) > 0) {
            while ($row = mysqli_fetch_array($q)) {
              $package_id = $row['package_id'];
              $pq = mysqli_query($conn, "select * from trip_packages where package_id=$package_id");
              while ($row1 = mysqli_fetch_array($pq)) {
                $status = $row["status"];
                $booking_id = $row['booking_id'];
          ?>
                <tr>
                  <td><?= $row1['package_name']; ?></td>
                  <td><?= $row['booking_date']; ?></td>
                  <td style="color: <?= ($status == 'Accepted') ? 'green' : (($status == 'Rejected') ? 'red' : 'black') ?>;">
                    <?= $status ?>
                  </td>
                  <?php if ($status == 'Accepted' || $status == 'Rejected') { ?>
                    <td>Done</td>
                  <?php
                  } else { ?>
                    <td style="text-align: center;"><a href="header.php?bID=<?= $booking_id ?>" style="border-radius:10px; font-size:1.5rem; padding:5px; background-color: red;">Cancel</a></td> <?php } ?>
                </tr><?php }
                  }
                } else { ?>
            <tr>
              <td colspan="4">There is No Booking History. Please Make a Booking.</td>
            </tr>
          <?php } ?>
        </table>
      </div>
      <a style="color: blue; cursor:pointer;background-color: #2a2a2a; color:gold; padding:10px; margin-left:3rem; border-radius:20px;" class="booking-btn" href="#">Booking History</a>
      <a style="color:red;" href="logout.php">Logout</a>
    <?php
    } else { ?>
      <a href="register.php" <?php if (basename($_SERVER['PHP_SELF']) === 'register.php') echo 'class="active"'; ?>>Register</a>
      <a href="login.php" <?php if (basename($_SERVER['PHP_SELF']) === 'login.php') echo 'class="active"'; ?>>Login</a>
    <?php } ?>
  </nav>

  <div id="menu-btn" class="fas fa-bars"></div>
</section>
<!--header section end-->
<?php
if (isset($_GET['bID'])) {
  $bID = $_GET['bID'];
  $q = mysqli_query($conn, "delete from booking where booking_id=$bID");
  if ($q) {
    echo "<script> alert ('Booking was Cancelled!'); location.assign('index.php'); </script>";
  }
}
