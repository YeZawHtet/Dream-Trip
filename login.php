<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Travel Login">
  <meta name="author" content="Anonymous">
  <title>Travel | Login Page</title>

  <!-- External CSS -->
  <link href="ADMINDASH/css/styles.css" rel="stylesheet">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css">
  <!-- Custom CSS for video background -->
  <style>
    body {
      margin: 0;
      padding: 0;
      overflow: hidden;
      background-color: transparent;
    }

    #video-background {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      object-fit: cover;
      z-index: -1;
    }

    #layoutAuthentication_content {
      position: relative;
      z-index: 1;
    }
    .card{
      background-color: rgba(200, 200, 200, 0.9);
    }
  </style>
</head>

<body>
  <video id="video-background" autoplay loop muted>
    <source src="images/bg.mp4" type="video/mp4">
  </video>
  <div id="layoutAuthentication">
    <div id="layoutAuthentication_content">
      <main>
        <div class="container mt-5">
          <div class="row justify-content-center">
            <div class="col-lg-5">
              <div class="card shadow-lg border-0 rounded-lg mt-5">
                <div class="card-header">
                  <h3 class="text-center font-weight-light my-4 text-primary">Login Form</h3>
                </div>
                <div class="card-body">
                  <?php
                  include 'db.php';
                  if (isset($_POST['login'])) {
                    $email = $_POST['email'];
                    $password = $_POST['password'];
                    $q = mysqli_query($conn, "select * from customer where email='" . $email . "' and password='" . $password . "'") or die(mysqli_error($conn));
                    $r = mysqli_num_rows($q);
                    $retri = mysqli_fetch_assoc($q);
                    if ($r > 0) {
                      $_SESSION['customer_id'] = $retri['customer_id'];
                      echo "<script>alert('Successfully Login'); location.assign('index.php');</script>";
                      exit();
                    } else {
                      $error = "Login Failed. Please check your email and password.";
                      $emailValue = $email; // Store the submitted email value
                      $passwordValue = $password; // Store the submitted password value
                    }
                  }
                  ?>
                  <form method="post">
                    <div class="form-floating mb-3">
                      <input class="form-control" id="inputEmail" type="email" placeholder="name@example.com" name="email" value="<?php echo isset($emailValue) ? $emailValue : ''; ?>" required />
                      <label for="inputEmail">Email address</label>
                    </div>
                    <div class="form-floating mb-3">
                      <input class="form-control" id="inputPassword" type="password" placeholder="Password" name="password" value="<?php echo isset($passwordValue) ? $passwordValue : ''; ?>" required />
                      <label for="inputPassword">Password</label>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                      <input type="submit" name="login" class="btn btn-primary" value="Login">
                      <a href="register.php">New Traveller? Sign Us Here</a>
                    </div>
                  </form>
                  <?php if (isset($error)) { ?>
                    <div class="alert alert-danger mt-3"><?php echo $error; ?></div>
                  <?php } ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </main>
    </div>
  </div>

  <!-- External JavaScript -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="js/ui-scripts.js"></script>
</body>

</html>