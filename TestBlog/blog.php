
<?php
require_once("includes/functions.php"); 
require_once("includes/DB.php");
?>
<?php
require_once("includes/sessons.php");
?>
<?php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Page</title>
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
                    <a href="blog.php" class="nav-link">Home</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">About us</a>
                </li>
                <li class="nav-item">
                    <a href="Blog.php" class="nav-link">Blog</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">Contact Us</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">Featchers</a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <form class="form-inline d-none d-sm-block"  action="blog.php" >
                    <div class="form-group">
                        <input class="form-control mr-2" name="search" type="text"  placeholder="Search Here..">
                        <button class="btn btn-primary" name="searchBtn" type="submit">Search</button>
                        
                    </div>
                </form>
            </ul>
            </div>
        </div>
    </nav>
    <div class="footer-background bg-dark">
            

    </div>
    <!-- HEADER -->
    <div class="container">
        <div class="row">

            <!-- Main Area -->
            <div class="col-sm-8 mt-4" style="min-height: 400px;">
                <h1 >This Is My First Blog Page Using HTML CSS PHP & JAVASCRIPT</h1>
                <h1 class="lead mb-4">By Amit Dutta</h1>
                <?php 
                echo ErrorMessage();
                echo SuccessMessage();
                ?>
            <?php
            global $ConnectDB;
            if(isset($_GET["searchBtn"])){
                $Search=$_GET["search"];
                $sql ="SELECT * FROM posts WHERE datetime LIKE :search
                OR category LIKE :search
                OR title LIKE :search
                OR author LIKE :search  ";
                $stmt =$ConnectDB->prepare($sql);
                $stmt->bindValue(':search','%'.$Search.'%');
                $stmt->execute();

                
            }elseif(isset($_GET["page"])){
                $page=$_GET["page"];
                if($page==0 || $page <1){
                $showPostFrom=0;
            }else{
                $showPostFrom=($page*4)-4;
            }
                $sql="SELECT * FROM posts ORDER BY id desc LIMIT $showPostFrom,4";
                $stmt=$ConnectDB->query($sql);
            }
            
            elseif(isset($_GET["category"])){
                $Category=$_GET["category"];
                $sql="SELECT * FROM posts WHERE category='$Category' ORDER BY id desc ";
                $stmt=$ConnectDB->query($sql); 
            
            } 


            else{            
            $sql ="SELECT * FROM posts ORDER BY id desc";
            $stmt=$ConnectDB->query($sql);   
            }  
            
            
            while($DataRows=$stmt->fetch()){
                $Id         =$DataRows["id"];
                $dateTime   =$DataRows["datetime"];
                $PostTitle  =$DataRows["title"];
                $Category   =$DataRows["category"];
                $Admin      =$DataRows["author"];
                $Image      =$DataRows["image"];
                $PostText   =$DataRows["post"];
                                           
            ?>
                        
                <div class="card">
                    <img class="img-fluid card-img-top" style="max-height: 450px;" src="uploads/<?php echo htmlentities($Image);?>" alt="">
                    <div class="card-body">
                        <h4 class="card-title"><?php echo htmlentities($PostTitle);?></h4>
                        <small> Written By <a href="profile.php?user=<?php echo htmlentities($Admin); ?>"><?php echo htmlentities($Admin); ?></a> On <?php echo htmlentities($dateTime); ?></small>
                        <span style="float:right;" class="badge badge-success text-light">
                        <?php
                        $status='ON';
                        $Total=approveAccordingComment($status,$Id);
                        echo $Total,' Comments';
                        ?>
                    
                    
                        </span>
                        <p class="card-text">
                        <?php
                        if(strlen($PostText)>120){
                            $PostText =substr($PostText,0,120).'...';
                        }
                        ?>
                        <?php echo htmlentities($PostText); ?></p>
                        <a href="FullPost.php?id=<?php echo $Id ?>" style="float: right;">
                            <span class="btn btn-info">Read More >> </span>
                        </a>
                    </div>
                </div>
                <hr>
                <?php } ?>
                <!-- PAGINATION -->
                <nav>
                    <ul class="pagination pagination-lg">
                        <!-- BACKWARD BUTTON -->
                    <?php
                        if(isset($page)){
                            if($page>1){
                            ?>
                            <li class="page-item">
                                <a href="blog.php?page=<?php echo $page-1 ;?>" class="page-link ">&laquo;</a>
                            </li>
                            <?php
                        } }
                        ?>
                        <!-- BACKWARD BUTTON ENDING -->
                        
                        <!-- <li class="page-item">
                            <a href="blog.php?page=1" class="page-link ">1</a>
                        </li>
                        <li class="page-item">
                            <a href="blog.php?page=2" class="page-link ">2</a>
                        </li> -->
                        <?php
                        
                        $postPagination=Pagination();
                        for($i=1;$i<=$postPagination;$i++){
                            if(isset($page)){
                                if($i==$page){
                        ?>
                        <li class="page-item active">
                            <a href="blog.php?page=<?php echo $i ;?>" class="page-link "><?php echo $i; ?></a>
                        </li>
                        <?php
                        }else{
                            ?>
                            <li class="page-item">
                                <a href="blog.php?page=<?php echo $i ;?>" class="page-link "><?php echo $i; ?></a>
                            </li>
                        <?php
                        }
                        ?>
                        <?php
                        } }
                        ?>
                        <!-- FORWARD BUTTON -->
                        <?php
                        if(isset($page)  && (!empty($page)) ){
                            if($page+1<=$postPagination){

                            
                            ?>
                            <li class="page-item">
                                <a href="blog.php?page=<?php echo $page+1 ;?>" class="page-link ">&raquo;</a>
                            </li>
                            <?php
                        } }
                        ?>
                        <!-- BACKWARD BUTTON -->
                    </ul>
                </nav>


                <!-- END PAGINATION -->
            </div>
            <!-- SIDE AREA -->
            <div class=" col-sm-4" style="min-height: 400px;">
            <div class="card mt-4">
                <div class="card-body">
                    <img src="images/unnamed.jpg" alt="" class="d-block img-fluid mb-3">
                    <div class="">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Corporis molestias dolores, eaque quos reprehenderit provident necessitatibus! Voluptas natus aut sapiente excepturi asperiores temporibus facilis pariatur? Quasi alias dolores harum ducimus.
                    </div>  
                </div>
            </div>
            <div class="card">
                <div class="card-header bg-dark text-light">
                    <h2 class="lead">Sign Up!</h2>
                </div>
                <div class="card-body">
                    <button class="btn btn-success btn-block text-center text-white" name="button" type="submit">Join The Forum</button>
                    <button class="btn btn-info btn-block text-center text-white mb-4" name="button" type="submit">Login</button>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name=" " placeholder="ENTER YOUR EMAIL" value="">
                        <div class="input-group-append">
                            <button type="button" class="btn btn-primary btn-block text-center text-white" name="button">Subscribe</button>
                        </div> 
                    </div>
                </div>
            </div>

            <br>
            <div class="card">
                <div class="card-header bg-primary text-light mb-4">
                
                    <h2 class="lead">Category</h2>
                    </div>
                    <?php
                    global $ConnectDB;
                    $sql="SELECT * FROM category ORDER BY id desc";
                    $stmtCategory=$ConnectDB->query($sql);
                    while($DataRows=$stmtCategory->fetch()){
                        $IdOfCategory       =$DataRows["id"];
                        $CategoryName       =$DataRows["title"];
                    ?>
                    <a href="blog.php?category=<?php echo $CategoryName; ?>"><span class="heading" style="margin-left: 20px; margin-top:10px; text-decoration: none;"><?php echo $CategoryName; ?></span></a><br>
                    <?php
                    } ?>

                
            </div>

            <br>
            <div class="card">
                <div class="card-header bg-info">
                    <h2 class="lead">Recent Posts</h2>
                </div>
                <div class="card-body">
                    <?php 
                    global $ConnectDB;
                    $sql="SELECT * FROM posts ORDER BY id desc LIMIT 0,5";
                    $stmt=$ConnectDB->query($sql);
                    while($DataRows=$stmt->fetch()){
                        $IDPOST=$DataRows["id"];
                        $POSTNAME=$DataRows["title"];
                        $POSTTIME=$DataRows["datetime"];
                        $POSTIMAGE=$DataRows["image"];
                    ?>
                    <div class="media mb-4">
                        <img src="Uploads/<?php echo htmlentities($POSTIMAGE) ;?>" class="d-block img-fluid align-self-start" alt="" style="width: 90px; height:50px;">
                        <div class="media-body ml-2">
                            <a href="FullPost.php?id=<?php echo htmlentities($IDPOST) ;?>" target="_blank"><span class="lead" style="font-size: 12px; text-decoration:none; display:inline-block;"><?php echo $POSTNAME ;?></span></a>
                            <p class="small"><?php echo htmlentities($POSTTIME);?></p>
                        </div>
                    </div>

                    <?php } ?>
                </div>
            </div>



            </div>
            <!-- SIDE AREA -->
        </div>
        


    </div>



    <!-- HEADER -->
    <br>


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