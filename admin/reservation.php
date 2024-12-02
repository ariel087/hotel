<?php
include('db.php');
include('../includes/dbconnection.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Include the PHPMailer files
require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

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
    <!-- Morris Chart Styles-->

    <!-- Custom Styles-->
    <link href="assets/css/custom-styles.css" rel="stylesheet" />
    <!-- Google Fonts-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    <!-- TABLE STYLES-->
    <link href="assets/js/dataTables/dataTables.bootstrap.css" rel="stylesheet" />
</head>

<body>
    <div id="wrapper">

    <div id="wrapper">
        
    <?php
        include('./navbar.php');
?>
        <!--/. NAV TOP  -->
        
        <nav class="navbar-default navbar-side" role="navigation">
            <div class="sidebar-collapse">
            <ul class="nav" id="main-menu">

<li>
    <a  href="home.php"><i class="fa fa-dashboard"></i> Status</a>
</li>
<li>
    <a href="messages.php"><i class="fa fa-desktop"></i> Maintenance</a>
</li>
<li>
    <a href="roombook.php"><i class="fa fa-bar-chart-o"></i> Room Booking</a>
</li>
<li>
    <a class="active-menu"   href="reservation.php"><i class="fa fa-bar-chart-o"></i>Walk-in Reservation</a>
</li>
<li>
    <a href="payment.php"><i class="fa fa-qrcode"></i> Payment</a>
</li>
<li>
    <a href="profit.php"><i class="fa fa-qrcode"></i> Profit</a>
</li>
<li>
    <a href="logout.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
</li>




</ul>                    


                    
            </div>

        </nav>

        <div id="page-wrapper">
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-header">
                            RESERVATION <small></small>
                        </h1>
                    </div>
                </div>


                <div class="row">

                    <div class="col-md-5 col-sm-5">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                PERSONAL INFORMATION
                            </div>
                            <div class="panel-body">
                                <form name="form" method="post">

                                    <div class="form-group">
                                        <label>First Name</label>
                                        <input name="fname" class="form-control" required>

                                    </div>
                                    <div class="form-group">
                                        <label>Last Name</label>
                                        <input name="lname" class="form-control" required>

                                    </div>
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input name="email" type="email" class="form-control" required>

                                    </div>
                                    <div class="form-group">
                                        <label>Phone Number</label>
                                        <input name="phone" type="text" class="form-control" required>

                                    </div>
                                    <div class="form-group">
                                        <label>Address</label>
                                        <textarea class="form-control"
                                            style="height:200px;width:300px;resize:none;color:black;" type="text"
                                            rows="10" name="address" required="true"></textarea>

                                    </div>
                                    <style>
                                        .gender {
                                            display: flex;
                                            align-items: center;
                                            gap: 5px;
                                        }
                                    </style>
                                    <label>Gender</label>
                                    <div class="form-group gender">
                                        <input type="radio" name="gender" id="gender" value="Female"
                                            checked="true"><span>Female</span>
                                        <input type="radio" name="gender" id="gender" value="Male"><span>Male</span>

                                    </div>
                                    <div class="form-group">
                                        <label>ID Type</label>
                                        <select style="width:300px;" type="text" value="" class="form-control"
                                            name="idtype" required="true" class="form-control">

                                            <option value="">Choose ID Type</option>

                                            <option value="Voter Card">Voter Card</option>

                                            <option value="Driving Licence Card">Driving Licence Card</option>

                                            <option value="Passport">Passport</option>

                                        </select>
                                    </div>

                            </div>

                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    RESERVATION INFORMATION
                                </div>
                                <div class="panel-body">
                                    <div class="form-group">
                                        <label>Type Of Room *</label>
                                        <select name="troom" class="form-control" required>
                                            <?php
                                            $roomSql = "SELECT * FROM `tblroom`";
                                            $roomQuery = mysqli_query($conn, $roomSql);
                                            ?>
                                            <option value="" selected disabled>Select a room</option>
                                            <?php
                                            while ($roomResult = mysqli_fetch_array($roomQuery)) {
                                                ?>
                                                <option value="<?php echo $roomResult['ID']; ?>">
                                                    <?php echo $roomResult['RoomName']; ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Check-In</label>
                                        <input name="cin" type="date" class="form-control">

                                    </div>
                                    <div class="form-group">
                                        <label>Check-Out</label>
                                        <input name="cout" type="date" class="form-control">

                                    </div>
                                    <div class="form-group">
                                        <label>Down Payment</label>
                                        <input name="downPay" type="number" class="form-control">

                                    </div>
                                    <input type="submit" name="submit" class="btn btn-primary">
                                    </form>
                                </div>

                            </div>
                        </div>




                        <?php



                        if (isset($_POST['submit'])) {

                            $id = 2024 . random_int(100000, 999999);
                            $fname = $_POST['fname'];
                            $lname = $_POST['lname'];
                            $email = $_POST['email'];
                            $phone = $_POST['phone'];
                            $fullname = $fname . " " . $lname;

                            $booknum = mt_rand(100000000, 999999999);
                            $rid = intval($_POST['troom']);
                            $uid = $id;
                            $idtype = $_POST['idtype'];
                            $gender = $_POST['gender'];
                            $address = $_POST['address'];
                            $checkindate = $_POST['cin'];
                            $checkoutdate = $_POST['cout'];
                            $downPay = $_POST['downPay'];
                            $cdate = date('Y-m-d');

                            if ($checkindate < $cdate) {
                                echo '<script>alert("Check-in date must be greater than the current date")</script>';
                            } else if ($checkindate > $checkoutdate) {
                                echo '<script>alert("Check-out date must be equal to or greater than the check-in date")</script>';
                            } else if ($downPay != 2500) {
                                echo '<script>alert("Down payment must be equal to 2500 pesos")</script>';
                            } else {
                                // Check room availability
                                $checkAvailabilitySql = "SELECT * FROM tblbooking 
                                WHERE RoomId = ? 
                                AND (? < CheckoutDate AND ? > CheckinDate)";

                                $stmt = $conn->prepare($checkAvailabilitySql);
                                $stmt->bind_param("iss", $rid, $checkindate, $checkoutdate); // Bind parameters: RoomId (int), CheckinDate (string), CheckoutDate (string)
                                $stmt->execute();
                                $checkAvailabilityQuery = $stmt->get_result();

                                // Check if any overlapping bookings exist
                                if ($checkAvailabilityQuery->num_rows > 0) {
                                    echo '<script>alert("Sorry, the room is not available for the selected dates. Please choose different dates.")</script>';
                                } else {
                                    $sqlinsertuser = "INSERT INTO `tblreservation`(`ID`, `FullName`, `MobileNumber`, `Email`,`status`)
                                    VALUES ('$id', '$fullname','$phone','$email','Pending')";

                                    $queryuser = mysqli_query($conn, $sqlinsertuser);
                                    // Proceed with inserting the booking
                                    $sql = "INSERT INTO tblbooking(RoomId, BookingNumber, UserID, IDType, Gender, Address, CheckinDate, CheckoutDate, downPay) 
                                            VALUES(:rid, :booknum, :uid, :idtype, :gender, :address, :checkindate, :checkoutdate, :downPay)";
                                    $query = $dbh->prepare($sql);
                                    $query->bindParam(':rid', $rid, PDO::PARAM_STR);
                                    $query->bindParam(':booknum', $booknum, PDO::PARAM_STR);
                                    $query->bindParam(':uid', $uid, PDO::PARAM_STR);
                                    $query->bindParam(':idtype', $idtype, PDO::PARAM_STR);
                                    $query->bindParam(':gender', $gender, PDO::PARAM_STR);
                                    $query->bindParam(':address', $address, PDO::PARAM_STR);
                                    $query->bindParam(':checkindate', $checkindate, PDO::PARAM_STR);
                                    $query->bindParam(':checkoutdate', $checkoutdate, PDO::PARAM_STR);
                                    $query->bindParam(':downPay', $downPay, PDO::PARAM_STR);
                                    $query->execute();


                                    $uid = $id;
                                    $userSql = "SELECT * FROM tblreservation WHERE ID = :uid";
                                    $userQuery = $dbh->prepare($userSql);
                                    $userQuery->bindParam(':uid', $uid, PDO::PARAM_STR);
                                    $userQuery->execute();
                                    $userResult = $userQuery->fetch(PDO::FETCH_ASSOC);

                                    // Send booking confirmation email
                                    $mail = new PHPMailer(true);
                                    try {
                                        // Server settings
                                        $mail->isSMTP();
                                        $mail->Host = 'smtp.gmail.com';
                                        $mail->SMTPAuth = true;
                                        $mail->Username = 'amthysthotel@gmail.com';
                                        $mail->Password = 'xcierarrpfshpyzd';
                                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                                        $mail->Port = 465;

                                        // Recipients
                                        $mail->setFrom('amthysthotel@gmail.com');
                                        $mail->addAddress($email);

                                        // Content
                                        $mail->isHTML(true);
                                        $mail->Subject = 'Booking Confirmation';
                                        $mail->Body = 'Thank you for booking with us! Your booking details are as follows:<br><br>' .
                                            'Booking Number: ' . $bookingNumber . '<br>' .
                                            'Check-in Date: ' . $checkinDate . '<br>' .
                                            'Check-out Date: ' . $checkoutDate . '<br><br>' .
                                            'For any inquiries, please contact us.';

                                        $mail->send();
                                    } catch (Exception $e) {
                                        echo "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
                                    }

                                    echo '<script>alert("Your room has been booked successfully. Booking Number is ' . $booknum . '")</script>';
                                    echo "<script>window.location.href ='index.php'</script>";
                                }
                            }
                        }
                        ?>


                    </div>
                </div>
            </div>


        </div>



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
    <!-- Custom Js -->
    <script src="assets/js/custom-scripts.js"></script>
</body>

</html>