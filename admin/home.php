<?php
session_start();
include('db.php');
// Debugging: Print or log session variables
// print_r($_SESSION);

if (!isset($_SESSION["user"])) {
    echo "User not set in session. Redirecting...";
    header("location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Administrator </title>
    <!-- Bootstrap Styles-->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FontAwesome Styles-->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- Morris Chart Styles-->
    <link href="assets/js/morris/morris-0.4.3.min.css" rel="stylesheet" />
    <!-- Custom Styles-->
    <link href="assets/css/custom-styles.css" rel="stylesheet" />
    <!-- Google Fonts-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css">
</head>

<body>
    <style>
        h3 {
            margin-left: 20px;
        }
    </style>
    <div id="wrapper">
        <?php
        include('./navbar.php');
        ?>
        <!--/. NAV TOP  -->
        <nav class="navbar-default navbar-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="main-menu">

                    <li>
                        <a class="active-menu" href="home.php"><i class="fa fa-dashboard"></i> Status</a>
                    </li>
                    <li>
                        <a href="messages.php"><i class="fa fa-desktop"></i> Maintenance</a>
                    </li>
                    <li>
                        <a href="roombook.php"><i class="fa fa-bar-chart-o"></i> Room Booking</a>
                    </li>
                    <li>
                        <a href="reservation.php"><i class="fa fa-bar-chart-o"></i>Walk-in Reservation</a>
                    </li>
                    <li>
                        <a href="payment.php"><i class="fa fa-qrcode"></i> Payment</a>
                    </li>
                    <li>
                        <a href="profit.php"><i class="fa fa-qrcode"></i> Profit</a>
                    </li>
                    <li>
                        <a href="food_menu.php"><i class="fa fa-qrcode"></i>Food Menu</a>
                    </li>
                    <li>
                        <a href="logout.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                    </li>




                </ul>

            </div>

        </nav>
        <!-- /. NAV SIDE  -->
        <div id="page-wrapper">
            <div id="page-inner">


                <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-header">
                            Status <small>Room Booking </small>
                        </h1>
                    </div>
                </div>
                <!-- /. ROW  -->
                <?php

                $sql = "select * from tblbooking";
                $re = mysqli_query($conn, $sql);
                $c = 0;
                while ($row = mysqli_fetch_array($re)) {
                    $new = $row['Status'];
                    $cin = $row['CheckinDate'];
                    $id = $row['ID'];
                    if ($new == "Pending") {
                        $c = $c + 1;


                    }

                }
                ?>

                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">

                            </div>
                            <h3>Walk-in Reservation</h3>
                            <div class="panel-body">
                                <div class="panel-group" id="accordion">

                                    <div class="panel panel-primary">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
                                                    <button class="btn btn-default" type="button">
                                                        New Room Bookings <span class="badge"><?php echo $c; ?></span>
                                                    </button>
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="collapseTwo" class="panel-collapse in" style="height: auto;">
                                            <div class="panel-body">
                                                <div class="panel panel-default">

                                                    <div class="panel-body">
                                                        <div class="table-responsive">
                                                            <table class="table">
                                                                <thead>
                                                                    <tr>
                                                                        <th>#</th>
                                                                        <th>Name</th>
                                                                        <th>Email</th>
                                                                        <th>Room</th>
                                                                        <th>Check In</th>
                                                                        <th>Check Out</th>
                                                                        <th>Status</th>
                                                                        <th>Payment</th>
                                                                        <th>Action</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>

                                                                    <?php
                                                                    $tsql = "SELECT b.ID, u.FullName, u.Email, r.RoomName, b.CheckinDate, b.CheckoutDate, b.Status, b.downPay
                 FROM tblbooking b
                 INNER JOIN tblreservation u ON b.UserID = u.ID
                 INNER JOIN tblroom r ON b.RoomId = r.ID
                 WHERE b.Status = 'Pending'";

                                                                    $tre = mysqli_query($conn, $tsql);

                                                                    while ($trow = mysqli_fetch_array($tre)) {
                                                                        echo "<tr>
                    <td>" . $trow['ID'] . "</td>
                    <td>" . $trow['FullName'] . "</td>
                    <td>" . $trow['Email'] . "</td>
                    <td>" . $trow['RoomName'] . "</td>
                    <td>" . $trow['CheckinDate'] . "</td>
                    <td>" . $trow['CheckoutDate'] . "</td>
                    <td>" . $trow['Status'] . "</td>
                    <td>&#8369; " . $trow['downPay'] . "</td>
                    <td>
                        <form method='post' action=''>
                            <input type='hidden' name='booking_id' value='" . $trow['ID'] . "'>
                            <div class='form-check'>
                                <input type='checkbox' class='form-check-input' name='selected_bookings[]' value='" . $trow['ID'] . "'>
                                <label class='form-check-label'>Select</label>
                            </div>
                        </td>
                    </tr>";
                                                                    }

                                                                    if (isset($_POST['approve_selected'])) {
                                                                        if (!empty($_POST['selected_bookings'])) {
                                                                            $selected_bookings = implode(',', $_POST['selected_bookings']);
                                                                            // Update the status to Approved in your database for selected bookings
                                                                            $updateSql = "UPDATE tblbooking SET Status = 'Approved' WHERE ID IN ($selected_bookings)";
                                                                            mysqli_query($conn, $updateSql);
                                                                            echo "<script>window.location.href='home.php';</script>"; // Redirect using JavaScript
                                                                            exit();
                                                                        }
                                                                    }

                                                                    if (isset($_POST['cancel_selected'])) {
                                                                        if (!empty($_POST['selected_bookings'])) {
                                                                            $selected_bookings = implode(',', $_POST['selected_bookings']);
                                                                            // Update the status to Canceled in your database for selected bookings
                                                                            $updateSql = "UPDATE tblbooking SET Status = 'Canceled' WHERE ID IN ($selected_bookings)";
                                                                            mysqli_query($conn, $updateSql);
                                                                            echo "<script>window.location.href='home.php';</script>"; // Redirect using JavaScript
                                                                            exit();
                                                                        }
                                                                    }
                                                                    ?>

                                                                </tbody>
                                                            </table>

                                                            <!-- Add the following buttons for bulk actions -->
                                                            <form method='post' action=''>
                                                                <input type='submit' class='btn btn-success'
                                                                    name='approve_selected' value='Approve Selected'>
                                                                <input type='submit' class='btn btn-danger'
                                                                    name='cancel_selected' value='Cancel Selected'>
                                                            </form>


                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- End  Basic Table  -->
                                            </div>
                                        </div>
                                    </div>
                                    <?php

                                    $rsql = "SELECT * FROM `tblbooking`";
                                    $rre = mysqli_query($conn, $rsql);
                                    $r = 0;
                                    while ($row = mysqli_fetch_array($rre)) {
                                        $br = $row['Status'];
                                        if ($br == "Approved") {
                                            $r = $r + 1;



                                        }


                                    }

                                    ?>

                                    <div class="modal fade" id="calendarModal" tabindex="-1" role="dialog"
                                        aria-labelledby="calendarModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title" id="calendarModalLabel">Calendar</h4>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div id="calendar"></div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default"
                                                        data-dismiss="modal">Close</button>
                                                    <button type="button" class="btn btn-primary">Save changes</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- 2. Add this CSS -->
                                    <style>
                                        #calendar {
                                            width: 100%;
                                            min-height: 600px;
                                            margin: 0;
                                            padding: 0;
                                        }

                                        .modal-dialog.modal-lg {
                                            max-width: 900px;
                                            width: 90%;
                                            margin: 30px auto;
                                        }

                                        .modal-content {
                                            height: auto;
                                            min-height: 700px;
                                        }

                                        .modal-body {
                                            padding: 20px;
                                            height: auto;
                                            min-height: 500px;
                                        }

                                        .fc {
                                            height: 100% !important;
                                        }

                                        .fc .fc-view-harness {
                                            height: 500px !important;
                                        }

                                        .fc-header-toolbar {
                                            padding: 10px 0;
                                        }
                                    </style>
                                    <div class="panel panel-info">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                        </div>

                                    </div>


                                </div>


                                <!-- DEOMO-->
                                <!--<div class='panel-body'>
                            <button class='btn btn-primary btn' data-toggle='modal' data-target='#myModal'>
                              Update 
                            </button>
                            <div class='modal fade' id='myModal' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
                                <div class='modal-dialog'>
                                    <div class='modal-content'>
                                        <div class='modal-header'>
                                            <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
                                            <h4 class='modal-title' id='myModalLabel'>Change the User name and Password</h4>
                                        </div>
                                        <form method='post>
                                        <div class='modal-body'>
                                            <div class='form-group'>
                                            <label>Change User name</label>
                                            <input name='usname' value='<?php echo $fname; ?>' class='form-control' placeholder='Enter User name'>
                                            </div>
                                        </div>
                                        <div class='modal-body'>
                                            <div class='form-group'>
                                            <label>Change Password</label>
                                            <input name='pasd' value='<?php echo $ps; ?>' class='form-control' placeholder='Enter Password'>
                                            </div>
                                        </div>
                                        
                                        <div class='modal-footer'>
                                            <button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
                                            
                                           <input type='submit' name='up' value='Update' class='btn btn-primary'>
                                          </form>
                                           
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>-->

                                <!--DEMO END-->




                                <!-- /. ROW  -->

                            </div>

                            <h3>Online Reservation</h3>
                            <div class="panel-body">

                                <div class="panel-group" id="accordion">

                                    <div class="panel panel-primary">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
                                                    <button class="btn btn-default" type="button">
                                                        New Room Bookings <span class="badge"><?php echo $c; ?></span>
                                                    </button>
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="collapseTwo" class="panel-collapse in" style="height: auto;">
                                            <div class="panel-body">
                                                <div class="panel panel-default">

                                                    <div class="panel-body">
                                                        <div class="table-responsive">
                                                            <table class="table">
                                                                <thead>
                                                                    <tr>
                                                                        <th>#</th>
                                                                        <th>Name</th>
                                                                        <th>Email</th>
                                                                        <th>Room</th>
                                                                        <th>Check In</th>
                                                                        <th>Check Out</th>
                                                                        <th>Status</th>
                                                                        <th>Payment</th>
                                                                        <th>Action</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>

                                                                    <?php
                                                                    $tsql = "SELECT b.ID, u.FullName, u.Email, r.RoomName, b.CheckinDate, b.CheckoutDate, b.Status, b.downPay
                 FROM tblbooking b
                 INNER JOIN tbluser u ON b.UserID = u.ID
                 INNER JOIN tblroom r ON b.RoomId = r.ID
                 WHERE b.Status = 'Pending'";

                                                                    $tre = mysqli_query($conn, $tsql);

                                                                    while ($trow = mysqli_fetch_array($tre)) {
                                                                        echo "<tr>
                    <td>" . $trow['ID'] . "</td>
                    <td>" . $trow['FullName'] . "</td>
                    <td>" . $trow['Email'] . "</td>
                    <td>" . $trow['RoomName'] . "</td>
                    <td>" . $trow['CheckinDate'] . "</td>
                    <td>" . $trow['CheckoutDate'] . "</td>
                    <td>" . $trow['Status'] . "</td>
                    <td>&#8369; " . $trow['downPay'] . "</td>
                    <td>
                        <form method='post' action=''>
                            <input type='hidden' name='booking_id' value='" . $trow['ID'] . "'>
                            <div class='form-check'>
                                <input type='checkbox' class='form-check-input' name='selected_bookings[]' value='" . $trow['ID'] . "'>
                                <label class='form-check-label'>Select</label>
                            </div>
                        </td>
                    </tr>";
                                                                    }

                                                                    if (isset($_POST['approve_selected'])) {
                                                                        if (!empty($_POST['selected_bookings'])) {
                                                                            $selected_bookings = implode(',', $_POST['selected_bookings']);
                                                                            // Update the status to Approved in your database for selected bookings
                                                                            $updateSql = "UPDATE tblbooking SET Status = 'Approved' WHERE ID IN ($selected_bookings)";
                                                                            mysqli_query($conn, $updateSql);
                                                                            echo "<script>window.location.href='home.php';</script>"; // Redirect using JavaScript
                                                                            exit();
                                                                        }
                                                                    }

                                                                    if (isset($_POST['cancel_selected'])) {
                                                                        if (!empty($_POST['selected_bookings'])) {
                                                                            $selected_bookings = implode(',', $_POST['selected_bookings']);
                                                                            // Update the status to Canceled in your database for selected bookings
                                                                            $updateSql = "UPDATE tblbooking SET Status = 'Canceled' WHERE ID IN ($selected_bookings)";
                                                                            mysqli_query($conn, $updateSql);
                                                                            echo "<script>window.location.href='home.php';</script>"; // Redirect using JavaScript
                                                                            exit();
                                                                        }
                                                                    }
                                                                    ?>

                                                                </tbody>
                                                            </table>

                                                            <!-- Add the following buttons for bulk actions -->
                                                            <form method='post' action=''>
                                                                <input type='submit' class='btn btn-success'
                                                                    name='approve_selected' value='Approve Selected'>
                                                                <input type='submit' class='btn btn-danger'
                                                                    name='cancel_selected' value='Cancel Selected'>
                                                            </form>


                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- End  Basic Table  -->
                                            </div>
                                        </div>
                                    </div>
                                    <?php

                                    $rsql = "SELECT * FROM `tblbooking`";
                                    $rre = mysqli_query($conn, $rsql);
                                    $r = 0;
                                    while ($row = mysqli_fetch_array($rre)) {
                                        $br = $row['Status'];
                                        if ($br == "Approved") {
                                            $r = $r + 1;



                                        }


                                    }

                                    ?>

                                    <div class="modal fade" id="calendarModal" tabindex="-1" role="dialog"
                                        aria-labelledby="calendarModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title" id="calendarModalLabel">Calendar</h4>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div id="calendar"></div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default"
                                                        data-dismiss="modal">Close</button>
                                                    <button type="button" class="btn btn-primary">Save changes</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Modal for extending booking -->
                                    <div id="extendModal" class="modal fade" tabindex="-1"
                                        aria-labelledby="extendModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="extendModalLabel">Extend Booking</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="extendForm">
                                                        <!-- Checkout Date input -->
                                                        <div class="mb-3">
                                                            <label for="checkout_date" class="form-label">Checkout
                                                                Date</label>
                                                            <input type="text" class="form-control" id="checkout_date"
                                                                readonly>
                                                        </div>

                                                        <!-- New Extend Date input -->
                                                        <div class="mb-3">
                                                            <label for="extend_date" class="form-label">New Extend
                                                                Date</label>
                                                            <input type="date" class="form-control" id="extend_date"
                                                                required>
                                                        </div>

                                                        <!-- Extend button -->
                                                        <div class="d-flex justify-content-end">
                                                            <button type="button" id="extendbtn"
                                                                class="btn btn-primary">Extend</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <!-- 2. Add this CSS -->
                                    <style>
                                        #calendar {
                                            width: 100%;
                                            min-height: 600px;
                                            margin: 0;
                                            padding: 0;
                                        }

                                        .modal-dialog.modal-lg {
                                            max-width: 900px;
                                            width: 90%;
                                            margin: 30px auto;
                                        }

                                        .modal-content {
                                            height: auto;
                                            min-height: 700px;
                                        }

                                        .modal-body {
                                            padding: 20px;
                                            height: auto;
                                            min-height: 500px;
                                        }

                                        .fc {
                                            height: 100% !important;
                                        }

                                        .fc .fc-view-harness {
                                            height: 500px !important;
                                        }

                                        .fc-header-toolbar {
                                            padding: 10px 0;
                                        }
                                    </style>
                                    <div class="panel panel-info">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne"
                                                    class="collapsed">
                                                    <button class="btn btn-primary" type="button">
                                                        Approve Bookings <span class="badge"><?php echo $r; ?></span>
                                                    </button>

                                                </a>
                                            </h4>
                                        </div>
                                        <div id="collapseOne" class="panel-collapse collapse" style="height: 0px;">
                                            <div class="panel-body">
                                                <?php
                                                $msql = "SELECT * FROM `tblbooking`";
                                                $mre = mysqli_query($conn, $msql);
                                                $msql1 = "SELECT * FROM `tblbooking`";
                                                $mre1 = mysqli_query($conn, $msql1);
                                                $mrow1 = mysqli_fetch_array($mre1);
                                                while ($mrow = mysqli_fetch_array($mre)) {
                                                    $br = $mrow['Status'];
                                                    if ($br == "Approved") {
                                                        $fid = $mrow['ID'];

                                                        echo "<div class='col-md-3 col-sm-12 col-xs-12'>
													<div class='panel panel-primary text-center no-boder bg-color-blue'>
														<div class='panel-body'>
															<i class='fa fa-users fa-5x'></i>
															<h3>" . $mrow['ID'] . "</h3>
														</div>
														<div class='panel-footer back-footer-blue'>
                                                        <button class='btn btn-primary btn check' data-toggle='modal' data-target='#calendarModal' data-id='$fid'>Show Check-In Status</button>
                                                        <button class='btn btn-primary btn extend' data-toggle='modal' data-target='#extendModal' data-id='$fid'>Extend Date</button>
														
														<a href=show.php?sid=" . $fid . ">
                                                        <button  class='btn btn-primary btn' data-toggle='modal' data-target='#myModal'>
													Show
													</button></a>
															" . $mrow['RoomId'] . "
														</div>
													</div>	
											 </div>";





                                                    }


                                                }
                                                ?>


                                            </div>

                                        </div>

                                    </div>


                                </div>


                                <!-- DEOMO-->
                                <!--<div class='panel-body'>
                            <button class='btn btn-primary btn' data-toggle='modal' data-target='#myModal'>
                              Update 
                            </button>
                            <div class='modal fade' id='myModal' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
                                <div class='modal-dialog'>
                                    <div class='modal-content'>
                                        <div class='modal-header'>
                                            <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
                                            <h4 class='modal-title' id='myModalLabel'>Change the User name and Password</h4>
                                        </div>
                                        <form method='post>
                                        <div class='modal-body'>
                                            <div class='form-group'>
                                            <label>Change User name</label>
                                            <input name='usname' value='<?php echo $fname; ?>' class='form-control' placeholder='Enter User name'>
                                            </div>
                                        </div>
                                        <div class='modal-body'>
                                            <div class='form-group'>
                                            <label>Change Password</label>
                                            <input name='pasd' value='<?php echo $ps; ?>' class='form-control' placeholder='Enter Password'>
                                            </div>
                                        </div>
                                        
                                        <div class='modal-footer'>
                                            <button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
                                            
                                           <input type='submit' name='up' value='Update' class='btn btn-primary'>
                                          </form>
                                           
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>-->

                                <!--DEMO END-->




                                <!-- /. ROW  -->

                            </div>

                            <!-- /. PAGE INNER  -->
                        </div>
                        <!-- /. PAGE WRAPPER  -->
                    </div>
                    <!-- /. WRAPPER  -->
                    <!-- JS Scripts-->
                    <!-- jQuery Js -->
                    <script src="assets/js/jquery-1.10.2.js"></script>
                    <!-- Bootstrap Js -->
                    <script src="assets/js/bootstrap.min.js"></script>
                    <!-- Metis Menu Js -->
                    <script src="assets/js/jquery.metisMenu.js"></script>
                    <!-- Morris Chart Js -->
                    <script src="assets/js/morris/raphael-2.1.0.min.js"></script>
                    <script src="assets/js/morris/morris.js"></script>
                    <!-- Custom Js -->
                    <script src="assets/js/custom-scripts.js"></script>
                    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
                    <script>

                        document.addEventListener('DOMContentLoaded', function () {
                            const extendElements = document.querySelectorAll('.extend');

                            // Loop through each extend button and add the event listener
                            extendElements.forEach(function (element) {
                                element.addEventListener('click', function () {
                                    const bookingId = element.getAttribute('data-id'); // Get the data-id attribute of the clicked element

                                    // Fetch event details related to the bookingId
                                    $.ajax({
                                        url: 'fetch_events1.php',  // Replace with the actual URL
                                        type: 'POST',
                                        data: { bookingId: bookingId }, // Pass booking ID as a parameter
                                        success: function (response) {
                                            // If the booking ID exists and data is fetched, update the form
                                            if (response.CheckoutDate) {
                                                // Set the checkout date to the input field
                                                document.querySelector('#checkout_date').value = response.CheckoutDate;

                                                // Dynamically create a modal or form specific to this bookingId
                                                const extendForm = document.querySelector('#extendForm');
                                                extendForm.setAttribute('data-booking-id', bookingId); // Store bookingId in form

                                                // Show the modal (if using modal)
                                                $('#extendModal').modal('show');
                                            }
                                        },
                                        error: function () {
                                            alert('Error fetching event data');
                                        }
                                    });
                                });
                            });

                            // Handle extend button click
                            document.querySelector('#extendbtn').addEventListener('click', function () {
                                const extendDate = document.querySelector('#extend_date').value; // Get the new extend date value
                                const bookingId = document.querySelector('#extendForm').getAttribute('data-booking-id'); // Get bookingId from form

                                // Send the updated extend date via AJAX to update the database
                                $.ajax({
                                    url: 'update_extend_date.php',  // URL to the update PHP file
                                    type: 'POST',
                                    data: {
                                        bookingId: bookingId,      // Pass the booking ID
                                        extendDate: extendDate      // Pass the new extend date
                                    },
                                    success: function (response) {
                                        if (response.success) {
                                            alert('Extend date updated successfully!');
                                            $('#extendModal').modal('hide');  // Hide modal after successful update
                                        } else {
                                            alert('Failed to update extend date.');
                                        }
                                    },
                                    error: function () {
                                        alert('Error occurred while updating extend date.');
                                    }
                                });
                            });




                            // Initialize calendar when modal is shown
                            // Add event listeners to all elements with the class "check"
                            document.querySelectorAll('.check').forEach(button => {
                                button.addEventListener('click', function () {
                                    // Get the data-id attribute from the clicked button
                                    const bookingId = button.getAttribute('data-id');
                                    // Show the modal
                                    $('#calendarModal').modal('show');

                                    // Initialize the calendar once the modal is shown
                                    $('#calendarModal').on('shown.bs.modal', function () {
                                        const calendarEl = document.getElementById('calendar');

                                        // Destroy any existing calendar instance
                                        if (calendarEl._calendar) {
                                            calendarEl._calendar.destroy();
                                        }

                                        // Initialize FullCalendar
                                        const calendar = new FullCalendar.Calendar(calendarEl, {
                                            initialView: 'dayGridMonth',
                                            height: '100%',
                                            headerToolbar: {
                                                left: 'prev,next today',
                                                center: 'title',
                                                right: 'dayGridMonth,timeGridWeek,timeGridDay'
                                            },
                                            events: function (info, successCallback, failureCallback) {
                                                // Fetch events from the server
                                                $.ajax({
                                                    url: 'fetch_events.php',  // Replace with the actual URL
                                                    type: 'POST',
                                                    data: { bookingId: bookingId }, // Pass booking ID as a parameter
                                                    success: function (response) {

                                                        const events = response.flatMap(booking => [
                                                            {
                                                                title: 'Booked',
                                                                start: booking.BookingDate,
                                                                backgroundColor: '#ffc107', // Yellow color
                                                                borderColor: '#ffc107',     // Match the border to the background
                                                                textColor: '#000000'
                                                            },
                                                            {
                                                                title: 'Check-in to Stay',
                                                                start: booking.CheckinDate,
                                                                end: booking.CheckoutDate, // Use the correct value directly from `booking`
                                                                backgroundColor: '#28a745', // Green range
                                                                borderColor: '#28a745',
                                                                textColor: '#ffffff',
                                                            },
                                                            {
                                                                title: 'Checkout Day',
                                                                start: booking.CheckoutDate,
                                                                end: booking.CheckoutDate,
                                                                backgroundColor: '#dc3545', // Red checkout
                                                                borderColor: '#dc3545',
                                                                textColor: '#ffffff',
                                                            },
                                                            {
                                                                title: 'Extended Date',
                                                                start: booking.CheckoutDate,
                                                                end: booking.extendDate,
                                                                backgroundColor: '#ffc107', // Yellow color
                                                                borderColor: '#28a745',     // Green border color
                                                                textColor: '#ffffff',
                                                            },
                                                            {
                                                                title: 'Extended Checkout Day',
                                                                start: booking.extendDate,
                                                                end: booking.extendDate,
                                                                backgroundColor: '#dc3545', // Red checkout
                                                                borderColor: '#dc3545',
                                                                textColor: '#ffffff',
                                                            }
                                                        ]);

                                                        successCallback(events);
                                                    },
                                                    error: function () {
                                                        alert('error')
                                                        failureCallback();
                                                    }
                                                });
                                            },
                                            eventDidMount: function (info) {
                                                // Add tooltips to events
                                                $(info.el).tooltip({
                                                    title: info.event.title,
                                                    placement: 'top',
                                                    trigger: 'hover',
                                                    container: 'body'
                                                });
                                            },
                                            dayMaxEvents: true,
                                            handleWindowResize: true,
                                            expandRows: true
                                        });

                                        calendar.render();
                                        calendarEl._calendar = calendar;

                                        // Adjust size after rendering
                                        setTimeout(() => {
                                            calendar.updateSize();
                                        }, 300);
                                    });

                                    // Clean up the calendar when the modal is hidden
                                    $('#calendarModal').on('hidden.bs.modal', function () {
                                        const calendarEl = document.getElementById('calendar');
                                        if (calendarEl._calendar) {
                                            calendarEl._calendar.destroy();
                                            calendarEl._calendar = null;
                                        }
                                    });
                                });
                            });

                        });
                    </script>

</body>

</html>