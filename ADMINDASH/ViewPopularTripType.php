<?php
require_once '../db.php';
$dataPoints = array(); // Initialize an empty array to store data points

// Fetch package counts for the current trip type
if (isset($_GET['selectedMonth'])) {
  $selectedMonth = $_GET['selectedMonth'];
  $packageCountsQuery = mysqli_query($conn, "SELECT tt.trip_type_name, Count(bb.package_id) as pcount from trip_types tt, trip_packages tp, booking bb where tt.trip_type_id=tp.trip_type_id and tp.package_id=bb.package_id and Month(bb.booking_date)=$selectedMonth Group By tt.trip_type_name order by pcount DESC Limit 3") or die(mysqli_error($conn));
} else {
  $packageCountsQuery = mysqli_query($conn, "SELECT tt.trip_type_name, Count(bb.package_id) as pcount from trip_types tt, trip_packages tp, booking bb where tt.trip_type_id=tp.trip_type_id and tp.package_id=bb.package_id Group By tt.trip_type_name order by pcount DESC Limit 3") or die(mysqli_error($conn));
}
while ($packageCountRow = mysqli_fetch_assoc($packageCountsQuery)) {
  $tp_name = $packageCountRow['trip_type_name'];
  $dataPoints[] = array("label" => $tp_name, "y" => $packageCountRow['pcount']);
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
  <title>View Popular Trip Type Report</title>
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
        if (isset($_GET['selectedMonth'])) {
          $selectedmonth = $_GET['selectedMonth'];
          $currentYear = date('Y');
          $month = date('F', strtotime("$currentYear-$selectedMonth-01"));
          $month = "Only " . $month;
        } else {
          $month = "The Whole Year Of";
        }
        $year = date('Y');
        ?>
        <form method="get" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
          <div class="row">
            <div class="col-md-3 mt-3 mb-3">
              <select class="form-select" name="selectedMonth" id="selectMonth">
                <option value="0">Select Month</option>
                <?php
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
                foreach ($monthNames as $key => $value) {
                  echo "<option value='$key'>$value</option>";
                }
                ?>
              </select>
            </div>
            <div class="col-md-3 mt-3 mb-3">
              <button type="submit" class="btn btn-primary">Filter</button>
            </div>
          </div>
        </form>
        <script>
          window.onload = function() {
            var chart = new CanvasJS.Chart("chartContainer", {
              animationEnabled: true,
              title: {
                text: "Popular Trip Type by Booked Rate"
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
  <div id="chartContainer" style="height: 65vh; width: 100%;"></div>
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