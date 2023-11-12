<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Travel | River Cruises-detail</title>
  <!--swiper css-->
  <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css">
  <!--font-awesome-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <!-- AOS CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css">
  <!--custom css-->
  <link rel="stylesheet" href="css/style.css">
</head>

<body>
  <!--header section start-->
  <?php include 'header.php' ?>
  <!--header section end-->
  <?php
  require_once 'db.php';
  $tpID = $_GET['tpID'];
  $q1 = mysqli_query($conn, "select * from trip_packages where package_id=$tpID");
  while ($row1 = mysqli_fetch_array($q1)) {
  ?>
  <div class="heading" style="background:url(ADMINDASH/assets/img/<?= $row1['image'];?>) no-repeat">
    <h1 style="text-align: center;"><?= $row1['package_name'];?></h1>
  </div>
  <?php } ?>
  <!-- packages section start -->
  <section class="packages" data-aos="fade-up">
    <?php
    require_once 'db.php';
    if (isset($_GET['tpID'])) {
      $tpID = $_GET['tpID'];
      $tpName = $_GET['tpName'];
      $q1 = mysqli_query($conn, "select * from trip_packages where package_id=$tpID");
      $q2 = mysqli_query($conn, "select * from details where package_id=$tpID");
      while ($row1 = mysqli_fetch_array($q1)) {

    ?>
        <h3 class="heading-title"><?= $tpName; ?></h3>
        <div class="clearfix mb-3rem">
          <h1 class="departure fl">
            Departure <i class="fas fa-map-marker"></i> <?= $row1["departure"]; ?>
          </h1>
          <h1 class="departure fr">
            Duration <i class="fas fa-clock"></i> <?= $row1["duration"]; ?>
          </h1>
        </div>
        <div class="day-container">
          <?php while ($row2 = mysqli_fetch_array($q2)) { ?>
            <div class="day mb-2 clearfix">

              <h2><?= $row2['details_name']; ?></h2>
              <div class="grid-container" style="grid-template-columns: .3fr 1fr;">
                <div class="img">
                  <img style="width:20rem; height:150px;" src="ADMINDASH/assets/img/<?= $row2['image']; ?>" alt="cruises detail image">
                </div>
                <div class="content">
                  <p><?= $row2['details_text']; ?></p>
                </div>
              </div>
            </div>
          <?php } ?>
        </div>
    <?php }
    } ?>
    <div class="clearfix mb-3rem">
      <div class="fl">
        <a href="cruise.php" class="btn">Explore Next Tour</a>
      </div>
      <div class="fr">
        <?php
        if (isset($_SESSION['customer_id']) && !empty($_SESSION['customer_id'])) {
          // Login State
          $customer_id = $_SESSION['customer_id'];
          echo '<a href="book.php?tpID=' . $tpID . '&tpName=' . $tpName . '" class="btn">Book this tour</a>';
        } else {
          //Not Login State
          echo '<script> alert("We notice that you need to login to book a tour");</script>';
          echo '<a href="login.php" class="btn">Book this tour</a>';
        }
        ?>
      </div>
    </div>
  </section>
  <!-- packages section end -->
  <!--footer section start-->
  <?php include 'footer.php' ?>
  <!--footer section end-->
  <!--swiper js-->
  <script src="https://unpkg.com/swiper@7/swiper-bundle.min.js"></script>
  <!-- AOS JavaScript -->
  <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
  <!-- Initialize AOS -->
  <script>
    AOS.init({
      duration: 1000, // Animation duration in milliseconds
    });
  </script>
  <!--custom js file-->
  <script src="js/ui-script.js"></script>
</body>

</html>