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
  <title>Trips Details Page | Admin</title>
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
          $detailsName = $_POST['detailsTitle'];
          $detailsText = $_POST['details'];
          $status = "Need Action";
          $tpID = $_POST['tpID'];
          $img = $_FILES['img']['name'];
          $tmp = $_FILES['img']['tmp_name'];
          // Using prepared statement
          $query = "INSERT INTO details (details_name, details_text, status, image, package_id) VALUES (?, ?, ?, ?, ?)";
          $stmt = mysqli_prepare($conn, $query);
          if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ssssi", $detailsName, $detailsText, $status, $img, $tpID);
            $result = mysqli_stmt_execute($stmt);
            if ($result) {
              echo "<script>alert('Successfully Added!');location.assign('managePackagesDetails.php');</script>";
              move_uploaded_file($tmp, 'assets/img/' . $img);
            } else {
              echo "<script>alert('Added Fail! Try Again');location.assign('managePackagesDetails.php');</script>";
            }
            mysqli_stmt_close($stmt);
          } else {
            echo "Prepared statement error: " . mysqli_error($conn);
          }
          mysqli_close($conn);
        }
        if (isset($_GET['ddID'])) {
          $tpID = $_GET['ddID'];
          $query = "SELECT * FROM details WHERE details_id=$tpID";
          $result = mysqli_query($conn, $query);
          if ($result) {
            if ($qr = mysqli_fetch_assoc($result)) {
              $pkID = $qr["package_id"];
              $ddname = $qr["details_name"];
              $ddtext = $qr["details_text"];
            } else {
              echo "No matching record found for tpID: $tpID";
            }
          } else {
            echo "Error executing the query: " . mysqli_error($conn);
          } ?>
          <div class="container-fluid mt-5">
            <form method="post" enctype="multipart/form-data">
              <div class="row mb-3">
                <div class="col-md-6 mb-4">
                  <select name="ttID" class="form-select" required>
                    <option value="">Select Trip Package</option>
                    <?php
                    $query = "SELECT * FROM trip_packages";
                    $result = mysqli_query($conn, $query);
                    if ($result) {
                      while ($row = mysqli_fetch_assoc($result)) {
                        $tID = $row["package_id"];
                        $ttName = $row['package_name'];

                        // Check if the current option matches the value of $ttName
                        $selected = ($tID == $pkID) ? 'selected' : '';

                        echo "<option value='$tID' $selected>$ttName</option>";
                      }
                    } else {
                      echo "Error fetching trip packages from the database.";
                    }
                    ?>
                  </select>
                </div>
                <div class="col-md-6 mb-4">
                  <input type="text" name="detailsTitle" value="<?= $qr['details_name']; ?>" placeholder="Enter details Title" class="form-control" required>
                </div>
                <div class="col-md-6 mb-4">
                  <textarea name="details" placeholder="Enter details" class="form-control" cols="30" rows="5" required><?= $qr['details_text']; ?></textarea>
                </div>
                <div class="col-md-6 mb-4">
                  <input type="file" name="img" class="form-control">
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
            $ddID = $_GET['ddID'];
            $ttID = $_REQUEST['ttID'];
            $detailsTitle = $_REQUEST['detailsTitle'];
            $details = $_REQUEST['details'];
            $img = $_FILES['img']['name'];
            $tmp = $_FILES['img']['tmp_name'];
            if ($tmp == NULL) {
              // SQL query without image
              $query = "UPDATE details SET details_name=?, details_text=?, package_id=? WHERE details_id=?";
              $stmt = mysqli_prepare($conn, $query);
              if ($stmt) {
                // Bind the parameters to the prepared statement
                mysqli_stmt_bind_param($stmt, "sssi", $detailsTitle, $details, $ttID, $ddID);
                // Execute the statement
                $result = mysqli_stmt_execute($stmt);
                if ($result) {
                  echo "<script>alert('Updated Successfully! without image'); location.assign('managePackagesDetails.php');</script>";
                } else {
                  echo "<script>alert('Update Failed! Try Again'); location.assign('managePackagesDetails.php');</script>";
                }
              }
            } else {
              // SQL query with image
              $query = "UPDATE details SET details_name=?, details_text=?, package_id=?, image=? WHERE details_id=?";
              $stmt = mysqli_prepare($conn, $query);
              if ($stmt) {
                // Bind the parameters to the prepared statement
                mysqli_stmt_bind_param($stmt, "ssssi", $detailsTitle, $details, $ttID, $img, $ddID);

                // Execute the statement
                $result = mysqli_stmt_execute($stmt);

                if ($result) {
                  move_uploaded_file($tmp, 'assets/img/' . $img);
                  echo "<script>alert('Updated Successfully'); location.assign('managePackagesDetails.php');</script>";
                } else {
                  echo "<script>alert('Update Failed! Try Again'); location.assign('managePackagesDetails.php');</script>";
                }
              }
            }
          }
        } else {
          ?>
          <div class="container-fluid mt-5">
            <form method="post" enctype="multipart/form-data">
              <div class="row mb-3">
                <div class="col-md-6 mb-4">
                  <select name="tpID" class="form-select" required>
                    <option value="">Select Trip Package</option>
                    <?php
                    $query = "SELECT * FROM trip_packages";
                    $result = mysqli_query($conn, $query);
                    if ($result) {
                      while ($row = mysqli_fetch_assoc($result)) {
                        $tpID = $row["package_id"];
                        $tpName = $row['package_name'];
                        echo "<option value='$tpID'>$tpName</option>";
                      }
                    } else {
                      echo "Error fetching trip types from the database.";
                    }
                    ?>
                  </select>
                </div>
                <div class="col-md-6 mb-4">
                  <input type="text" name="detailsTitle" placeholder="Enter details Title" class="form-control" required>
                </div>
                <div class="col-md-6 mb-4">
                  <textarea name="details" placeholder="Enter details" class="form-control" cols="30" rows="5" required></textarea>
                </div>
                <div class="col-md-6 mb-4">
                  <input type="file" name="img" class="form-control">
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
                <th>Name</th>
                <th>Intro</th>
                <th>Details</th>
                <th>Image</th>
                <th>Status</th>
                <th style="text-align: center;">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $count = 1;
              $select = mysqli_query($conn, "SELECT * FROM details");
              while ($data = mysqli_fetch_assoc($select)) {
                $detailName = $data['details_name'];
                $tpID = $data['package_id'];
                $q = mysqli_query($conn, "Select * from trip_packages where package_id= $tpID");
                while ($row = mysqli_fetch_assoc($q)) {
              ?>
                  <tr>
                    <td><?php echo $count; ?></td>
                    <td><?php echo $row['package_name']; ?></td>
                    <td><?php echo $data['details_name']; ?></td>
                    <td><?php echo $data['details_text']; ?></td>
                    <td><img class="enlarge-image" style="width: 200px;
                      height: 200px;
                      border-radius: 20%;
                      box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);" src="assets/img/<?php echo $data['image']; ?>" alt=""></td>
                    <td><?php echo $data['status']; ?></td>
                    <td style="text-align:center" ;>
                      <a class="btn btn-primary" style="width: 100px;" href="?ddID=<?php echo $data['details_id']; ?>">Edit</a>
                      <a class="btn btn-danger" style="width: 100px;" href="?bdelID=<?php echo $data['details_id']; ?>">Remove</a>
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
if (isset($_REQUEST['bdelID'])) {
  $bdelID = $_REQUEST['bdelID'];
  $q = mysqli_query($conn, "Delete from details where details_id=$bdelID");
  echo "<script> alert ('Remove Successfully'); location.assign('managePackagesDetails.php'); </script>";
}
?>