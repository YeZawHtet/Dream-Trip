<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Travel | Book</title>
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
  <div class="heading" style="background:url(images/Ngwe-Saung.jpg) no-repeat">
    <h1>book</h1>
  </div>
  <!-- booking section start -->
  <section class="booking" data-aos="fade-up">
    <h1 class="heading-title">book your trip!</h1>
    <form action="book.php" method="post" class="book-form">
      <div class="flex">
        <?php
        include_once 'db.php';
        if (isset($_GET['tpID'])) {
          $tpID = $_GET['tpID'];
          $tpName = $_GET['tpName'];
          $q = mysqli_query($conn, "select * from customer where customer_id=$customer_id");
          while ($row = mysqli_fetch_array($q)) {
        ?>
            <div class="inputBox" data-aos="fade-up">
              <span>name :</span>
              <input type="text" placeholder="enter your name" value="<?= $row['customer_name']; ?>" name="name" required>
            </div>
            <div class="inputBox" data-aos="fade-up">
              <span>email :</span>
              <input type="text" placeholder="enter your email" value="<?= $row['email']; ?>" name="email" required>
            </div>
            <div class="inputBox" data-aos="fade-up">
              <span>address :</span>
              <input type="text" placeholder="enter your address" value="<?= $row['address']; ?>" name="address" required>
            </div>
            <div class="inputBox" data-aos="fade-up">
              <span>where to :</span>
              <input style="display: none;" type="text" placeholder="place you want to visit" value="<?= $tpID ?>" name="tpID" required>
              <input type="text" placeholder="place you want to visit" value="<?= $tpName ?>" name="tpName" required>
            </div>
            <div class="inputBox" data-aos="fade-up">
              <span>Date :</span>
              <input type="date" id="leavingDate" name="leaving" required>
            </div>
      </div>
  <?php }
        } ?>
  <input type="submit" value="Book" class="btn" data-aos="fade-up" name="Book">
    </form>
  </section>
  <?php
  if (isset($_POST['Book'])) {
    $cusID = $customer_id;
    $tpID = $_POST['tpID'];
    $status = "Default";
    $date = $_POST['leaving'];
    $q = mysqli_query($conn, "INSERT INTO booking (booking_date, status, package_id, customer_id) VALUES ('" . $date . "', '" . $status . "', $tpID, $cusID)");
    if ($q) {
      echo "<script>alert('Successfully Booked'); location.assign('index.php');</script>";
    } else {
      echo "<script>alert('Error while booking. Please try again.');</script>";
    }
  }
  ?>
  <!-- booking section end -->
  <!--footer section start-->
  <?php include 'footer.php' ?>
  <!--footer section end-->
  <script>
    document.querySelector('form').addEventListener('submit', function(event) {
      const leavingDate = new Date(document.getElementById('leavingDate').value);
      const currentDate = new Date();

      if (leavingDate < currentDate) {
        alert('Booking date cannot be in the past. Please select a valid date.');
        event.preventDefault(); // Prevent form submission if the date is invalid
      }
    });
  </script>
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