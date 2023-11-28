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
  <title>Manage Desire Trips | Admin</title>
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
        ?>
        <div class="container mt-5">
          <h2>Desire Trip List</h2>
          <table class="table table-dark">
            <thead>
              <tr>
                <th>NO</th>
                <th>Customer Name</th>
                <th>Trip Type Name</th>
                <th>Desire Date</th>
                <th>Duration</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $count = 1;
              $select = mysqli_query($conn, "SELECT * FROM desire_trips");
              while ($data = mysqli_fetch_assoc($select)) {
                $cusID = $data['customer_id'];
                $trip_type_id = $data['trip_type_id'];
                $q = mysqli_query($conn, "Select * from customer where customer_id= $cusID");
                $q1 = mysqli_query($conn, "Select * from trip_types where trip_type_id= $trip_type_id");
                while ($cdata = mysqli_fetch_assoc($q)) {
                  while ($tdata = mysqli_fetch_assoc($q1)) {
              ?>
                    <tr>
                      <td><?php echo $count; ?></td>
                      <td><?php echo $cdata['customer_name']; ?></td>
                      <td><?php echo $tdata['trip_type_name']; ?></td>
                      <td><?php echo $data['desire_date']; ?></td>
                      <td><?php echo $data['duration']; ?></td>
                      <td>
                        <a class="btn btn-danger" style="width: 100px;" href="?dID=<?php echo $data['desire_id']; ?>">Remove</a>
                      </td>
                    </tr>
              <?php
                    $count += 1;
                  }
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
if (isset($_REQUEST['dID'])) {
  $dID = $_REQUEST['dID'];
  $q = mysqli_query($conn, "delete from desire_trips where desire_id=$dID");
  if ($q) {
    echo "<script> alert ('Successfully remove from the desire trip list!'); location.assign('manageDesireTrips.php');</script>";
  }
}
?>