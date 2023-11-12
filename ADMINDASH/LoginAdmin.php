<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Travel Admin Login">
  <meta name="author" content="Your Name">
  <title>Admin Login Page</title>

  <!-- External CSS -->
  <link href="css/styles.css" rel="stylesheet">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css">

  <!-- Custom CSS for background -->
  <style>
    body {
      background: url('assets/img/shwedagon pagoda.jpg') no-repeat center center fixed;
      background-size: cover;
    }
  </style>
</head>

<body class="bg-primary">
  <div id="layoutAuthentication">
    <div id="layoutAuthentication_content">
      <main>
        <div class="container mt-5">
          <div class="row justify-content-center">
            <div class="col-lg-5">
              <div class="card shadow-lg border-0 rounded-lg mt-5">
                <div class="card-header">
                  <h3 class="text-center font-weight-light my-4 text-primary">Admin Login</h3>
                </div>
                <div class="card-body">
                  <?php
                  include '../db.php';
                  if (isset($_POST['login'])) {
                    $email = $_POST['email'];
                    $password = $_POST['password'];
                    if ($email == "admin@gmail.com" && $password == "123456") {
                      $_SESSION['adID'] = 1;
                      echo "<script>alert('Successfully Login'); location.assign('AdminDashboard.php');</script>";
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
  <script src="js/scripts.js"></script>
</body>

</html>