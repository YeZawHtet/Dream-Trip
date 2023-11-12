<?php session_start();
//if (!isset($_SESSION['adID'])) {
//  echo "<script> location.assign('LoginAdmin.php'); </script>";
//} 
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <title>Trips Page | Admin</title>
  <link href="css/styles.css" rel="stylesheet" />
  <style>
    .enlarge-image {
      transition: transform 0.3s;
      /* Add a smooth transition effect */
    }

    .enlarge-image:hover {
      transform: scale(1.2);
      /* Enlarge the image by 20% on hover */
    }
  </style>
  <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed" style="background-color: rgba(0,0,0,0.7);">
  <?php
  include 'nav.php';
  ?>
  <div id="layoutSidenav">
    <?php
    include 'sidebar.php';
    ?>
    <div id="layoutSidenav_content">
      <main>
        <?php
        require('../db.php');
        if (isset($_POST['submit'])) {
          $tpName = trim($_POST['tpName']);
          $tpIntro = $_POST['tpIntro'];
          $departure = $_POST['departure'];
          $duration = trim($_POST['duration']);
          $status = "Need Action";
          $ttID = $_POST['ttID'];
          $img = $_FILES['img']['name'];
          $tmp = $_FILES['img']['tmp_name'];
          $price = $_POST['price'];
          $q = mysqli_query($conn, "select * from trip_packages where package_name='" . $tpName . "' and duration='" . $duration . "'");
          if (mysqli_num_rows($q) > 0) {
            echo "<script>alert('$tpName and $duration is Already Exists!');location.assign('managePackages.php');</script>";
          } else {
            // Create a prepared statement
            $query = "INSERT INTO trip_packages (package_name, package_intro, status, departure, duration, image, price, trip_type_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $query);

            if ($stmt) {
              // Bind the parameters to the prepared statement
              mysqli_stmt_bind_param($stmt, "ssssssdi", $tpName, $tpIntro, $status, $departure, $duration, $img, $price, $ttID);

              // Execute the statement
              $result = mysqli_stmt_execute($stmt);

              if ($result) {
                move_uploaded_file($tmp, 'assets/img/' . $img);
                echo "<script>alert('Successfully Added!');location.assign('managePackages.php');</script>";
              } else {
                echo "<script>alert('Added Fail! Try Again');location.assign('managePackages.php');</script>";
              }
            }
          }
        }
        if (isset($_GET['tpID'])) {
          $tpID = $_GET['tpID'];
          $query = "SELECT * FROM trip_packages WHERE package_id=$tpID";
          $result = mysqli_query($conn, $query);

          if ($result) {
            if ($qr = mysqli_fetch_assoc($result)) {
              $tpName = $qr["package_name"];
              $tpIntro = $qr['package_intro'];
              $departure = $qr['departure'];
              $duration = $qr['duration'];
              $price = $qr["price"];
              $ttID = $qr["trip_type_id"];
            } else {
              echo "No matching record found for tpID: $tpID";
            }
          } else {
            echo "Error executing the query: " . mysqli_error($conn);
          }

        ?>

          <div class="container-fluid mt-5">
            <form method="post" enctype="multipart/form-data">
              <div class="row mb-3">
                <div class="col-md-6 mb-4">
                  <input type="text" name="tpName" placeholder="Trip Package Name" class="form-control" value="<?php echo $tpName; ?>" required>
                </div>
                <div class="col-md-6 mb-4">
                  <input type="text" name="departure" placeholder="Departure" class="form-control" value="<?= $departure ?>" required>
                </div>
                <div class="col-md-6 mb-4">
                  <input type="text" name="duration" placeholder="Duration: e.g 7D1N" class="form-control" value="<?= $duration ?>" required>
                </div>
                <div class="col-md-6 mb-4">
                  <input type="text" name="price" placeholder="Price" class="form-control" required pattern="[0-9]+" value="<?php echo $price; ?>" required>
                </div>
                <div class="col-md-6 mb-4">
                  <input type="file" name="img" class="form-control">
                </div>
                <div class="col-md-6 mb-4">
                  <select name="ttID" class="form-select" required>
                    <option value="">Select Trip Package</option>
                    <?php
                    $query = "SELECT * FROM trip_types";
                    $result = mysqli_query($conn, $query);
                    if ($result) {
                      while ($row = mysqli_fetch_assoc($result)) {
                        $tID = $row["trip_type_id"];
                        $ttName = $row['trip_type_name'];
                        // Check if the current option matches the value of $ttName
                        $selected = ($tID == $ttID) ? 'selected' : '';
                        echo "<option value='$tID' $selected>$ttName</option>";
                      }
                    } else {
                      echo "Error fetching trip types from the database.";
                    }
                    ?>
                  </select>
                </div>
                <div class="col-md-12 mb-4">
                  <textarea name="tpIntro" placeholder="Trip Intro" class="form-control" cols="30" rows="2" required><?= $tpIntro ?></textarea>
                </div>

              </div>
              <div class="row mt-3">
                <div class="col-md-1">
                  <button type="submit" name="Update" class="btn btn-success">Update</button>
                </div>
                <div class="col-md-1">
                  <button type="reset" class="btn btn-primary">Cancel</button>
                </div>
              </div>
            </form>
          </div>
          <?php
          if (isset($_POST['Update'])) {
            $tpID = $_GET['tpID'];
            $tpName = $_REQUEST['tpName'];
            $tpIntro = $_REQUEST['tpIntro'];
            $departure = $_REQUEST['departure'];
            $duration = $_REQUEST['duration'];
            $status = "Need Action";
            $ttID = $_REQUEST['ttID'];
            $img = $_FILES['img']['name'];
            $tmp = $_FILES['img']['tmp_name'];
            if ($tmp == NULL) {
              $qq = mysqli_query($conn, "update trip_packages set package_name='$tpName', package_intro='$tpIntro', departure='$departure', duration='$duration', status='$status', trip_type_id=$ttID  where package_id=$tpID");
              if ($qq) {
                echo "<script> alert('Updated Successfully!'); location.assign('managePackages.php');</script>";
              }
            } else {
              $q1 = mysqli_query($conn, "update trip_packages set package_name='$tpName', package_intro='$tpIntro', departure='$departure', duration='$duration', status='$status', trip_type_id=$ttID, image='$img' where package_id=$tpID");
              move_uploaded_file($tmp, 'assets/img/' . $img);
              echo "<script> alert('Updated Successfully'); location.assign('managePackages.php');</script>";
            }
          }
          ?>
        <?php } else {
        ?>
          <div class="container-fluid mt-5">
            <form method="post" enctype="multipart/form-data">
              <div class="row mb-3">
                <div class="col-md-6 mb-4">
                  <input type="text" name="tpName" placeholder="Trip Name" class="form-control" required>
                </div>
                <div class="col-md-6 mb-4">
                  <input type="text" name="departure" placeholder="Departure" class="form-control" required>
                </div>
                <div class="col-md-6 mb-4">
                  <input type="text" name="duration" placeholder="Duration: e.g 7D1N" class="form-control" required>
                </div>
                <div class="col-md-6 mb-4">
                  <input type="text" name="price" placeholder="Price" class="form-control" required pattern="[0-9]+">
                </div>
                <div class="col-md-6 mb-4">
                  <input type="file" name="img" class="form-control" required>
                </div>
                <div class="col-md-6 mb-4">
                  <select name="ttID" class="form-select" required>
                    <option value="">Select Trip Package</option>
                    <?php
                    $query = "SELECT * FROM trip_types";
                    $result = mysqli_query($conn, $query);
                    if ($result) {
                      while ($row = mysqli_fetch_assoc($result)) {
                        $ttID = $row["trip_type_id"];
                        $ttName = $row['trip_type_name'];
                        echo "<option value='$ttID'>$ttName</option>";
                      }
                    } else {
                      echo "Error fetching trip types from the database.";
                    }
                    ?>
                  </select>
                </div>
                <div class="col-md-12 mb-4">
                  <textarea name="tpIntro" placeholder="Trip Intro" class="form-control" cols="30" rows="2" required></textarea>
                </div>
              </div>
              <div class="row mt-3">
                <div class="col-md-1">
                  <button type="submit" name="submit" class="btn btn-success">Add</button>
                </div>
                <div class="col-md-1">
                  <button type="reset" class="btn btn-primary">Cancel</button>
                </div>
              </div>
            </form>
          </div>
        <?php } ?>
        <div class="container mt-5">
          <table class="table table-dark">
            <thead>
              <tr>
                <th>NO</th>
                <th>Trip Name</th>
                <th>Status</th>
                <th>Image</th>
                <th>Trip Type</th>
                <th style="text-align: center;">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $count = 1;
              $select = mysqli_query($conn, "SELECT * FROM trip_packages");
              while ($data = mysqli_fetch_assoc($select)) {
                $tpName = $data['package_name'];
                $ttID = $data['trip_type_id'];
                $q = mysqli_query($conn, "Select * from trip_types where trip_type_id= $ttID");
                while ($row = mysqli_fetch_assoc($q)) {
              ?>
                  <tr>
                    <td><?php echo $count; ?></td>
                    <td><?php echo $data['package_name']; ?></td>
                    <td><?php echo $data['status']; ?></td>
                    <td><img class="enlarge-image" style="width: 200px;
                      height: 200px;
                      border-radius: 20%;
                      box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);" src="assets/img/<?php echo $data['image']; ?>" alt=""></td>
                    <td><?= $row['trip_type_name'] ?></td>
                    <td style="text-align:center" ;><a class="btn btn-primary" style="width: 100px;" href="?tpID=<?php echo $data['package_id']; ?>&tpName=<?php echo $data['package_name']; ?>">Edit</a>
                      <a class="btn btn-danger" style="width: 100px;" href="?tpdelID=<?php echo $data['package_id']; ?>">Delete</a>
                    </td>
                  </tr>
              <?php
                  $count += 1;
                }
              }
              ?>
            </tbody>
          </table>
        </div>
      </main>
      <?php include 'footer.php'; ?>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
  <script src="js/scripts.js"></script>
</body>

</html>
<?php
if (isset($_REQUEST['tpdelID'])) {
  $tpID = $_REQUEST['tpdelID'];
  $qdel = mysqli_query($conn, "Delete from trip_packages where package_id=$tpID");
  echo "<script> alert ('Deleted Successfully'); location.assign('managePackages.php'); </script>";
}
?>