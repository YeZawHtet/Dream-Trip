<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Travel | SightSeeing</title>
  <!--swiper css-->
  <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css">
  <!--font-awesome-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <!-- AOS CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css">
  <!--custom css-->
  <link rel="stylesheet" href="css/style.css">
  <style>
    /* for service section flip card */
    .sightseeing {
      margin-bottom: 20px;
    }

    .sightseeing .box-container {
      display: grid;
      grid-template-columns: 47% 47%;
      column-gap: 6%;
    }

    .content h2 {
      font-size: 2rem;
      animation: colorChange 5s ease-in-out 1s infinite;
    }

    @keyframes colorChange {
      0% {
        color: white;
      }

      100% {
        color: #000;
      }
    }

    .card {
      width: 100%;
      height: 400px;
      perspective: 800px;
      margin: 10px;
      transform-style: preserve-3d;
      font-size: 1.5rem;
    }

    @media (max-width:768px) {
      .sightseeing .box-container {
        display: grid;
        grid-template-columns: 100%;
      }

      .card {
        height: 500px;
      }

      .card h2 {
        font-size: 1rem;
      }

      .card p {
        font-size: 1rem;
      }
    }

    .card p {
      font-size: 1.5rem;
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
      background-size: cover;
      background-image: url('');
      background-repeat: no-repeat;
      background-position: center center;
      display: flex;
      justify-content: center;
      align-items: center;
      color: #fff;
    }

    .flex-container {
      display: flex;
      justify-content: space-around;
      align-items: center;
    }

    .front p {
      background-color: transparent;
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
      text-align: center;
      color: #000;
    }

    .card h2 {
      font-size: 2rem;
    }

    .card:hover .front {
      transform: rotateY(180deg);
    }

    .card:hover .back {
      transform: rotateY(0deg);
    }
  </style>
</head>

<body>
  <!--header section start-->
  <?php include 'header.php' ?>
  <!--header section end-->
  <div class="heading" style="background:url(images/kyaiktiyo-pagoda.jpg) no-repeat">
    <h1>SightSeeing</h1>
  </div>
  <!-- sightseeing section start -->
  <section class="sightseeing" data-aos="fade-up">
    <h1 class="heading-title">top destinations</h1>
    <div class="box-container">
      <?php
      require_once 'db.php';
      $trip_type_name = "SightSeeing";
      $tidq = mysqli_query($conn, "SELECT * FROM trip_types WHERE trip_type_name LIKE '%$trip_type_name%'");
      $tid = mysqli_fetch_array($tidq);
      $trip_type_id = $tid['trip_type_id'];
      $q = mysqli_query($conn, "SELECT * FROM trip_packages WHERE trip_type_id = $trip_type_id") or die(mysqli_error($conn));
      while ($row = mysqli_fetch_array($q)) {
        $tpID = $row['package_id'];
        $tpName = $row['package_name'];
      ?>
        <div class="card" data-aos="zoom-in">
          <div class="front" style="background-image: url(ADMINDASH/assets/img/<?php echo $row['image']; ?>);">
            <div class="content" data-aos="fade-up">
              <h2 style="text-align: center;"><?= $tpName; ?></h2>
            </div>
          </div>
          <div class="back">
            <h2 style="text-align: center;"><?= $tpName; ?></h2>
            <p style="text-align: center;"><?= $row['package_intro']; ?></p>
            <div class="flex-container">
              <p class="departure fl mr-5rem" data-aos="fade-up">
                <i class="fas fa-map-marker"></i> <?= $row['departure']; ?>
              </p>
              <p class="departure fl tc" data-aos="fade-up">
                <i class="fas fa-clock"></i> <?= $row['duration']; ?>
              </p>
            </div>
            <p class="departure fr" data-aos="fade-up">
              <i class="fas fa-money-bill"></i> <?= $row['price']; ?> Ks
            </p>
            <a href="sightseeing-detail.php?tpID=<?= $tpID ?>&tpName=<?= $tpName ?>" class="btn fr">View Details</a>
          </div>
        </div>

      <?php
      }
      ?>
    </div>
  </section>
  <!-- sightseeing section end -->
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