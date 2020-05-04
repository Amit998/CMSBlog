
<?php
require_once("includes/functions.php"); 
require_once("includes/DB.php");
?>
<?php
require_once("includes/sessons.php");
?>
<?php $searchQueryParameter=$_GET["id"]; ?>

<?php
global $ConnectDB;
if(isset($_POST["submit"])){ 
    $CommentName=$_POST["CommentName"];
    $CommentEmail=$_POST["CommentEmail"];   
    $commentThought=$_POST["commentThought"];
    $approvedBy="Pending";   
    $status="Off";
 
    date_default_timezone_set("Asia/Kolkata");
    $CurrentTime=time();
    $DateTime=strftime("%B-%d-%Y %H:%M:%S",$CurrentTime);
    if((empty($CommentName)) || (empty($CommentEmail)) || (empty($commentThought))){
        $_SESSION["ErrorMessage"] ="All Field should Be Field Out";
        Redirect_to("FullPost.php?id=$searchQueryParameter");
    }elseif(strlen($CommentName)<3){
        $_SESSION["ErrorMessage"] ="Categories Should Be greater Then Three ";
        Redirect_to("FullPost.php?id=$searchQueryParameter");
    }elseif(strlen($commentThought)>499){
        $_SESSION["ErrorMessage"] ="Categories Should Be Less Then Fifty ";
        Redirect_to("FullPost.php?id=$searchQueryParameter");
    }else{
        
        $sql ="INSERT INTO comments (datetime,name,email,comment,approvedBy,status,post_id) VALUES (:dateTime,:name,:email,:comment,:ap,:st,:postIdFromUrl)";
       
        $stmt=$ConnectDB->prepare($sql);
        $stmt->bindValue(':dateTime',$DateTime);
        $stmt->bindValue(':name',$CommentName);
        $stmt->bindValue(':email',$CommentEmail);
        $stmt->bindValue(':comment',$commentThought);
        $stmt->bindValue(':ap',$approvedBy);
        $stmt->bindValue(':st',$status);
        $stmt->bindValue(':postIdFromUrl',$searchQueryParameter);
        $Execute=$stmt->execute();




        if($Execute){
            $_SESSION["SuccessMessage"] ="Comement Added Successfully ";
            Redirect_to("FullPost.php?id=$searchQueryParameter");
        }
        else{
            $_SESSION["ErrorMessage"] ="Something Went Wrong ";
            Redirect_to("FullPost.php?id=$searchQueryParameter");

        }

    }
}



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
                    <a href="#" class="nav-link">Featcures</a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <form class="form-inline d-none d-sm-block"  action="FullPost.php?id=<?php $searchQueryParameter ?>" >
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

                
            }else{         
                $PostId=$_GET["id"];
               if(!$PostId){
                $_SESSION["ErrorMessage"] ="Bad Request ";
                Redirect_to("Blog.php?id=$PostId");

               }else{
                    $sql ="SELECT * FROM posts WHERE id='$PostId'";
                    $stmt=$ConnectDB->query($sql);
                }
                       
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
                        <h5 class="card-title">Category: <?php echo htmlentities($Category);?></h5>
                        <small> Written By <?php echo htmlentities($Admin); ?> On <?php echo htmlentities($dateTime); ?></small>
                        <span style="float:right;" class="badge badge-success text-light">
                        <?php
                        $status='ON';
                        $Total=approveAccordingComment($status,$Id);
                        echo $Total,' Comments';
                        ?>
                        </span>
                        <p class="card-text">
                        <?php echo htmlentities($PostText); ?></p>
                    </div>
                </div>
                <br>

                <?php } ?>

                <!-- Comment Start -->
                <!-- Fetching Comment -->
                <span class="FieldInfo">Comment</span>
                <br>
                <br>
                <?php
                $sql="SELECT * FROM comments Where post_id='$searchQueryParameter' AND status='ON' ";
                $statment=$ConnectDB->query($sql);
                    while($DataRows=$statment->fetch()){
                        $CommentdaterTime   =$DataRows["datetime"];
                        $CommentdaterName  =    $DataRows["name"];
                        $CommenterComment   =$DataRows["comment"];
                    
                    
                    
                                           

                ?>
                <div class="">
                
                    <div class="media CommentBlock">

                        <img class="d-block img-fluid align-self-start" src="images/person1.png" alt="" style="height: 40px; width:40px;">
                        <div class="media-body " style="margin-left: 10px;">
                            <h6 class="bold"> <?php echo $CommentdaterName; ?> </h6>
                            <p class="small"><?php echo $CommentdaterTime ; ?></p>
                            <p><?php echo $CommenterComment; ?></p>
                            
                        </div>
                    </div>
                    
                </div>
                <?php } ?>

                
                

                <!-- END FETCHING COMMENT -->
                <div class="">
                        <form action="FullPost.php?id=<?php echo $searchQueryParameter; ?>" method="POST" class="">
                            <div class="card mb-3">
                                <div class="card-header">
                                    <h5 class="FieldInfo">
                                        Share Your Thoughts
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span  class="input-group-text"><i class="fa fa-user"></i></span>
                                        </div>
                                        <input type="text" name="CommentName" placeholder="Name" value="" class="form-control">
                                        </div>

                                    </div>
                                    <div class="form-group">
                                        <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span  class="input-group-text"><i class="fa fa-envelope"></i></span>
                                        </div>
                                        <input type="email" name="CommentEmail" placeholder="Email" value="" class="form-control">
                                        </div>

                                    </div>


                                    <div class="form-group">
                                        <textarea name="commentThought" id="" cols="30" rows="6" class="form-control" placeholder="Enter Your Comment"> </textarea>
                                    </div>

                                    <div class="">
                                        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                                    </div>

                                </div>
                            </div>
                        </form>
                </div>

                <!-- COMMENT END -->


                
            </div>
            <!-- Side Area -->
            <div class="offset-sm-1 col-sm-3" style="min-height: 400px;">
                        
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
<!-- comments
id
datetime
name
email
comment
approvedBy
status
post_id -->