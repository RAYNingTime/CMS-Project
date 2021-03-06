 <?php
        
        if(isset($_SESSION['username'])) {
            $username = $_SESSION['username'];
            
            $query = "SELECT * FROM users WHERE username = '{$username}'";
            $select_user_profile = mysqli_query($connect, $query);
        
            if(!$select_user_profile)
                die("QUERY FAILED " . mysqli_error($connect));
        
            while ($row = mysqli_fetch_array($select_user_profile)){
                $user_id = $row['user_id'];
                $username = $row['username']; 
                $user_password = $row['user_password']; 
                $user_firstname = $row['user_firstname'];
                $user_lastname = $row['user_lastname']; 
                $user_email = $row['user_email']; 
                $user_image = $row['user_image']; 
                $user_role = $row['user_role']; 
            }
        }
        
        ?>
        
        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">CMS Admin</a>
            </div>
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">

            <!-- <li><a href="">Users Online: <?php //echo users_online();?></a></li> -->

            <li><a href="">Users Online:  <span class="usersonline"></span></a></li>


                <li><a href="../index.php">HOME SITE</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> 
                    
                    <?php echo $user_firstname . "  " . $user_lastname; ?>
                    
                    <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="profile.php"><i class="fa fa-fw fa-user"></i> Profile</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="../includes/logout.php"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                        </li>
                    </ul>
                </li>
            </ul>            
				<!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <li>
                        <a href="index.php"><i class="fa fa-fw fa-dashboard"></i> My data</a>
                    </li>

                    <?php
                    if(is_admin()):
                    ?>

                    <li>
                        <a href="dashboard.php"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
                    </li>

                    <?php
                    endif
                    ?>

                    <li>
                       <a href="javascript:;" data-toggle="collapse" data-target="#posts_dropdown"><i class="fa fa-fw fa-arrows-v"></i> Posts <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="posts_dropdown" class="collapse">
                            <li>
                                <a href="./posts.php"> View All Posts</a>
                            </li>
                            <li>
                                <a href="./posts.php?source=add_post"> Add Posts</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="./categories.php"><i class="fa fa-fw fa-wrench"></i> Categories</a>
                    </li>
                    <li>
                        <a href="./comments.php"><i class="fa fa-fw fa-file"></i> Comments </a>
                    </li>
						  <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#demo"><i class="fa fa-fw fa-arrows-v"></i> Users <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="demo" class="collapse">
                            <li>
                                <a href="./users.php">View all users</a>
                            </li>
                            <li>
                                <a href="./users.php?source=add_user">Add user</a>
                            </li>
                        </ul>
                    </li>
						  <li>
                        <a href="profile.php"><i class="fa fa-fw fa-dashboard"></i> Profile </a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>
