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
  <title>Trip Type Page | Admin</title>
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
          $adID = $_SESSION['adID'];
          $ttName = trim($_POST['ttName']);
          $img = $_FILES['img']['name'];
          $tmp = $_FILES['img']['tmp_name'];
          $status = "No Action";
          $q = mysqli_query($conn, "select * from trip_types where trip_type_name='" . $ttName . "'");
          if (mysqli_num_rows($q) > 0) {
            echo "<script>alert('$ttName is Already Exists!');location.assign('manageTripType.php');</script>";
          } else {
            $query = "INSERT INTO trip_types (trip_type_name, image, status) VALUES ('$ttName','$img','$status')";
            $result = mysqli_query($conn, $query);
            if ($result) {
              move_uploaded_file($tmp, 'assets/img/' . $img);
              echo "<script>alert('Successfully Added!');location.assign('manageTripType.php');</script>";
            } else
              echo "<script>alert('Fail to Add! Try Again');location.assign('manageTripType.php');</script>";
          }
        }
        if (isset($_GET['ttID'])) {
          $ttID = $_GET['ttID'];
          $ttName = $_GET['ttName'];
        ?>
          <div class="container-fluid mt-5">
            <form method="post" enctype="multipart/form-data">
              <div class="row mb-3">
                <div class="col-md-6 mb-4">
                  <input type="text" name="ttName" placeholder="Trip Type Name" class="form-control" value="<?php echo $ttName; ?>" required>
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
            $ttID = $_REQUEST['ttID'];
            $ttName = $_REQUEST['ttName'];
            $status = $_POST['status'];
            $img = $_FILES['img']['name'];
            $tmp = $_FILES['img']['tmp_name'];

            if ($tmp == NULL) {
              $qq = mysqli_query($conn, "update trip_types set trip_type_name='$ttName',  where trip_type_id=$ttID");
              if ($qq) {
                echo "<script> alert('Updated Successfully!'); location.assign('manageTripType.php');</script>";
              }
            } else {
              $qq = mysqli_query($conn, "update trip_types set trip_type_name='$ttName', image='$img' where trip_type_id=$ttID");
              if ($qq) {
                move_uploaded_file($tmp, 'assets/img/' . $img);
                echo "<script> alert('Updated Successfully!'); location.assign('manageTripType.php');</script>";
              }
            }
          }
          ?>
        <?php } else {
        ?>
          <div class="container-fluid mt-5">
            <form method="post" enctype="multipart/form-data">
              <div class="row mb-3">
                <div class="col-md-6 mb-4">
                  <input type="text" name="ttName" placeholder="Trip Type Name" class="form-control" required>
                </div>
                <div class="col-md-6 mb-4">
                  <input type="file" name="img" class="form-control" required>
                </div>
              </div>
              <div class="row mt-3">
                <div class="col-md-1">
                  <button type="submit" name="submit" class="btn btn-success">Add</button>
                </div>
                <div class="col-md-1">
                  <button type="button" class="btn btn-primary">Cancel</button>
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
                <th>Trip Type Name</th>
                <th>Status</th>
                <th>Image</th>
                <th style="text-align: center;">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $count = 1;
              $select = mysqli_query($conn, "SELECT * FROM trip_types");
              while ($data = mysqli_fetch_assoc($select)) {
                $ttName = $data['trip_type_name'];
                $ttID = $data['trip_type_id'];
              ?>
                <tr>
                  <td><?php echo $count; ?></td>
                  <td><?php echo $data['trip_type_name']; ?></td>
                  <td><?php echo $data['status']; ?></td>
                  <td><img class="enlarge-image" style="width: 200px;
                      height: 200px;
                      border-radius: 20%;
                      box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);" src="assets/img/<?php echo $data['image']; ?>" alt=""></td>
                  <td style="text-align:center" ;><a class="btn btn-primary" href="?ttID=<?php echo $data['trip_type_id']; ?>&status=<?php echo $data['status']; ?>&ttName=<?php echo $data['trip_type_name']; ?>">Edit</a>
                    <a class="btn btn-danger" href="?ttdelID=<?php echo $data['trip_type_id']; ?>">Delete</a>
                  </td>
                </tr>
              <?php
                $count += 1;
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
if (isset($_REQUEST['ttdelID'])) {
  $ttID = $_REQUEST['ttdelID'];
  $qdel = mysqli_query($conn, "Delete from trip_types where trip_type_id=$ttID");
  echo "<script> alert ('Deleted Successfully'); location.assign('manageTripType.php'); </script>";
}
?>