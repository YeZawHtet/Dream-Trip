<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <title>View Booking</title>
  <link href="css/styles.css" rel="stylesheet" />
  <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed" style="background-color: rgba(0,0,0,0.7);">
  <?php
  include 'nav.php';
  include '../db.php';
  ?>
  <div id="layoutSidenav">
    <?php
    include 'sidebar.php';
    ?>
    <div id="layoutSidenav_content">
      <main>
        <div class="container mt-5">
          <table class="table table-dark">
            <thead>
              <tr>
                <th>NO</th>
                <th>Customer Name</th>
                <th>Booking Address</th>
                <th>Booking Date</th>
                <th>Booking Status</th>
                <th>Transportation Service Name</th>
                <th>Cleaning Service Name</th>
                <th>Update</th>
                <th>Delete</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $count = 1;
              $select = mysqli_query($conn, "SELECT *, booking.BookingID as bd from booking, bookingservice where booking.bookingID=bookingservice.bookingID");
              while ($data = mysqli_fetch_assoc($select)) {
                $bID=$data['bd'];
                $cusID = $data['cusID'];
                $tpID = $data['tpID'] ?? $tpID = 0;
                $csID = $data['csID'] ?? $csID = 0;
                $cc = mysqli_fetch_assoc(mysqli_query($conn, "select * from customer where cusID=$cusID"));
                $aa = mysqli_fetch_assoc(mysqli_query($conn, "select * from transportationservice where tpID=$tpID"));
                $bb = mysqli_fetch_assoc(mysqli_query($conn, "select * from cleaningservice where csID=$csID"));
              ?>
                <tr>
                  <td><?php echo $count; ?></td>
                  <td><?php echo $cc['cusFirstName'] . ' ' . $cc['cusLastName']; ?></td>
                  <td><?php echo $data['bookingAddress']; ?></td>
                  <td><?php echo $data['bookingDate']; ?></td>
                  <td><?php echo $data['bookingStatus']; ?></td>
                  <td style="text-align: center;"><?php echo $aa['tpName'] ?? '-----'; ?></td>
                  <td><?php echo $bb['csName'] ?? '-----'; ?></td>
                  <td style="text-align: center;"><a class="btn btn-primary" href="ViewBooking.php?bdcID=<?php echo $bID ?>;">Confirm</a></td>
                  <td>
                  <a class="btn btn-danger" href="?bdrID=<?php echo $bID; ?>">Reject</a>
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
if (isset($_GET['bdcID'])) {
  $bdcID = $_GET['bdcID'];
  $h = mysqli_query($conn, "Update Booking Set bookingStatus='Confirmed!' where BookingID=$bdcID");
  echo "<script> alert('Confirmed this booking!'); location.assign('ViewBooking.php');</script>";
}
if (isset($_GET['bdrID'])) {
  $bdrID = $_GET['bdrID'];
  $h = mysqli_query($conn, "Update Booking Set bookingStatus='Rejected!' where BookingID=$bdrID");
  echo "<script> alert('Rejected this booking!'); location.assign('ViewBooking.php');</script>";
}
?>
