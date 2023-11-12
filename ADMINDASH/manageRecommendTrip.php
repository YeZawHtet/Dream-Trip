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
  <title>Recommend Trips Page | Admin</title>
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
          $tpID = $_POST['tpID'];
          $query = "Update trip_packages set status='Recommended' where package_id=$tpID";
          $result = mysqli_query($conn, $query);
          if ($result) {
            echo "<script>alert('Successfully Added!');location.assign('manageRecommendTrip.php');</script>";
          } else echo "<script>alert('Added Fail! Try Again');location.assign('manageRecommendTrip.php');</script>";
        }
        ?>
          <div class="container-fluid mt-3">
            <h2>Recommended Trip</h2>
            <form method="post" enctype="multipart/form-data">
              <div class="row mb-3">
              <div class="col-md-6 mb-4">
                  <select name="tpID" class="form-select" required>
                    <option value="">Select Trip Package</option>
                    <?php
                    $query = "SELECT * FROM trip_packages where status NOT LIKE '%Recommended%'";
                    $result = mysqli_query($conn, $query);
                    if ($result) {
                      while ($row = mysqli_fetch_assoc($result)) {
                        $tpID = $row["package_id"];
                        $tpName = $row['package_name'];
                        echo "<option value='$tpID'>$tpName</option>";
                      }
                    } else {
                      echo "Error fetching trip packages from the database.";
                    }
                    ?>
                  </select>
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
        <div class="container mt-5">
          <table class="table table-dark">
            <thead>
              <tr>
                <th>NO</th>
                <th>Package Name</th>
                <th>Status</th>
                <th>Image</th>
                <th>Trip Type</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $count = 1;
              $select = mysqli_query($conn, "SELECT * FROM trip_packages where status='Recommended'");
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
                    <td>
                      <a class="btn btn-danger" style="width: 100px;" href="?tpdelID=<?php echo $data['package_id']; ?>">Remove</a>
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
  $qdel = mysqli_query($conn, "Update trip_packages set status='Need Action' where package_id=$tpID");
  echo "<script> alert ('Remove Successfully From the Recommended List '); location.assign('manageRecommendTrip.php'); </script>";
}
?>