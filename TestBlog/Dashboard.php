
<?php
require_once("includes/functions.php"); 
require_once("includes/DB.php");
?>
<?php
require_once("includes/sessons.php");
?>
<?php

 Confirm_Login();
 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DASHBOARD</title>
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  </head>
<body>
    <!-- NAVBAR -->
    <div class="bg-dark" style="height: 10px;"></div>
    <nav class="navbar navbar-expand-lg bg-light navbar-light">
        <div class="container nav-con">
            <a href="" class="navbar-brand">Amit.com</a>
            <Button class="navbar-toggler" data-toggle="collapse" data-target="#navbarcollapseCMA">
                <span class="navbar-toggler-icon"></span>
            </Button>
            <div class="collapse navbar-collapse" id="navbarcollapseCMA">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a href="MyProfile.php" class="nav-link"> <i class="fa fa-user text-success"></i>  My Profile</a>
                </li>
                <li class="nav-item">
                    <a href="Dashboard.php" class="nav-link">DashBoard</a>
                </li>
                <li class="nav-item">
                    <a href="Posts.php" class="nav-link">Posts</a>
                </li>
                <li class="nav-item">
                    <a href="Categories.php" class="nav-link">Categoris</a>
                </li>
                <li class="nav-item">
                    <a href="Admin.php" class="nav-link">Manage Admin</a>
                </li>
                <li class="nav-item">
                    <a href="posts.php" class="nav-link">Live Blog</a>
                </li>
                <li class="nav-item">
                    <a href="Commens.php" class="nav-link">Comments</a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav=item"><a href="LogOut.php" class="nav-link" style="color: rgb(253, 10, 10);"><i class="fa fa-times-circle"></i> LogOut</a></li>
            </ul>
            </div>
        </div>
    </nav>
    <div class="footer-background bg-dark">
            

    </div>
    <!-- HEADER -->
    <br>
    <header class="bg-dark text-white p-3">
        <div class="container">
            <div class="row">
                <div class="col-md-12 mb-2">
                    <h1> <i class="fa fa-cog color-icon"></i> Dashboard</h1>
                </div>
                <div class="col-lg-3 mb-2">
                    <a href="addNewPost.php" class="btn btn-primary btn-block"><i class="fa fa-edit"> Add New Post</i></a>
                </div>
                <div class="col-lg-3 mb-2">
                    <a href="Categories.php" class="btn btn-info btn-block"><i class="fa fa-plus-circle"> Add New Category</i></a>
                </div>
                <div class="col-lg-3 mb-2">
                    <a href="Admin.php" class="btn btn-warning btn-block"><i class="fa fa-user-plus"> Add New Admin</i></a>
                </div>
                <div class="col-lg-3 mb-2">
                    <a href="comments.php" class="btn btn-success btn-block"><i class="fa fa-check"> Approve Comment</i></a>
                </div>
            </div>
        </div>
    </header>
    <!-- HEADER -->

    <section class="container py-2 mb-4">
        <div class="row">
            <?php 
            echo ErrorMessage();
            echo SuccessMessage();
            ?>
           

                <!-- LEFT SIDE AREA -->
                <div class="col-lg-2">
                <div class="card text-center bg-dark text-white mb-3">
                        <div class="card-body">
                            <h1 class="lead">Posts</h1>
                            <h4 class="display-5"><i class="fa fa-book"></i> 
                        <?php 
                        $value='posts';
                        TotalPost($value);
                        ?>
                        
                        </h4>
                        </div>
                    </div>

                    <div class="card text-center bg-dark text-white mb-3">
                        <div class="card-body">
                            <h1 class="lead">Categories</h1>
                            <h4 class="display-5"><i class="fa fa-folder"></i> 
                            <?php 
                        $value='category';
                        TotalPost($value);
                        ?>
                        
                        </h4>
                        </div>
                    </div>

                    <div class="card text-center bg-dark text-white mb-3">
                        <div class="card-body">
                            <h1 class="lead">Admins</h1>
                            <h4 class="display-5"><i class="fa fa-user"></i> 
                            <?php 
                            $value='admins';
                            TotalPost($value);
                            ?>

                        
                        </h4>
                        </div>
                    </div>

                    <div class="card text-center bg-dark text-white mb-3">
                        <div class="card-body">
                            <h1 class="lead">Comments</h1>
                            <h4 class="display-5"><i class="fa fa-comments"></i> 
                        
                            <?php 
                            $value='comments';
                            TotalPost($value);
                            ?>
                        
                        </h4>
                        </div>
                    </div>
                    
                </div>
                <!-- RIGHT SIDE AREA -->
                <div class="col-lg-10">
                    <h1>Top Posts</h1>
                    <table class="table table-striped table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>No.</th>
                                <th>Title</th>
                                <th>Date & Time</th>
                                <th>Author</th>
                                <th>Comment</th>
                                <th>Details</th>
                            </tr>
                        </thead>
                        <?php
                        global $ConnectDB;
                        $sr =0;
                        $sql="SELECT * FROM posts ORDER BY id desc LIMIT 0,5";
                        $stmt=$ConnectDB->query($sql);
                        while($DataRows=$stmt->fetch()){
                            $Id         =$DataRows["id"];
                            $dateTime   =$DataRows["datetime"];
                            $PostTitle  =$DataRows["title"];
                            $Category   =$DataRows["category"];
                            $Admin      =$DataRows["author"];
                            $Image      =$DataRows["image"];
                            $PostText   =$DataRows["post"];
                            $sr++;       
                        

                        ?>
                        <tbody>
                            <tr>
                                <td><?php echo $sr;?></td>
                                <td><?php echo $PostTitle;?></td>
                                <td><?php echo $dateTime;?></td>
                                <td><?php echo $Admin;?></td>
                                <td>
                                    
                                    <?php
                                    $status='ON';
                                    $Total=approveAccordingComment($status,$Id);
                                     if($Total>0){
                                         ?>
                                    <span class="badge badge-success">
                                    <?php
                                        echo $Total;
                                     }
                                    ?>
                                    </span>
                                    
                                    <?php
                                     $status='OFF';
                                     $Total=approveAccordingComment($status,$Id);
                                     if($Total>0){
                                        ?>
                                   <span class="badge badge-danger">
                                   <?php
                                       echo $Total;
                                    }
                                    ?>
                                    </span>
                                </td>
                                <td><a target="_blank" href="FullPost.php?id=<?php echo $Id  ;?>"><span class="btn btn-info">Preview</span></a></td>
                            </tr>
                        </tbody>
                                <?php } ?>
                    </table>
                
                </div>
                

            
        </div>
    </section>
   


        <!-- Footer -->
        
    <div class="footer-background bg-dark">
    </div>
            <footer class="footer-blog bg-light text-dark">
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <p class="lead text-center Bold">
                                Theme By | Amit Dutta| <span id="year"></span> &copy; ---All Rights Reserved--
                            </p>
                            <p class="text-center small">
                                Lorem ipsum dolor, sit amet consectetur adipisicing elit. Architecto, at aliquam. Cum repudiandae esse deleniti tempora magni voluptatem necessitatibus, illo quibusdam, omnis accusantium debitis. Eveniet velit maxime accusamus numquam adipisci? 
                            </p>
                        </div>
                    </div>
                </div>
            </footer>
            <div class="footer-background bg-dark">
            </div>
       

        <!-- Footer -->



    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="js/main.js"></script>
</body>
</html>