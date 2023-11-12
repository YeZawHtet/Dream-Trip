<?php
require_once '../db.php';
$package_name = mysqli_query($conn, "select * from trip_packages") or die(mysqli_error($con));
$dataPoints = array(); // Initialize an empty array to store data points
while ($row = mysqli_fetch_assoc($package_name)) {
  $trip_name = $row["package_name"];
  $trip_id = $row["package_id"];
  $q = mysqli_query($conn, "SELECT package_id, COUNT(package_id) AS pcount 
  FROM booking where package_id=$trip_id
  GROUP BY package_id 
  ORDER BY pcount DESC 
  LIMIT 3") or die(mysqli_error($conn));
  while ($row1 = mysqli_fetch_assoc($q)) {
    // Add data point to the array if the size is less than 3
    if (count($dataPoints) < 3) {
      $dataPoints[] = array("label" => $trip_name, "y" => $row1['pcount']);
    } else {
      break; // Exit the loop if the array size reaches 3
    }
  }
}
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <title>View Popular Trip Report</title>
  <link href="css/styles.css" rel="stylesheet" />
  <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
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
        <?php
        $qd = mysqli_query($conn, 'SELECT * FROM booking WHERE package_id = (SELECT package_id FROM trip_packages ORDER BY COUNT(package_id) DESC LIMIT 1)');
        $row = mysqli_fetch_assoc($qd);
        $booking_date = $row['booking_date'];
        $month_number = date('m', strtotime($booking_date));
        $monthNames = array(
          1 => "January",
          2 => "February",
          3 => "March",
          4 => "April",
          5 => "May",
          6 => "June",
          7 => "July",
          8 => "August",
          9 => "September",
          10 => "October",
          11 => "November",
          12 => "December"
        );

        if (isset($monthNames[$month_number])) {
          $month = $monthNames[$month_number];
        } else {
          $month = "Invalid Month"; // Handle invalid month numbers
        }
        $year = date('Y', strtotime($booking_date));
        ?>
        <script>
          window.onload = function() {
            var chart = new CanvasJS.Chart("chartContainer", {
              animationEnabled: true,
              title: {
                text: "Popular Trip Packages by Booked Rate"
              },
              subtitles: [{
                text: "<?= $month . ' ' . $year ?>"
              }],
              data: [{
                type: "pie",
                yValueFormatString: "#,##0",
                // yValueFormatString: "#,##0.00\"%\"",
                indexLabel: "{label} ({y})",
                dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
              }]
            });
            chart.render();
          }
        </script>
</head>

<body class="sb-nav-fixed" style="background-color: rgba(0,0,0,0.7);">
  <div id="chartContainer" style="height: 80vh; width: 100%;"></div>
  <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
  </main>
  <!-- End manage Subjects -->

  <!-- footer start -->
  <?php include 'footer.php'; ?>
  <!-- footer end -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
  <script src="js/scripts.js"></script>
</body>

<!-- Income Report Line Chart -->
<script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>


</body>

</html>