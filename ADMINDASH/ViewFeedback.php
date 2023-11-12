<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <title>Service Category Service Page</title>
  <link href="css/styles.css" rel="stylesheet" />
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
        <div class="content-page">
          <div class="container-fluid">
            <div class="row">
              <div class="col-sm-12">
                <div class="card">
                  <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                      <h4 class="card-title">Feedback List</h4>
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-striped">
                        <thead>
                          <tr class="dark">
                            <th>No.</th>
                            <th>Customer ID</th>
                            <th>Customer Name</th>
                            <th>Feedback</th>
                          </tr>
                        </thead>

                        <tbody>
                          <?php
                          $num = 1;
                          include '../db.php';
                          $q = mysqli_query($conn, "select * from feedback");
                          while ($qr = mysqli_fetch_assoc($q)) {
                            $cusID = $qr['cusID'];
                            $cu = mysqli_fetch_assoc(mysqli_query($conn, "select * from customer where cusID=$cusID"));
                          ?>
                            <tr>
                              <td><?php echo $num;
                                  $num++; ?></td>
                              <td><?php echo $cusID ?></td>
                              <td><?php echo $cu['cusFirstName']. ' ' . $cu['cusLastName']; ?></td>
                              <td><?php echo $qr['fbMessage']; ?></td>
                            </tr>
                          <?php
                          }
                          ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

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
if (isset($_REQUEST['scdelID'])) {
  $scID = $_REQUEST['scdelID'];
  $qdel = mysqli_query($conn, "Delete from ServiceCategory where scID=$scID");
  echo "<script> alert ('Deleted Successfully'); location.assign('ServiceCategory.php'); </script>";
}
?>