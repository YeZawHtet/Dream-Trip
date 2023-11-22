<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Travel | Home</title>
  <!--swiper css-->
  <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css">
  <!--font-awesome-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <!-- AOS CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css">
  <!--custom css-->
  <link rel="stylesheet" href="css/style.css">
  <style>
    .desire-container {
      display: flex;
      align-items: center;
      justify-content: space-between;
      flex-wrap: wrap;
    }

    @media (max-width:768px) {
      .desire-container {
        justify-content: center;
      }
    }

    .mb-20 {
      margin-bottom: 20px;
    }

    .desireButton {
      width: 17rem;
      height: 40px;
      background: #222;
      color: white;
      font-weight: bold;
      cursor: pointer;
    }

    .desireButton:hover {
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
      background: #1cfb2e;
      color: #222;
      transition: background 0.3s ease, color 0.3s ease;
    }

    .box1 select,
    .box1 input[type="date"] {
      background-color: red;
      width: 17rem;
      height: auto;
      padding: 1rem;
      cursor: pointer;
    }

    /* for service section flip card */
    .card-container {
      display: flex;
      flex-wrap: wrap;
    }

    .card {
      width: 30%;
      height: 300px;
      perspective: 500px;
      margin: 10px;
      transform-style: preserve-3d;
    }

    @media (max-width:768px) {
      .card {
        width: 100%;
      }
    }

    .front,
    .back {
      width: 100%;
      height: 100%;
      position: absolute;
      transition: transform 0.8s;
      box-shadow: 0 0 5px 2px rgba(50, 50, 50, 0.25);
      backface-visibility: hidden;
    }

    .front {
      background-size: calc(100px);
      background-image: url('');
      background-repeat: no-repeat;
      background-position: center center;
    }

    .back {
      background-color: #4CAF50;
      transform: rotateY(180deg);
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      padding: 20px;
    }

    .back p {
      padding: 10px;
      font-size: 2rem;
      text-align: center;
      color: #000;
    }

    .card h3 {
      font-size: 2.5rem;
      text-align: center;
    }

    .card:hover .front {
      transform: rotateY(180deg);
    }

    .card:hover .back {
      transform: rotateY(0deg);
    }
  </style>
</head>

