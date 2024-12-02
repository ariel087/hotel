<?php
$userid = $_SESSION['userid'];
$sqlimg = "SELECT * FROM `login` WHERE `id` = '$userid'";
$queryimg = mysqli_query($conn, $sqlimg); 
$fetchimg = mysqli_fetch_array($queryimg);
?>
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
                       <?php
                       if($fetchimg['profile_pic'] == ""){
                        ?>
                       <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                        <?php
                       }
                       else{
                        ?>
                                            <img src="<?php echo $fetchimg['profile_pic']?>" width="25" height="25" alt=""> <i class="fa fa-caret-down"></i>
                        <?php
                       }
                       ?>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="usersetting.php"><i class="fa fa-user fa-fw"></i> Admin Profile</a>
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