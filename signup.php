<?php 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

//require 'C:\xampp\htdocs\hbms\PHPMailer\src\Exception.php';
//equire 'C:\xampp\htdocs\hbms\PHPMailer\src\PHPMailer.php';
//equire 'C:\xampp\htdocs\hbms\PHPMailer\src\SMTP.php';

session_start();
error_reporting(0);
include('includes/dbconnection.php');
if(isset($_POST['submit']))
  {
    $fname=$_POST['fname'];
    $mobno=$_POST['mobno'];
    $email=$_POST['email'];
    $password=md5($_POST['password']);
    $code=mt_rand(111111,999999);
    $ret="select Email from tbluser where Email=:email";
    $query= $dbh -> prepare($ret);
    $query-> bindParam(':email', $email, PDO::PARAM_STR);
    $query-> execute();
    $results = $query -> fetchAll(PDO::FETCH_OBJ);
if($query -> rowCount() == 0)
{
$sql="Insert Into tbluser(FullName,MobileNumber,Email,Password,code)Values(:fname,:mobno,:email,:password,:code)";
$query = $dbh->prepare($sql);
$query->bindParam(':fname',$fname,PDO::PARAM_STR);
$query->bindParam(':email',$email,PDO::PARAM_STR);
$query->bindParam(':mobno',$mobno,PDO::PARAM_INT);
$query->bindParam(':password',$password,PDO::PARAM_STR);
$query->bindParam(':code',$code,PDO::PARAM_STR);
$query->execute();
$lastInsertId = $dbh->lastInsertId();
if($lastInsertId)
{

echo "<div style='display: none;'>";
                    //Create an instance; passing `true` enables exceptions
                    $mail = new PHPMailer(true);

                    try {
                        //Server settings
                        $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                        $mail->isSMTP();                                            //Send using SMTP
                        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                        $mail->Username   = 'amthysthotel@gmail.com';                     //SMTP username
                        $mail->Password   = 'xcierarrpfshpyzd';                               //SMTP password
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                        //Recipients
                        $mail->setFrom('amthysthotel@gmail.com');
                        $mail->addAddress($email);

                        //Content
                        $mail->isHTML(true);                                  //Set email format to HTML
                        $mail->Subject = 'Account Activation';
                        $mail->Body    = 'To verify your email address, please use the following One Time Password (OTP):: '.$code.'';

                        $mail->send();
                       
                      
                    } catch (Exception $e) {
                        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                    }

$_SESSION["forcrea_email"] = $email;
unset($_SESSION['forrec_email']);

header("Location: verify.php");
}
else
{

echo "<script>alert('Something went wrong.Please try again');</script>";
}
}
 else
{

echo "<script>alert('Email-id already exist. Please try again');</script>";
}
}
?>
<!DOCTYPE HTML>
<html>
<head>
<link href="css/style.css" rel="stylesheet" type="text/css" media="all" />

<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/bootstrap.js"></script>
<script src="js/responsiveslides.min.js"></script>
 <script>
    $(function () {
      $("#slider").responsiveSlides({
      	auto: true,
      	nav: true,
      	speed: 500,
        namespace: "callbacks",
        pager: true,
      });
    });
  </script>

</head>
<body>
		<!--header-->
			
			<?php include_once('includes/header.php');?>

<!--header-->
		<!--about-->
		
			<br>
				<div class="contact">
				<div class="container"style="border-style: solid;">
        <center><br>
					<h1><a style="color: #a58f7c;"href="signin.php">Registration Form</a></h1>
          <a style="color: gray;"href="signin.php">already have an account? click me to sign in!</a>
					
				<div class="contact-grids">
					
						<div >
							<form method="post" >
              <br><h5>Full Name</h5>
								<input style="width:300px;"type="text" value="" name="fname" required="true" class="form-control">
								<br><h5>Mobile Number</h5>
								<input style="width:300px;"type="text" name="mobno" class="form-control" required="true" maxlength="11" pattern="[0-9]+">
								<br><h5>Email Address</h5>
								<input style="width:300px;"type="email" class="form-control" value="" name="email" required="true">
								<br><h5>Password</h5>
								<input style="width:300px;"type="password" value="" class="form-control" name="password" required="true">
								<br />
								
                <input style="background-color: #a58f7c; width:100px;font-weight:bold;" type="submit" value="REGISTER" name="submit">
						 	 </form>
						</div><br>
						<div class="clearfix"></div>
					</div>
				</div>
			</div></center><br>
	
</html>
