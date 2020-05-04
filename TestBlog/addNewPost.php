
<?php
require_once("includes/functions.php"); 
require_once("includes/DB.php");
?>
<?php
require_once("includes/sessons.php");
?>
<?php


if(isset($_POST["Submit"])){
    $PostTitle=$_POST["PostTitle"];
    $categoryTitle=$_POST["CategoryTitle"];


    $Image = $_FILES['Image']['name'];
    $tmp_dir = $_FILES['Image']['tmp_name'];
    $imgSize = $_FILES['Image']['size'];
    $upload_dir = 'uploads/';
    $imgExt = strtolower(pathinfo($Image,PATHINFO_EXTENSION)); 
    $valid_extensions = array('jpeg', 'jpg', 'png', 'gif');
    $imageName = rand(1000,1000000).".".$imgExt;




    $PostDescription=$_POST["PostDescription"];
    $Admin =$_SESSION["AdminName"];
    date_default_timezone_set("Asia/Kolkata");
    $CurrentTime=time();
    $DateTime=strftime("%B-%d-%Y %H:%M:%S",$CurrentTime);

   
    
    
    if(empty($PostTitle)){
        $_SESSION["ErrorMessage"] ="Title Cant Be Empty";
        Redirect_to("addNewPost.php");
    }elseif(strlen($PostTitle)<3){
        $_SESSION["ErrorMessage"] ="Title Should Be greater Then Three Charecter ";
        Redirect_to("addNewPost.php");
    }elseif(strlen($PostDescription)>999){
        $_SESSION["ErrorMessage"] ="Post Description Should Be Less The 1000 charecter";
        Redirect_to("addNewPost.php");
    }elseif(empty($Image)){
        $_SESSION["ErrorMessage"] ="Please Insert The Image";
        Redirect_to("addNewPost.php");
    }elseif(!$imgSize >= 5000000){
        $_SESSION["ErrorMessage"] ="Sorry, your file is too large.";
        Redirect_to("addNewPost.php");
    }elseif(!in_array($imgExt, $valid_extensions)){
        $_SESSION["ErrorMessage"] ="Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        Redirect_to("addNewPost.php");


    }else{
        global $ConnectDB;
        $sql ="INSERT INTO posts(datetime,title,category,author,image,post) VALUES (:dateTime,:postTitle,:categorytitle,:adminName,:imageName,:postDescription)";
        // -- VALUES ('$Category','$Admin','$DateTime')";
        $stmt=$ConnectDB->prepare($sql);
        $stmt->bindValue(':dateTime',$DateTime);
        $stmt->bindValue(':postTitle',$PostTitle);
        $stmt->bindValue(':categorytitle',$categoryTitle);
        $stmt->bindValue(':adminName',$Admin);
        $stmt->bindValue(':imageName',$imageName);
        $stmt->bindValue(':postDescription',$PostDescription);
        $Execute=$stmt->execute();
        

        move_uploaded_file($tmp_dir,$upload_dir.$imageName);
        if($Execute){
            $_SESSION["SuccessMessage"] ="Post with ID ". $ConnectDB->lastInsertId()." Successfully ";
            Redirect_to("addNewPost.php");
        }
        else{
            $_SESSION["ErrorMessage"] ="Something Went Wrong ";
            Redirect_to("addNewPost.php");

        }

    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TestBlog</title>
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link rel="stylesheet" href="">
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
                    <a href="MyProfile.php" class="nav-link"> <i class="fa fa-user text-success"></i>  My Profil</a>
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
                    <a href="ManageAdmin.php" class="nav-link">Manage Admin</a>
                </li>
                <li class="nav-item">
                    <a href="LiveBlog.php" class="nav-link">Live Blog</a>
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
                <div class="col-md-12">
                    <h1> <i class="fa fa-edit color-icon"></i>ADD NEW POSTS </h1>
                </div>
            </div>
        </div>
    </header>
    



    <!-- HEADER -->
    <br>
    <!-- MAIN AREA -->
    <section class="container py-2 md-4">
        <div class="row">
        <div class="offset-lg-1 col-lg-10" style="min-height:400px;">
            <?php 
            echo ErrorMessage();
            echo SuccessMessage();
            
            
            ?>
            <form action="addNewPost.php" method="post" enctype="multipart/form-data">
                <div class="card bg-secondary text-light md-3">
                    
                    <div class="card-body bg-dark"> 
                        <div class="form-group">
                            <label for="title"><span class="field-Info">Add New Category</span></label>
                                <input class="form-control" type="text" name="PostTitle" id="Title" placeholder="Enter The Title Here" value="">
                        </div>

                        <div class="form-group">
                            <label for="CategoryTitle"><span class="field-Info">Chose Category</span></label>
                            <select name="CategoryTitle" id="" class="form-control" id="CategoryTitle">

                                <?php 
                                global $ConnectDB;
                                $sql="SELECT * FROM category";
                                $stmt=$ConnectDB->query($sql);
                                while($DataRows=$stmt->fetch()){
                                    $Id= $DataRows["id"];
                                    $CategoryName= $DataRows["title"];
                                
                                
                                ?>



                                <option> <?php echo $CategoryName;  ?> </option>
                                <?php }  ?>
                            </select>

                        </div>

                        <div class="form-group">
                        
                                <div class="custom-file mb-1 mt-3">
                                <input class="form-control custom-file-input" type="file" name="Image" id="ImageSelect" placeholder="Enter The Title Here" value="" required="required">
                                <label for="imageSelect" class="custom-file-label">Select Image</label>
                                </div>
                        </div>

                        <div class="form-group">
                            <label for="Post"><span class="field-Info">Write The Post:</span></label>

                            <textarea class="form-control" name="PostDescription" id="Post" cols="30" rows="10" placeholder="Write The Post Here"></textarea>
                        </div>


                        <div class="row">
                            <div class="col-lg-6 mb-2">
                                <a href="index.php" class="btn btn-warning btn-lg btn-block"><i class="fa fa-arrow-left"></i> Back To Dashboard</a>
                            </div>
                            <div class="col-lg-6 mb-6">
                                <button type="submit" class="btn btn-success btn-lg btn-block" name="Submit"><i class="fa fa-check"></i> Publish</button>
                            </div>
                        </div>
                    </div> 
                </div>

            </form>
        </div>
        </div>

    </section>

    <!-- END -->

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