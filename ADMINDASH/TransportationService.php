<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <title>Transportation Service Page</title>
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
        <?php
        require('../db.php');
        if (isset($_POST['submit'])) {
          $tpName = $_POST['tpName'];
          $tpDescription = $_POST['tpDescription'];
          $scID = $_POST['scID'];
          $tpPrice=$_POST['tpPrice'];
          $query = "INSERT INTO TransportationService(tpName,tpDescription,scID, tpPrice) VALUES ('$tpName','$tpDescription','$scID', $tpPrice);";
          $result = mysqli_query($conn, $query);
          if ($result) {
            echo "<script>alert('Successfully Added!');location.assign('TransportationService.php');</script>";
          } else {
            echo "<script>alert('Added Fail! Try Again');location.assign('TransportationService.php');</script>";
          }
        }
        if (isset($_GET['tpID'])) {
          $tpID=$_GET['tpID'];
          $tpName = $_GET['tpName'];
          $tpDescription = $_GET['tpDescription'];
          $tpPrice=$_GET['tpPrice'];
          $scID = $_GET['scID'];
        ?>
          <div class="container-fluid mt-5">
            <form method="post">
              <div class="row mb-3">
                <div class="col-md-6">
                  <input type="text" name="tpName" placeholder="Transportation Service Name" class="form-control" value="<?php echo $tpName; ?>" required>
                </div>
              </div>
              <div class="row mb-3">
                <div class="form-group col-sm-6">
                  <textarea class="form-control" placeholder="Transportation Service Description" name="tpDescription" rows="2" style="line-height: 22px;"><?php echo $tpDescription; ?></textarea>
                </div>
              </div>
              <div class="row mb-3">
                <div class="col-md-6">
                  <input type="number" name="tpPrice" placeholder="Transportation Service Price" class="form-control" value="<?php echo $tpPrice; ?>" required>
                </div>
              </div>
              <div class="row mt-3">
                <div class="col-md-6">
                  <select name="scID" class="form-control" id="scID" required>
                    <?php
                    $q = mysqli_query($conn, "select * from servicecategory");
                    while ($r = mysqli_fetch_assoc($q)) {
                    ?>
                      <option value="<?php echo $r['scID']; ?>"><?php echo $r['scName']; ?></option>
                    <?php } ?>
                  </select>
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
if(isset($_POST['Update'])){
  $tpID=$_REQUEST['tpID'];
  $tpName=$_REQUEST['tpName'];
  $tpDescription=$_REQUEST['tpDescription'];
  $tpPrice=$_REQUEST['tpPrice'];
  $scID=$_REQUEST['scID'];
  $qq=mysqli_query($conn, "update transportationservice set tpName='$tpName', tpDescription='$tpDescription', tpPrice=$tpPrice, scID=$scID where tpID=$tpID");
  if($qq){
  echo "<script> alert('Updated Successfully!'); location.assign('TransportationService.php');</script>";
  }
}
    ?>
        <?php } else {
        ?>
          <div class="container-fluid mt-5">
            <form method="post">
              <div class="row mb-3">
                <div class="col-md-6">
                  <input type="text" name="tpName" placeholder="Transportation Service Name" class="form-control" required>
                </div>
              </div>
              <div class="row mb-3">
                <div class="form-group col-sm-6">
                  <textarea class="form-control" placeholder="Transportation Service Description" name="tpDescription" rows="2" style="line-height: 22px;"></textarea>
                </div>
              </div>
              <div class="row mb-3">
                <div class="col-md-6">
                  <input type="number" name="tpPrice" placeholder="Transportation Service Price" class="form-control" required>
                </div>
              </div>
              <div class="row mt-3">
                <div class="col-md-6">
                  <select name="scID" class="form-control" id="scID" required>
                    <?php
                    $q = mysqli_query($conn, "select * from servicecategory");
                    while ($r = mysqli_fetch_assoc($q)) {
                    ?>
                      <option value="<?php echo $r['scID']; ?>"><?php echo $r['scName']; ?></option>
                    <?php } ?>
                  </select>
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
                <th> Service Name</th>
                <th> Service Description</th>
                <th>Service Price</th>
                <th>Service Category Name</th>
                <th>Update</th>
                <th>Delete</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $count = 1;
              $select = mysqli_query($conn, "SELECT *, sc.scName FROM TransportationService ts, ServiceCategory sc WHERE sc.scID=ts.scID");
              while ($data = mysqli_fetch_assoc($select)) {
                $scName = $data['scName'];
                $scID = $data['scID'];
              ?>
                <tr>
                  <td><?php echo $count; ?></td>
                  <td><?php echo $data['tpName']; ?></td>
                  <td><?php echo $data['tpDescription']; ?></td>
                  <td><?php echo $data['tpPrice']; ?> MMK</td>
                  <td><?php echo $scName ?></td>
                  <td><a class="btn btn-primary"  href="?tpID=<?php echo $data['tpID']; ?>&tpName=<?php echo $data['tpName']; ?>&scID=<?php echo $data['scID']; ?>&tpDescription=<?php echo $data['tpDescription']; ?>&tpPrice=<?php echo $data['tpPrice'];?>">Edit</a></td>
                  <td>
                    <a class="btn btn-danger"  href="?tpdelID=<?php echo $data['tpID'];?>">Delete</a>
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
if(isset($_REQUEST['tpdelID'])){
  $tpID=$_REQUEST['tpdelID'];
  $qdel=mysqli_query($conn, "Delete from transportationservice where tpID=$tpID");
  echo "<script> alert('Deleted Successfully!');</script> location.assign('TransportationService.php');" ;
}
?>

