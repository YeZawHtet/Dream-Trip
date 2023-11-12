<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Travel | Register Form | Customer</title>
  <!--swiper css-->
  <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css">
  <!--font-awesome-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <!-- AOS CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css">
  <!--custom css-->
  <link rel="stylesheet" href="css/style.css">
</head>

<body style="background-color: rgba(0,0,0,0.7);">
  <!--header section start-->
  <?php include 'header.php' ?>
  <!--header section end-->
  <div class="heading" style="background:url(images/Highlights-Myanmar.jpg) no-repeat">
    <h1>Register Form</h1>
  </div>
  <!-- booking section start -->
  <section class="booking" data-aos="fade-up">
    <h1 class="heading-title">Traveller Information!</h1>
    <form method="post" class="book-form">
      <div class="flex">
        <div class="inputBox" data-aos="fade-up">
          <span>Name :</span>
          <input type="text" placeholder="enter your name" name="name" required>
        </div>
        <div class="inputBox" data-aos="fade-up">
          <span>Phone Number :</span>
          <input type="text" placeholder="enter your phone number" name="phone" required pattern="[0-9]+">
        </div>
        <div class="inputBox" data-aos="fade-up">
          <span>Email :</span>
          <input type="email" placeholder="enter your email" name="email" required>
        </div>
        <div class="inputBox" data-aos="fade-up">
          <span>password :</span>
          <input type="password" placeholder="enter your Password" name="password" required>
        </div>
        <div class="inputBox" data-aos="fade-up">
          <span>address :</span>
          <input type="text" placeholder="enter your address" name="address" required>
        </div>
      </div>
      <button type="submit" name="submit" class="btn btn-success">Register</button>
    </form>
    <?php
    require('db.php');
    if (isset($_POST['submit'])) {
      $name = trim($_POST['name']);
      $email = trim($_POST['email']);
      $password = trim($_POST['password']);
      $address = trim($_POST['address']);
      $phone = $_POST['phone'];
      $q = mysqli_query($conn, "insert into customer (customer_name, customer_pn_no, email, password, address) values ('$name', '$phone', '$email', '$password', '$address')");
      if ($q) {
        echo "<script>alert('Registeration Success!');location.assign('login.php');</script>";
      }
    }
    ?>
  </section>
  <!-- booking section end -->
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