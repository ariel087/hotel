<?php

session_start();

error_reporting(0);



include('includes/dbconnection.php');

?>

<!DOCTYPE HTML>

<html>

<head>

<link href="css/style.css" rel="stylesheet" type="text/css" media="all" />

<link rel="stylesheet" href="css/lightbox.css">



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

		<!--rooms-->

			

					<div class="room-section">

						<div class="container">
							<br>
						<h1>Choose your Desired Room</h1>
			<br>
							<div class="room-grids">

								<?php

								$cid=intval($_GET['catid']);

$sql="SELECT tblroom.*,tblroom.id as rmid , tblcategory.Price,tblcategory.ID,tblcategory.CategoryName from tblroom 

join tblcategory on tblroom.RoomType=tblcategory.ID 

where tblroom.RoomType=:cid ORDER BY tblroom.id DESC";

$query = $dbh -> prepare($sql);

$query-> bindParam(':cid', $cid, PDO::PARAM_STR);

$query->execute();

$results=$query->fetchAll(PDO::FETCH_OBJ);



$cnt=1;

if($query->rowCount() > 0)

{

foreach($results as $row)

{               ?>

							<div class="room1">

								<div class="col-md-5 room-grid" style="padding-bottom: 50px">

								<a href="#" class="mask"style="color:#a58f7c;">
								<h1> <?php  echo htmlentities($row->RoomName);?> </h1>
									<img src="admin/images/<?php echo $row->Image;?>" class=" mask img-responsive zoom-img" alt="" /></a>

									

								</div>

								<div class="col-md-7 room-grid1">

									<br><br>
									<h2>Room Description</h2>
									<p><?php  echo htmlentities($row->RoomDesc);?></p>
									

									<p><b>No of Beds: </b><?php  echo htmlentities($row->NoofBed);?></p>

									

									<p><b>Price: PHP</b> <?php  echo htmlentities($row->Price);?></p>
							
									<button style="background-color: #a58f7c; width:140px;" ><a style="color:black;"href="book-room.php?rmid=<?php echo $row->rmid;?>">Book Now</a></button>
								<hr>
								</div>



								<div class="clearfix"></div>

							</div><?php $cnt=$cnt+1;}} ?>

						

					

						<div class="clearfix"></div>

						</div>

					</div>

				</div>

				<!--rooms-->

				<?php include_once('includes/getintouch.php');?>

			</div>

			<!--footer-->

				<?php include_once('includes/footer.php');?>

</body>

</html>

