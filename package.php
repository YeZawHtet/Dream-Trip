<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Travel | Packages</title>
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
  <div class="heading" style="background:url(images/popa-trekking.jpg) no-repeat">
    <h1>packages</h1>
  </div>
  <!-- packages section start -->
  <section class="packages" data-aos="fade-up">
    <h1 class="heading-title">top destinations</h1>
    <div class="box-container" data-aos="flip-right">
      <?php
      require_once 'db.php';
      $trip_type_name = "Package";
      $tidq = mysqli_query($conn, "SELECT * FROM trip_types WHERE trip_type_name LIKE '%$trip_type_name%'");
      $tid = mysqli_fetch_array($tidq);
      $trip_type_id = $tid['trip_type_id'];
      $q = mysqli_query($conn, "SELECT * FROM trip_packages WHERE trip_type_id = $trip_type_id") or die(mysqli_error($conn));
      while ($row = mysqli_fetch_array($q)) {
        $tpID = $row['package_id'];
        $tpName = $row['package_name'];
      ?>
        <div class="box" data-aos="flip-left">
          <div class="image">
            <img src="ADMINDASH/assets/img/<?php echo $row['image']; ?>" alt="package image">
          </div>
          <div class="content">
            <h3 style="display:none;"><?php echo $row['package_id']; ?></h3>
            <h3><?php echo $row['package_name']; ?></h3>
            <p><?= $row['package_intro']; ?></p>
            <p class="departure" data-aos="fade-up">
              Departure <i class="fas fa-map-marker"></i> <?= $row['departure']; ?>
            </p>
            <p class="departure" data-aos="fade-up">
              Duration <i class="fas fa-clock"></i> <?= $row['duration']; ?>
            </p>
            <p class="departure" data-aos="fade-up">
              Price <i class="fas fa-money-bill"></i> <?= $row['price']; ?> Ks
            </p>
            <a href="package-detail.php?tpID=<?php echo $row['package_id']; ?>&tpName=<?php echo $row['package_name']; ?>" class="btn">view details</a>
          </div>
        </div>
      <?php
      }
      ?>
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