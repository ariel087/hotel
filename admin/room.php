<?php  
session_start();  
if(!isset($_SESSION["user"]))
{
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
        <!-- Custom Styles-->
    <link href="assets/css/custom-styles.css" rel="stylesheet" />
     <!-- Google Fonts-->
   <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
</head>
<body>
    <div id="wrapper">
        <nav class="navbar navbar-default top-navbar" role="navigation">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="home.php">MAIN MENU </a>
            </div>

            <ul class="nav navbar-top-links navbar-right">
			
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                        <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="usersetting.php"><i class="fa fa-user fa-fw"></i> User Profile</a>
                        </li>
                        <li><a href="settings.php"><i class="fa fa-gear fa-fw"></i> Settings</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="logout.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
					
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
        </nav>
        <!--/. NAV TOP  -->
        <nav class="navbar-default navbar-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="main-menu">

                    <li>
                        <a  href="settings.php"><i class="fa fa-dashboard"></i>Room Status</a>
                    </li>
                    <li>
                        <a  href="roomuser.php"><i class="fa fa-plus-circle"></i>Users</a>
                    </li>
					<li>
                        <a  class="active-menu" href="room.php"><i class="fa fa-plus-circle"></i>Add Room</a>
                    </li>
                    <li>
                        <a  href="roomdel.php"><i class="fa fa-desktop"></i> Delete Room</a>
                    </li>
					

                    
            </div>

        </nav>
        <!-- /. NAV SIDE  -->
       
        
       
        <div id="page-wrapper" >
            <div id="page-inner">
                
			 <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-header">
                           NEW ROOM <small></small>
                        </h1>
                    </div>
                </div> 
                 
                                 
            <div class="row">
                
                <div class="col-md-5 col-sm-5">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            ADD NEW ROOM
                        </div>
                        <div class="panel-body">
                        <form method="post">
                                <div class="form-group">
                                    <label>Category Name</label>
                                    <input type="text" name="category_name" class="form-control" placeholder="Enter Category Name" required>
                                </div>
                                <div class="form-group">
                                    <label>Category Description</label>
                                    <textarea name="category_desc" class="form-control" placeholder="Enter Category Description" required></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Category Price</label>
                                    <input type="number" name="category_price" class="form-control" placeholder="Enter Category Price" required>
                                </div>
                                <input type="submit" name="add_category" value="Add Category" class="btn btn-primary">
                            </form><br>
						<form name="form" method="post" enctype="multipart/form-data">
                            
    <div class="form-group">
        <label>Type Of Room *</label>
        <select name="troom" class="form-control" required>
                                        <option value="" selected disabled>Select Category</option>
                                        <?php
                                        include('db.php');
                                        $categoryQuery = "SELECT * FROM tblcategory";
                                        $categoryResult = mysqli_query($conn, $categoryQuery);

                                        while ($category = mysqli_fetch_assoc($categoryResult)) {
                                            $cat_number = 0; 
                                            if($category['CategoryName'] === "Deluxe Room"){
                                            $cat_number = 12;
                                            }
                                            if($category['CategoryName'] === "Luxury Room"){
                                            $cat_number = 13;
                                            }
                                            if($category['CategoryName'] === "Standard Room"){
                                            $cat_number = 14;
                                            }
                                            echo "<option value='$cat_number'>{$category['CategoryName']}</option>";
                                        }
                                        ?>
                                    </select>
    </div>

    <div class="form-group">
        <label>Bedding Type</label>
        <input type="text" name="bed" class="form-control" placeholder="Enter Bedding Type" required>
    </div>

    <div class="form-group">
        <label>Room Description</label>
        <textarea name="room_desc" class="form-control" placeholder="Enter Room Description" required></textarea>
    </div>

    <div class="form-group">
        <label>Number of Beds</label>
        <input type="number" name="no_of_beds" class="form-control" placeholder="Enter Number of Beds" required>
    </div>

    <div class="form-group">
        <label>Room Image</label>
        <input type="file" name="room_image" class="form-control" accept="image/*" required>
    </div>

    <input type="submit" name="add" value="Add New" class="btn btn-primary">
</form>

<?php
include('db.php');

if (isset($_POST['add'])) {
    $roomType = $_POST['troom'];
    $roomName = $_POST['bed'];
    $roomDesc = $_POST['room_desc'];
    $noOfBeds = $_POST['no_of_beds'];
    $roomFacility = 'Avail';

    // Handling Room Image
    $imageFileName = $_FILES['room_image']['name'];
$imageTempName = $_FILES['room_image']['tmp_name'];
$imageDestination =  $imageFileName;

// Check if the "uploads" directory exists, if not, create it
if (!is_dir("images/")) {
    mkdir("images/");
}

move_uploaded_file($imageTempName, $imageDestination);


    move_uploaded_file($imageTempName, $imageDestination);

    // Check if the room already exists
    $checkQuery = "SELECT * FROM tblroom WHERE RoomType = '$roomType' AND RoomName = '$roomName'";
    $checkResult = mysqli_query($conn, $checkQuery);
    $checkData = mysqli_fetch_array($checkResult, MYSQLI_NUM);

    if (!empty($checkData) && $checkData[0] > 0) {
        echo "<script type='text/javascript'> alert('Room Already Exists')</script>";
    } else {
        $insertQuery = "INSERT INTO `tblroom`(`RoomType`, `RoomName`, `RoomDesc`, `NoofBed`, `Image`, `RoomFacility`)
                        VALUES ('$roomType', '$roomName', '$roomDesc', '$noOfBeds', '$imageDestination', '$roomFacility')";
        if (mysqli_query($conn, $insertQuery)) {
            echo '<script>alert("New Room Added") </script>';
        } else {
            echo '<script>alert("Sorry! Check The System") </script>';
        }
    }
}
if (isset($_POST['add_category'])) {
    $categoryName = $_POST['category_name'];
    $categoryDesc = $_POST['category_desc'];
    $categoryPrice = $_POST['category_price'];
    

    $insertCategoryQuery = "INSERT INTO `tblcategory` (`CategoryName`, `Description`, `Price`) VALUES ('$categoryName', '$categoryDesc', '$categoryPrice')";
    
    if (mysqli_query($conn, $insertCategoryQuery)) {
        echo '<script>alert("New Category Added")</script>';
    } else {
        echo '<script>alert("Sorry! Check The System")</script>';
    }
}
?>

                        </div>
                        
                    </div>
                </div>
                
                  
                <div class="row">
    <div class="col-md-6 col-sm-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                ROOMS INFORMATION
            </div>
            <div class="panel-body">
                <!-- Advanced Tables -->
                <div class="panel panel-default">
                    <?php
                    $sql = "SELECT r.*, c.CategoryName
                            FROM tblroom r
                            LEFT JOIN tblcategory c ON r.RoomType = c.CategoryName ORDER BY r.RoomType ASC";
                    $re = mysqli_query($conn, $sql);
                    ?>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>Room ID</th>
                                        <th>Room Type</th>
                                        <th>Bedding</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    while ($row = mysqli_fetch_array($re)) {
                                        $id = $row['ID'];
                                        if ($id % 2 == 0) {
                                            echo "<tr class='odd gradeX'>
                                                <td>" . $row['ID'] . "</td>
                                                <td>" . $row['RoomType'] . "</td>
                                                <th>" . $row['RoomName'] . "</th>
                                            </tr>";
                                        } else {
                                            echo "<tr class='even gradeC'>
                                                <td>" . $row['ID'] . "</td>
                                                <td>" . $row['RoomType'] . "</td>
                                                <th>" . $row['RoomName'] . "</th>
                                            </tr>";
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
                
                <!-- End Advanced Tables -->

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
