<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Travel | Contact</title>
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
  <!-- Include the header -->
  <?php include 'header.php' ?>

  <div class="heading" style="background:url(images/Ngwe-Saung.jpg) no-repeat">
    <h1>Contact Us</h1>
  </div>
  <section class="contact-methods" data-aos="fade-up">
    <h1 style="text-align:center; font-size:2rem;" class="mb-3rem">Contact Information</h1>
    <h2 style="text-align:center" class="mb-3rem">You can reach out to us through the following methods:</h2>
    <div class="contact-info mb-3rem">
      <div class="info-item">
        <p><i class="fas fa-map-marker-alt"></i> MaharAungMyay, Mandalay, Myanmar</p>
      </div>
      <div class="info-item">
        <p><i class="fas fa-envelope"></i> <a href="mailto:davidbackend789@gmail.com">davidbackend789@gmail.com</a></p>
      </div>
      <div class="info-item">
        <p><i class="fas fa-phone"></i> <a href="tel:+123456789">+959987654321</a></p>
      </div>
    </div>
  </section>
  <section class="contact" data-aos="fade-up">
    <p style="font-size:1.5rem; font-weight: bold;">You can also contact us using the contact form below. If you have an itinerary in mind that you would like to discuss.</p>
    <form action="https://formspree.io/f/mwkdzqyk" method="post" class="contact-form">
      <input type="hidden" name="_next" value="<?php echo $_SERVER['PHP_SELF']; ?>">
      <div class="inputBox">
        <label for="name">Name:</label>
        <input type="text" name="name" placeholder="Enter your name" required>
      </div>
      <div class="inputBox">
        <label for="email">Email:</label>
        <input type="email" name="email" placeholder="Enter your email" required>
      </div>
      <div class="inputBox">
        <label for="message">Message:</label>
        <textarea name="message" placeholder="Enter your message" required></textarea>
      </div>
      <input type="submit" value="Send Message" class="btn" name="send">
    </form>
  </section>

  <!-- Include the footer -->
  <?php include 'footer.php' ?>

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