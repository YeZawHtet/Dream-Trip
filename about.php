<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Travel | About</title>
  <!--swiper css-->
  <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css">
  <!--font-awesome-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <!-- AOS CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css">
  <!--custom css-->
  <link rel="stylesheet" href="css/style.css">
  <style>
    .swiper-pagination-bullet {
      width: 20px;
      height: 20px;
      text-align: center;
      line-height: 20px;
      font-size: 12px;
      color: #000;
      opacity: 1;
      background: rgba(0, 0, 0, 0.2);
    }

    .swiper-pagination-bullet-active {
      color: #fff;
      background: #007aff;
    }
  </style>
</head>

<body>

  <!--header section start-->
  <?php include 'header.php' ?>
  <!--header section end-->
  <div class="heading" style="background:url(images/Ngwe-Saung.jpg) no-repeat">
    <h1>about us</h1>
  </div>
  <!--about section start-->
  <section class="about" data-aos="fade-up">
    <div class="image">
      <img src="images/inle-lake.jpg" alt="about image">
    </div>
    <div class="content">
      <h3>Why choose us?</h3>
      <p>DreamTrip is your gateway to extraordinary travel experiences. Our dedicated team tailors unique itineraries, offering competitive pricing and world-class service. With 24/7 support, sustainable travel practices, and glowing reviews, we're your trusted partner for unforgettable journeys. Choose DreamTrip for your dream adventure.
      </p>
      <div class="icons-container" data-aos="fade-up">
        <div class="icons">
          <i class="fas fa-map"></i>
          <span>top destinations</span>
        </div>
        <div class="icons">
          <i class="fas fa-hand-holding-usd"></i>
          <span>affordable price</span>
        </div>
        <div class="icons">
          <i class="fas fa-headset"></i>
          <span>24/7 services</span>
        </div>
      </div>
    </div>
  </section>
  <!--about section end-->
  <!-- reviews section start -->
  <section class="reviews" data-aos="fade-up">
    <h3 class="heading-title">Reviews given</h3>
    <div class="swiper reviews-slider">
      <div class="swiper-wrapper">
        <?php
        require_once 'db.php';
        $q = mysqli_query($conn, 'select * from review');
        while ($row = mysqli_fetch_array($q)) {
          $cusID = $row['customer_id'];
          $cusq = mysqli_query($conn, "select * from customer where customer_id=$cusID");
          while ($cusr = mysqli_fetch_array($cusq)) {
        ?>
            <div class="swiper-slide slide">
              <div class="stars">
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
              </div>
              <p><?php echo $row['feedback']; ?></p>
              <h3><?php echo $cusr['customer_name']; ?></h3>
              <span><?php echo $cusr['address']; ?></span>
              <img src="images/inle-lake.jpg" alt="profile">
            </div>
        <?php
          }
        }
        ?>
      </div>
    </div>
    <div class="swiper-pagination"></div>

  </section>
  <section class="contact" data-aos="fade-up">
    <p style="font-size:1.5rem; font-weight: bold; text-align:center;">You can also <b>Review</b> to our website</p>
    <form action="about.php" method="post" class="contact-form">
      <div class="inputBox">
        <textarea name="review" placeholder="Enter your review" cols="30" rows="5" required></textarea>
      </div>
      <input type="submit" value="Give Review" class="btn" name="send">
    </form>
  </section>
  <!-- reviews section end -->
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
<?php
if (isset($_POST['send'])) {
  if (isset($_SESSION['customer_id'])) {
    $qcheck = mysqli_query($conn, "select * from review where customer_id=$customer_id");
    $result = mysqli_num_rows($qcheck);
    if ($result > 0) {
      echo "<script> alert ('Review Already Given!');</script>";
    } else {
      $review = $_REQUEST['review'];

      // Assuming you have a valid database connection in $conn
      if ($stmt = $conn->prepare("INSERT INTO review (feedback, customer_id) VALUES (?, ?)")) {
        $stmt->bind_param("si", $review, $customer_id);
        if ($stmt->execute()) {
          echo "<script>alert('Review Given Successfully');</script>";
        } else {
          echo "<script>alert('Error while saving the review');</script>";
        }
      }
    }
  } else {
    echo "<script> alert ('You Need to Login to Review Our website'); location.assign('login.php');</script>";
  }
}
?>