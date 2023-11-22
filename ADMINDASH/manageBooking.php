<?php session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <title>Manage Booking | Admin</title>
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
        <div class="container mt-5">
          <h2>Booking List</h2>
          <table class="table table-dark">
            <thead>
              <tr>
                <th>NO</th>
                <th>Customer Name</th>
                <th>Package Name</th>
                <th>Booking Date</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $count = 1;
              $select = mysqli_query($conn, "SELECT * FROM Booking");
              while ($data = mysqli_fetch_assoc($select)) {
                $tpID = $data['package_id'];
                $cusID = $data['customer_id'];
                $bDate = $data['booking_date'];
                $p = mysqli_query($conn, "select * from trip_packages where package_id=$tpID");
                $q = mysqli_query($conn, "Select * from customer where customer_id= $cusID");
                while ($pdata = mysqli_fetch_assoc($p)) {
                  while ($cdata = mysqli_fetch_assoc($q)) {
              ?>
                    <tr>
                      <td><?php echo $count; ?></td>
                      <td><?php echo $cdata['customer_name']; ?></td>
                      <td><?php echo $pdata['package_name']; ?></td>
                      <td><?php echo $data['booking_date']; ?></td>
                      <td><?= $data['status'] ?></td>
                      <td>
                        <?php if ($data['status'] == 'Accepted') : ?>
                          <a class="btn btn-success" style="width: 100px;" href="?bID=<?php echo $data['booking_id']; ?>&action=2">Accept</a>
                          <button class="btn btn-danger" style="width: 100px;" disabled>Reject</button>
                        <?php elseif ($data['status'] == 'Rejected') : ?>
                          <button class="btn btn-success" style="width: 100px;" disabled>Accept</button>
                          <a class="btn btn-danger" style="width: 100px;" href="?bID=<?php echo $data['booking_id']; ?>&action=1">Reject</a>
                        <?php else : ?>
                          <a class="btn btn-success" style="width: 100px;" href="?bID=<?php echo $data['booking_id']; ?>&action=2">Accept</a>
                          <a class="btn btn-danger" style="width: 100px;" href="?bID=<?php echo $data['booking_id']; ?>&action=1">Reject</a>
                        <?php endif; ?>
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
if (isset($_REQUEST['action'])) {
  $action = $_REQUEST['action'];
  $bID = $_REQUEST['bID'];
  if ($action == 1) {
    $reject = mysqli_query($conn, "Update booking set status='Rejected' where booking_id=$bID");
    echo "<script> location.assign('manageBooking.php'); </script>";
  } else {
    $reject = mysqli_query($conn, "Update booking set status='Accepted' where booking_id=$bID");
    echo "<script> location.assign('manageBooking.php'); </script>";
  }
}
?>