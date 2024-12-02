<?php

session_start();

error_reporting(0);

include('includes/dbconnection.php');

if (strlen($_SESSION['hbmsuid']==0)) {

  header('location:logout.php');

  } else{

      

?>

<!DOCTYPE HTML>

<html>

<head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
    <!-- Morris Chart CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
   
  </head>




</head>

<body>

		<!--header-->

	<?php include_once('includes/header.php');?>



<!--header-->

		<!-- typography -->

	<div class="typography">

			<!-- container-wrap -->

			<div class="container">

				<div class="typography-info">

					<br><h2 class="type">View Full Transaction</h2><a href="index.php" class="btn btn-success" style="margin-left:1070px;margin-top:-60px;background-color:#a58f7c;">-BACK-</a><br>

				</div>

				

				<div class="bs-docs-example">
<br>
					<?php

                  $vid=$_GET['viewid'];



$sql="SELECT tblbooking.BookingNumber,tbluser.FullName,tbluser.MobileNumber,tbluser.Email,tblbooking.ID as tid,tblbooking.IDType,tblbooking.Gender,tblbooking.Address,tblbooking.CheckinDate,tblbooking.CheckoutDate,tblbooking.BookingDate,tblbooking.Remark,tblbooking.Status,tblbooking.UpdationDate,tblcategory.CategoryName,tblcategory.Description,tblcategory.Price,tblroom.RoomName,tblroom.MaxAdult,tblroom.MaxChild,tblroom.RoomDesc,tblroom.NoofBed,tblroom.Image,tblroom.RoomFacility 

from tblbooking 

join tblroom on tblbooking.RoomId=tblroom.ID 

join tblcategory on tblcategory.ID=tblroom.RoomType 

join tbluser on tblbooking.UserID=tbluser.ID  

where tblbooking.ID=:vid";

$query = $dbh -> prepare($sql);

$query-> bindParam(':vid', $vid, PDO::PARAM_STR);

$query->execute();

$results=$query->fetchAll(PDO::FETCH_OBJ);



$cnt=1;

if($query->rowCount() > 0)

{

foreach($results as $row)

{               ?>

                            <table border="1" class="table table-bordered table-striped table-vcenter js-dataTable-full-pagination">

                            	<tr>

  <th colspan="4" style="color: red;font-weight: bold;text-align: center;font-size: 20px"> Booking Number: <?php echo $row->BookingNumber;?></th>

</tr>

<tr>

  <th colspan="4" style="color: blue;font-weight: bold;font-size: 15px"> Booking Detail:</th>

</tr>

<tr>

    <th>Customer Name</th>

    <td><?php  echo $row->FullName;?></td>

    <th>Mobile Number</th>

    <td><?php  echo $row->MobileNumber;?></td>

  </tr>

  



  <tr>

    

   <th>Email</th>

    <td><?php  echo $row->Email;?></td>

    <th>ID Type</th>

    <td><?php  echo $row->IDType;?></td>

  </tr>

  <tr>

    

   <th>Gender</th>

    <td><?php  echo $row->Gender;?></td>

    <th>Address</th>

    <td><?php  echo $row->Address;?></td>

  </tr>

  <tr>

    <th>Check in Date</th>

    <td><?php  echo $row->CheckinDate;?></td>

    <th>Check out Date</th>

    <td><?php  echo $row->CheckoutDate;?></td>

  </tr>

  

   <tr>

    <tr>

  <th colspan="4" style="color: blue;font-weight: bold;font-size: 15px"> Room Detail:</th>

</tr>

    <th>Room Type</th>

    <td><?php  echo $row->CategoryName;?></td>

    <th>Room Price(perday)</th>

    <td>PHP<?php  echo $row->Price;?></td>

  </tr>

 

 <tr>

    

    <th>Room Name</th>

    <td><?php  echo $row->RoomName;?></td>

    <th>Room Description</th>

    <td><?php  echo $row->RoomDesc;?></td>

  </tr>

   <tr>

    

    <th>Max Adult</th>

    <td><?php  echo $row->MaxAdult;?></td>

    <th>Max Child</th>

    <td><?php  echo $row->MaxChild;?></td>

  </tr>

<tr>

    

    <th>No.of Bed</th>

    <td><?php  echo $row->NoofBed;?></td>

    <th>Room Image</th>

    <td><img src="admin/images/<?php echo $row->Image;?>" width="100" height="100" value="<?php  echo $row->Image;?>"></td>

  </tr>

   <tr>

    

    <th>Room Facility</th>

    <td><?php  echo $row->RoomFacility;?></td>

    <th>Booking Date</th>

    <td><?php  echo $row->BookingDate;?></td>

  </tr>

   <tr>

  <th colspan="4" style="color: blue;font-weight: bold;font-size: 15px"> Admin Remarks:</th>

</tr>

  <tr>

    

     <th>Order Final Status</th>



    <td> <?php  $status=$row->Status;

    

if($row->Status=="Approved")

{

  echo "Your Booking has been approved";

}



if($row->Status=="Cancelled")

{

 echo "Your Booking has been cancelled";

}





if($row->Status=="")

{

  echo "Not Response Yet";

}





     ;?></td>

     <th >Admin Remark</th>

    <?php if($row->Status==""){ ?>



                     <td><?php echo "Not Updated Yet"; ?></td>

<?php } else { ?>                  <td><?php  echo htmlentities($row->Status);?>

                  </td>

                  <?php } ?>

  </tr>

  

 

<?php $cnt=$cnt+1;}} ?>



</table> 



				</div>

			

			</div>

			<!-- //container-wrap -->

	</div>

	<!-- //typography -->



			<?php include_once('includes/getintouch.php');?>

			</div>

			<!--footer-->

				<?php include_once('includes/footer.php');?>
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
        <div id="calendar" style="width:80%; margin-inline:auto" ></div>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Bootstrap Bundle (includes Popper) -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    
    <!-- Metis Menu (if required, ensure correct usage) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/metisMenu/3.0.7/metisMenu.min.js"></script>
    
    <!-- Morris Chart JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.3.0/raphael.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
    

    <!-- FullCalendar -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>

    <!-- Inline JavaScript -->
<script>
   const bookingId = <?php echo $_GET['viewid'];?>;

// Show the modal


// Initialize the calendar once the modal is shown
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
                url: 'fetch_events.php', // Replace with the actual URL
                type: 'POST',
                data: { bookingId: bookingId }, // Pass booking ID as a parameter
                success: function (response) {
                    const events = response.flatMap(booking => [
                        {
                            title: 'Booked',
                            start: booking.BookingDate,
                            backgroundColor: '#ffc107',
                            borderColor: '#ffc107',
                            textColor: '#000000'
                        },
                        {
                            title: 'Check-in to Stay',
                            start: booking.CheckinDate,
                            end: booking.CheckoutDate,
                            backgroundColor: '#28a745',
                            borderColor: '#28a745',
                            textColor: '#ffffff',
                        },
                        {
                            title: 'Checkout Day',
                            start: booking.CheckoutDate,
                            end: booking.CheckoutDate,
                            backgroundColor: '#dc3545',
                            borderColor: '#dc3545',
                            textColor: '#ffffff',
                        },
                        {
                            title: 'Extended Date',
                            start: booking.CheckoutDate,
                            end: booking.extendDate,
                            backgroundColor: '#ffc107',
                            borderColor: '#28a745',
                            textColor: '#ffffff',
                        },
                        {
                            title: 'Extended Checkout Day',
                            start: booking.extendDate,
                            end: booking.extendDate,
                            backgroundColor: '#dc3545',
                            borderColor: '#dc3545',
                            textColor: '#ffffff',
                        }
                    ]);

                    successCallback(events);
                },
                error: function () {
                    alert('error');
                    failureCallback();
                }
            });
        },
        eventDidMount: function (info) {
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
</script>

</body>

</html><?php }  ?>

