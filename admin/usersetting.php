<?php  
include ('db.php');
session_start();  




if(!isset($_SESSION["user"]))
{
 header("location:index.php");
}

ob_start();
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
                        <a class="active-menu" href="settings.php"><i class="fa fa-dashboard"></i>User Dashboard</a>
                    </li>
					
					

                    
            </div>

        </nav>
        <!-- /. NAV SIDE  -->
       
        <div id="page-wrapper" >
            <div id="page-inner">
			 <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-header">
                           ADMINISTRATOR<small> accounts </small>
                        </h1>
                    </div>
                </div> 
                 
                                 
            <?php

						$sql = "SELECT * FROM `login`";
						$re = mysqli_query($conn,$sql)
				?>
                
            <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>User ID</th>
											<th>User name</th>
                                            <th>Password</th>
                                            <th>Profile_Pic</th>
											<th>Update</th>
											<th>Remove</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
									<?php
										while($row = mysqli_fetch_array($re))
										{
										
											$id = $row['id'];
											$us = $row['usname'];
                                            $pc = $row['profile_pic'];
											$ps = $row['pass'];
											if($id % 2 ==0 )
											{
												echo"<tr class='gradeC'>
													<td>".$id."</td>
													<td>".$us."</td>
                                                    <td><img src='../images/avatar/<?php echo $pc; ?>' alt='Profile Picture' width='50'></td>

													<td>".$ps."</td>
													
													<td><button class='btn btn-primary btn' data-toggle='modal' data-target='#myModal'>
															 Update 
													</button></td>
													<td><a href=usersettingdel.php?eid=".$id ." <button class='btn btn-danger'> <i class='fa fa-edit' ></i> Delete</button></td>
												</tr>";
											}
											else
											{
												echo"<tr class='gradeU'>
													<td>".$id."</td>
													<td>".$us."</td>
													<td>". $bulletPassword = str_repeat('•', strlen($ps));
    echo htmlspecialchars($bulletPassword)."</td>
                                                    <td><img src='" . $pc . "' alt='-- ' width='50'></td>
													
													<td><button class='btn btn-primary btn' data-toggle='modal' data-target='#myModal'>
                              Update 
                            </button></td>
													<td><a href=usersettingdel.php?eid=".$id ." <button class='btn btn-danger'> <i class='fa fa-edit' ></i> Delete</button></td>
												</tr>";
											
											}
										
										}
										
									?>
                                        
                                    </tbody>
                                </table>
                            </div>
                            
                        </div>
                    </div>
                    <!--End Advanced Tables -->
					<div class="panel-body">
                            <button class="btn btn-primary btn" data-toggle="modal" data-target="#myModal1">
															Add New Admin
													</button>
                            <div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="myModalLabel">Add the User name and Password</h4>
                                        </div>
										<form method="post">
                                        <div class="modal-body">
                                            <div class="form-group">
                                            <label>Add new User name</label>
                                            <input name="newus"  class="form-control" placeholder="Enter User name">
											</div>
										</div>
										<div class="modal-body">
                                            <div class="form-group">
                                            <label>New Password</label>
                                            <input name="newps"  class="form-control" placeholder="Enter Password">
											</div>
                                        </div>
										
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
											
                                           <input type="submit" name="in" value="Add" class="btn btn-primary">
										  </form>
										   
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
						<?php
						if(isset($_POST['in']))
						{
							$newus = $_POST['newus'];
							$newps = $_POST['newps'];
							
							$newsql ="Insert into login (usname,pass) values ('$newus','$newps')";
							if(mysqli_query($conn,$newsql))
							{
							echo' <script language="javascript" type="text/javascript"> alert("User name and password Added") </script>';
							
						
							}
						header("Location: usersetting.php");
						}
						?>
						
                        <div class="panel-body">
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Change User name, Password, and Profile Picture</h4>
                </div>
                <form method="post" enctype="multipart/form-data"> <!-- Added enctype for file upload -->
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Change User name</label>
                            <input name="usname" value="<?php echo $us; ?>" class="form-control" placeholder="Enter User name">
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Change Password</label>
                            <input type="password" name="pasd" value="<?php echo $ps; ?>" class="form-control" placeholder="Enter Password">
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Change Profile Picture</label>
                            <input type="file" name="profile_pic">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <input type="submit" name="up" value="Update" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

               
                <!-- /. ROW  -->
                <?php
if (isset($_POST['up'])) {
    $usname = $_POST['usname'];
    $passwr = $_POST['pasd'];

    // Handle file upload
    if ($_FILES['profile_pic']['name']) {
        $target_dir = "../images/avatar/"; // Path to save uploaded profile picture
        $target_file = $target_dir . basename($_FILES["profile_pic"]["name"]);
        
        // Move the uploaded file to the target directory
        if (move_uploaded_file($_FILES["profile_pic"]["tmp_name"], $target_file)) {
            $profilePicQuery = "`profile_pic` = '$target_file',";
        } else {
            echo '<script language="javascript" type="text/javascript"> alert("Error uploading profile picture") </script>';
            $profilePicQuery = ""; // Skip updating profile picture if upload fails
        }
    } else {
        $profilePicQuery = ""; // No new profile picture uploaded
    }
    
    // Escape input values to prevent SQL injection
    $usname = mysqli_real_escape_string($conn, $usname);
    $passwr = mysqli_real_escape_string($conn, $passwr);
    $id = mysqli_real_escape_string($conn, $id);
    
    // Construct the SQL query dynamically
    $upsql = "UPDATE `login` 
              SET `usname` = '$usname', 
                  `pass` = '$passwr', 
                  $profilePicQuery
                  `id` = '$id'
              WHERE `id` = '$id'";
    
    if (mysqli_query($conn, $upsql)) {
        echo '<script language="javascript" type="text/javascript"> alert("User name, password, and profile picture updated") </script>';
        header("Location: usersetting.php");
        exit;
    } else {
        echo '<script language="javascript" type="text/javascript"> alert("Error updating user details: ' . mysqli_error($conn) . '") </script>';
    }
}    
?>

                                
                  
            
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
