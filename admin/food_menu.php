<?php
include('db.php');
session_start();
if (!isset($_SESSION["user"])) {
    header("location:index.php");
}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>AMETHYST HOTEL</title>
    <!-- Bootstrap Styles-->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FontAwesome Styles-->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />

    <link rel="stylesheet" href="assets/css/morris.css">
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js//raphael-min.js"></script>
    <script src="assets/js/morris.min.js"></script>


    <!-- Custom Styles-->
    <link href="assets/css/custom-styles.css" rel="stylesheet" />
    <!-- Google Fonts-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    <!-- TABLE STYLES-->
    <link href="assets/js/dataTables/dataTables.bootstrap.css" rel="stylesheet" />
</head>

<body>
    <div id="wrapper">

        <?php
        include('./navbar.php');
        ?>
        <!--/. NAV TOP  -->
        <nav class="navbar-default navbar-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="main-menu">

                    <li>
                        <a href="home.php"><i class="fa fa-dashboard"></i> Status</a>
                    </li>
                    <li>
                        <a href="messages.php"><i class="fa fa-desktop"></i> Maintenance</a>
                    </li>
                    <li>
                        <a href="roombook.php"><i class="fa fa-bar-chart-o"></i>Room Booking</a>
                    </li>
                    <li>
                        <a href="reservation.php"><i class="fa fa-bar-chart-o"></i>Walk-in
                            Reservation</a>
                    </li>
                    <li>
                        <a href="payment.php"><i class="fa fa-qrcode"></i> Payment</a>
                    </li>
                    <li>
                        <a href="profit.php"><i class="fa fa-qrcode"></i> Profit</a>
                    </li>
                    <li>
                        <a class="active-menu"  href="food_menu.php"><i class="fa fa-qrcode"></i>Food Menu</a>
                    </li>
                    <li>
                        <a href="logout.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                    </li>



            </div>

        </nav>
        <!-- /. NAV SIDE  -->
        <div id="page-wrapper">
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-header">
                            Food Menu<small> </small>
                        </h1>
                    </div>
                </div>
                <!-- /. ROW  -->


                <div class="row">



                    <br>
                    <br>
                    <br>
                    <?php
if (isset($_POST['food'])) {
    $food_name = $_POST['food_name'];
    $food_description = $_POST['food_description'];

    // Validate inputs
    if (!empty($food_name) && !empty($food_description)) {
        // Database connection
        
        // Check for connection errors
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Prepare and execute the query
        $stmt = $conn->prepare("INSERT INTO `food_menu` (`food_name`, `food_description`) VALUES (?, ?)");
        $stmt->bind_param("ss", $food_name, $food_description);

        if ($stmt->execute()) {
            echo "<script> alert('Food item added successfully.')</script>";
        } else {
            echo "Error: " . $stmt->error;
        }

    } else {
    }
}
if (isset($_POST['delFood'])) {
    $food_id = $_POST['foodId'];
    echo $food_id;

    // Validate inputs

        // Database connection
        
        // Check for connection errors
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Prepare and execute the query
        $stmt = $conn->prepare("DELETE FROM `food_menu` WHERE `food_id` = ?");
        $stmt->bind_param("i", $food_id);

        if ($stmt->execute()) {
            echo "<script> alert('Food item deleted successfully.')</script>";
        } else {
            echo "Error: " . $stmt->error;
        }

    } else {
    }

                    ?>
<!-- Add Food Modal -->
<div class="modal fade" id="addFoodModal" tabindex="-1" aria-labelledby="addFoodModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addFoodModalLabel">Add Food</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addFoodForm" method="POST">
                    <div class="mb-3">
                        <label for="food_name" class="form-label">Food Name</label>
                        <input type="text" class="form-control" id="food_name" name="food_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="food_description" class="form-label">Description</label>
                        <textarea class="form-control" id="food_description" name="food_description"  required></textarea>
                    </div>
                    <br>
                    <button type="submit" class="btn btn-primary" name="food">Add Food</button>
                </form>
            </div>
        </div>
    </div>
</div>

                    <button class="btn btn-primary" data-toggle="modal" data-target="#addFoodModal" style="margin:0 10px 10px 0 ">Add New Menu</button>
                    <div class="col-md-12">
                        <!-- Advanced Tables -->
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover"
                                        id="dataTables-example">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Menu Name</th>
                                                <th>food Description</th>
                                                <th>action</th>

                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php

                                            $sql = "SELECT * FROM `food_menu`";

                                            $re = mysqli_query($conn, $sql);
                                            while ($row = mysqli_fetch_array($re)) {
                                                $food_id = $row['food_id'];
                                                $food_name = $row['food_name'];
                                                $food_description = $row['food_description'];
                                                ?>
                                                <tr >
                                                        <td><?php echo $food_id?></td>
                                                        <td><?php echo $food_name?></td>
                                                        <td><?php echo $food_description?></td>
                                                        
                                                        <td>
                                                        <form method="POST">
                                                            <input type="hidden" value="<?php echo $food_id?>" name="foodId" id="">
                                                            <button type="submit" class="btn btn-danger" name="delFood">Delete</button>
                                                        </td>
                                                    </tr>
                                                    <?php } ?>



                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                        <!--End Advanced Tables -->
                    </div>
                </div>
                <!-- /. ROW  -->

            </div>

        </div>


    </div>
    <!-- /. PAGE INNER  -->
    </div>
    <!-- /. PAGE WRAPPER  -->
    <!-- /. WRAPPER  -->
    <!-- JS Scripts-->
    <!-- jQuery Js -->
    <script src="assets/js/jquery-1.10.2.js"></script>
    <!-- Bootstrap Js -->
    <script src="assets/js/bootstrap.min.js"></script>
    <!-- Metis Menu Js -->
    <script src="assets/js/jquery.metisMenu.js"></script>
    <!-- DATA TABLE SCRIPTS -->
    <script src="assets/js/dataTables/jquery.dataTables.js"></script>
    <script src="assets/js/dataTables/dataTables.bootstrap.js"></script>
    <script>
    </script>
    <!-- Custom Js -->
    <script src="assets/js/custom-scripts.js"></script>


</body>

</html>
<script>
    Morris.Bar({
        element: 'chart',
        data: [<?php echo $chart_data; ?>],
        xkey: 'date',
        ykeys: ['profit'],
        labels: ['Profit'],
        hideHover: 'auto',
        stacked: true
    });
</script>