<body style="background-color: #ddd;">
  <!--header section start-->
  <?php include 'header.php' ?>
  <!--header section end-->
  <!--hero section start-->
  <section class="hero">
    <div class="swiper hero-slider">
      <div class="swiper-wrapper">
        <div class="swiper-slide slide" style="background:url(images/carnival-caribbean-port-mahogany-bay-9.avif) no-repeat" data-aos="fade-up">
          <div class="content">
            <span>explore, discover, travel</span>
            <h3>travel around the world</h3>
            <a href="package.php" class="btn">discover more</a>
          </div>
        </div>
        <div class="swiper-slide slide" style="background:url(images/carnival-caribbean-port-mahogany-bay-roatan-3.avif) no-repeat" data-aos="fade-up">
          <div class="content">
            <span>explore, discover, travel</span>
            <h3>discover new places</h3>
            <a href="package.php" class="btn">discover more</a>
          </div>
        </div>
        <div class="swiper-slide slide" style="background:url(images/carnival-alaska-region-image-5.avif) no-repeat" data-aos="fade-up">
          <div class="content">
            <span>explore, discover, travel</span>
            <h3>make your tour worthwhile</h3>
            <a href="package.php" class="btn">discover more</a>
          </div>
        </div>
      </div>
      <div class="swiper-button-next"></div>
      <div class="swiper-button-prev"></div>
    </div>
  </section>
  <hr>
  <!--hero section end-->
  <!--service section start-->
  <section class="services" data-aos="zoom-in">
    <h1 class="heading-title">Our services</h1>
    <div class="card-container">
      <?php
      include_once 'db.php';

      $q = mysqli_query($conn, 'select * from trip_types');
      $paragraphs = array(
        "Explore captivating landscapes, landmarks, and cultures with our Sightseeing tours. Unforgettable experiences",
        "Discover handpicked destinations with our Package Tours. Everything's taken care of, from itineraries to accommodations, ensuring a hassle-free adventure.",
        "Embark on a memorable journey at sea with our Cruise packages. Indulge in scenic beauty, exotic ports, and onboard luxuries."
      );

      $i = 0; // Initialize an index for the array
      while ($row = mysqli_fetch_array($q)) {
        $trip_type_name = $row['trip_type_name'];
      ?>
        <div class="card" data-aos="zoom-in">
          <div class="front" style="background-image: url('ADMINDASH/assets/img/<?php echo $row['image']; ?>')">
          </div>
          <div class="back">
            <?php
            // Define the default link
            $link = 'cruise.php';

            // Determine the link based on $trip_type_name
            if ($trip_type_name == "SightSeeing") {
              $link = 'sightseeing.php';
            } elseif ($trip_type_name == "Package Tour") {
              $link = 'package.php';
            }
            ?>
            <a href="<?= $link ?>">
              <h3><?php echo $row['trip_type_name']; ?></h3>
              <p><?= $paragraphs[$i]; ?></p>
            </a>
          </div>
        </div>
      <?php
        $i++;
      }
      ?>
    </div>


  </section>
  <hr>
  <!--service section end-->
  <!--Desire section start-->
  <section class="Desire" data-aos="flip-right">
    <h1 class="heading-title">Request Desire Trips</h1>
    <form action="index.php" method="post">
      <div class="desire-container">
        <div class="box1 mb-20" data-aos="zoom-in">
          <select name="tpID" class="form-select" required>
            <option value="">Select Trip type</option>
            <?php
            $query = "SELECT * FROM trip_types;";
            $result = mysqli_query($conn, $query);
            if ($result) {
              while ($row = mysqli_fetch_assoc($result)) {
                $tpID = $row["trip_type_id"];
                $tpName = $row['trip_type_name'];
                echo "<option value='$tpID'>$tpName</option>";
              }
            } else {
              echo "Error fetching trip packages from the database.";
            }
            ?>
          </select>
        </div>
        <div class="box1 mb-20" data-aos="zoom-in">
          <input type="date" name="date" value="<?php echo date('Y-m-d'); ?>" required>
        </div>
        <div class="box1 mb-20" data-aos="zoom-in">
          <select name="dTime" class="form-select" required>
            <option value="">Select Trip Duration</option>
            <option value="1D to 3D">1D to 3D</option>
            <option value="3D to 5D">3D to 5D</option>
            <option value="5D to 7D">5D to 7D</option>
            <option value="Above 10D">Above 10D</option>
          </select>
        </div>
        <div class="box1 mb-20" data-aos="zoom-in">
          <button class="desireButton" name="request" type="submit">Request Desire Trip</button>
        </div>
      </div>
    </form>
  </section>
  <hr>
  <?php
  if (isset($_POST["request"])) {
    $cusID = $_SESSION['customer_id'];
    $tID = $_POST['tpID'];
    $date = $_POST['date'];
    $duration = $_POST['dTime'];
    if (!isset($_SESSION['customer_id'])) {
      echo "<script> alert('You Need to Login First!'); location.assign('login.php');</script>";
    } else {
      // Check if a desire trip with the same details already exists
      $query = "SELECT * FROM desire_trips WHERE customer_id = $cusID AND trip_type_id = $tID AND desire_date = '" . $date . "' AND duration = '" . $duration . "'";
      $result = mysqli_query($conn, $query);

      if (mysqli_num_rows($result) > 0) {
        echo "<script> alert('Desire trip already exists!'); location.assign('index.php');</script>";
      } else {
        // Insert a new desire trip if it doesn't already exist
        $insertQuery = "INSERT INTO desire_trips (customer_id, trip_type_id, desire_date, duration) VALUES ($cusID, $tID, '$date', '$duration')";
        $insertResult = mysqli_query($conn, $insertQuery);

        if ($insertResult) {
          echo "<script> alert('Successfully Requested!'); location.assign('index.php');</script>";
        } else {
          echo "<script> alert('Failed to request a trip. Please try again.'); location.assign('index.php');</script>";
        }
      }
    }
  }
  ?>
  <!--Desire section end-->
  <!-- Home About Section Start -->
  <section class="home-about" data-aos="flip-right">
    <div class="image">
      <img src="images/inle-lake.jpg" alt="home about Image">
    </div>
    <div class="content">
      <h3>about us</h3>
      <p>DreamTrip is your gateway to extraordinary travel experiences.
        Comprising a team of passionate globetrotters, we're dedicated
        to turning your travel dreams into memorable adventures.
        We specialize in crafting tailored itineraries that cater to your unique desires,
        offering a diverse array of journeys, including captivating sightseeing tours,
        meticulously planned package tours, and indulgent cruises.
      </p>
      <a href="about.php" class="btn">read more</a>
    </div>
  </section>
  <hr>
  <!-- Home About Section End -->
  <!-- Home Packages Section Start -->
  <section class="home-packages" data-aos="zoom-out">
    <h1 class="heading-title">Recommended Trips</h1>
    <div class="box-container" data-aos="flip-left  ">
      <?php
      require_once 'db.php';
      $status = "Recommended";
      $q = mysqli_query($conn, "SELECT * FROM trip_packages WHERE status LIKE '%$status%'") or die(mysqli_error($conn));
      while ($row = mysqli_fetch_array($q)) {
        $tpID = $row['package_id'];
        $tpName = $row['package_name'];
        $tpIntro = $row['package_intro'];
      ?>
        <div class="box" data-aos="flip-right">
          <div class="image">
            <img src="ADMINDASH/assets/img/<?= $row['image']; ?>" alt="packages image">
          </div>
          <div class="content">
            <h3><?= $tpName ?></h3>
            <p><?= $tpIntro ?></p>
            <?php
            if (isset($_SESSION['customer_id']) && !empty($_SESSION['customer_id'])) {
              // Login State
              $customer_id = $_SESSION['customer_id'];
              echo '<a href="book.php?tpID=' . $tpID . '&tpName=' . $tpName . '" class="btn">Book this tour</a>';
            } else {
              //Not Login State
              echo '<a href="login.php" class="btn">Book this tour</a>';
            }
            ?>
          </div>
        </div>
      <?php } ?>
    </div>
    <div class="load-more"><a href="package.php" class="btn">Explore more</a></div>
  </section>
  <!-- Home Packages Section End -->
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
  <!--jquery library and custom js files-->
  <script src="js/library/jquery-3.7.0.min.js"></script>
  <script src="js/ui-script.js"></script>
</body>

</html>