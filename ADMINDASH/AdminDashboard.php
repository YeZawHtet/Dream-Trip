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
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    <style>
        /* CSS for Animations */
        .animated-card {
            animation: cardScale 0.3s ease-in-out;
        }

        @keyframes cardScale {
            0% {
                transform: scale(0.5);
            }

            100% {
                transform: scale(1);
            }
        }

        .animated-card-title {
            font-size: 18px;
            font-weight: bold;
            text-align: center;
            animation: numberPulse 4s infinite;
        }

        .animated-card-footer {
            background-color: rgba(255, 255, 255, 0.2);
            text-align: center;
            border-top: 1px solid rgba(255, 255, 255, 0.4);
        }

        .animated-number {
            font-size: 30px;
            font-weight: bold;
            text-align: center;
            animation: numberPulse 1s infinite;
        }

        @keyframes numberPulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.2);
            }
        }
    </style>
</head>

<body class="sb-nav-fixed">
    <!-- navbar start -->
    <?php include 'nav.php' ?>
    <!-- navbar start -->
    <div id="layoutSidenav">
        <!-- Sidebar Start -->
        <?php include 'sidebar.php' ?>
        <!-- Sidebar End -->
        <div id="layoutSidenav_content">
            <main>
                <?php require_once '../db.php'; ?>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Admin Dashboard</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                    <div class="row">
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-primary text-white mb-4 animated-card">
                                <div class="card-body animated-card-title">Total Trip Type</div>
                                <div class="card-footer d-flex align-items-center justify-content-center animated-card-footer">
                                    <?php
                                    $q = mysqli_query($conn, "select Count(trip_type_id) as booked from trip_types");
                                    while ($r = mysqli_fetch_array($q)) {
                                        echo "<span class='animated-number'>" . $r["booked"] . "</span>";
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-warning text-white mb-4 animated-card">
                                <div class="card-body animated-card-title">Total Packages</div>
                                <div class="card-footer d-flex align-items-center justify-content-center animated-card-footer">
                                    <?php
                                    $q = mysqli_query($conn, "select Count(package_id) as booked from trip_packages");
                                    while ($r = mysqli_fetch_array($q)) {
                                        echo "<span class='animated-number'>" . $r["booked"] . "</span>";
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-success text-white mb-4 animated-card">
                                <div class="card-body animated-card-title">Total Traveller Accounts</div>
                                <div class="card-footer d-flex align-items-center justify-content-center animated-card-footer">
                                    <?php
                                    $q = mysqli_query($conn, "select Count(customer_id) as booked from customer");
                                    while ($r = mysqli_fetch_array($q)) {
                                        echo "<span class='animated-number'>" . $r["booked"] . "</span>";
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-dark text-white mb-4 animated-card">
                                <div class="card-body animated-card-title">Total Booking</div>
                                <div class="card-footer d-flex align-items-center justify-content-center animated-card-footer">
                                    <?php
                                    $q = mysqli_query($conn, "select Count(booking_id) as booked from booking");
                                    while ($r = mysqli_fetch_array($q)) {
                                        echo "<span class='animated-number'>" . $r["booked"] . "</span>";
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <?php
                        $q = mysqli_query($conn, "SELECT package_id, COUNT(package_id) AS max_count FROM booking GROUP BY package_id ORDER BY max_count DESC LIMIT 2");
                        $i = 1;
                        while ($r = mysqli_fetch_array($q)) {
                            $pkID = $r["package_id"];
                            $q1 = mysqli_query($conn, "select * from trip_packages where package_id=$pkID");
                            while ($r1 = mysqli_fetch_array($q1)) {

                        ?>
                                <div class="col-xl-6">
                                    <div class="card-header">
                                        <i class="fas fa-chart-area me-1"></i>
                                        Top <?= $i ?> Popular Place
                                    </div>
                                    <div class="card bg-success text-white mb-4">
                                        <div class="card-body" style="position: relative; padding: 0;">
                                            <img src="assets/img/<?= $r1['image'] ?>" alt="popular places" style="width: 100%; height: 100%; object-fit: cover;">
                                        </div>
                                        <div class="card-footer"><?= $r1['package_name']; ?></div>
                                    </div>
                                </div><?php
                                    }
                                    $i++;
                                } ?>
                    </div>

                </div>
            </main>
            <!-- Footer start -->
            <?php include 'footer.php' ?>
            <!-- Footer start -->
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
</body>

</html>