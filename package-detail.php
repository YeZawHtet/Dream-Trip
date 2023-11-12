<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Travel | Package-detail</title>
  <!--swiper css-->
  <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css">
  <!--font-awesome-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <!-- AOS CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css">
  <!--custom css-->
  <link rel="stylesheet" href="css/style.css">
  <style>
    .grid-container .image img {
      width: 100%;
      height: 300px;
    }

    @media (max-width:768px) {
      .grid-container {
        grid-template-columns: 1fr;
      }

      .grid-container .image {
        width: 100%;
      }
    }
  </style>
</head>

<body>
  <!--header section start-->
  <?php include 'header.php' ?>
  <!--header section end-->
  <?php
  require_once 'db.php';
  $tpID = $_GET['tpID'];
  $q1 = mysqli_query($conn, "select * from trip_packages where package_id=$tpID");
  while ($row = mysqli_fetch_array($q1)) {
    // Your encoded string
    $encodedString = urlencode($row['image']);
    // Replace '+' with '%20'
    $decodedString = str_replace('+', '%20', $encodedString);

  ?>
    <div class="heading" style="background:url(ADMINDASH/assets/img/<?= $decodedString ?>) no-repeat">
      <h1 style="text-align:center;"><?= $row['package_name']; ?></h1>
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
      while ($row1 = mysqli_fetch_array($q1)) {
      }
    ?>
      <h3 class="heading-title"><?= $tpName; ?></h3>
      <div class="day-container">
        <?php
        $q = mysqli_query($conn, "select * from details where package_id=$tpID");
        while ($row = mysqli_fetch_array($q)) {
        ?>
          <div class="day clearfix" data-aos="fade-up">
            <h2><?= $row['details_name']; ?></h2>
            <div class="grid-container">
              <div class="image">
                <img src="ADMINDASH/assets/img/<?= $row['image']; ?>" alt="day1">
              </div>
              <div class="content">
                <p><?php echo $row['details_text']; ?></p>
              </div>
            </div>
          </div>
      <?php
        }
      }
      ?>
      <div class="clearfix mb-3rem">
        <div class="fl">
          <a href="package.php" class="btn">Explore Next Tour</a>
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