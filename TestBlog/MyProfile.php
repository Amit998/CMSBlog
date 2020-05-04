
<?php
require_once("includes/functions.php"); 
require_once("includes/DB.php");
?>
<?php
require_once("includes/sessons.php");
?>
<?php
$_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
Confirm_Login();
?>
<?php
// FETCHING THE EXISTING ADMIN DATA
$AdminId=$_SESSION["User_Id"];
global $ConnectDB;
$sql="SELECT * FROM admins WHERE id='$AdminId'";
$stmt=$ConnectDB->query($sql);
while($DataRows=$stmt->fetch()){
    $ExistingName=$DataRows['aname'];
    $ExistingUserName=$DataRows['username'];
    $ExistingHeadline=$DataRows['AHeadline'];
    $ExistingBio=$DataRows['ABio'];
    $ExistingImage=$DataRows['AImage'];
}



if(isset($_POST["Submit"])){
    $AName=$_POST["name"];
    $AHeadline=$_POST["headline"];
    $ABio=$_POST['bio'];


    $Image = $_FILES['Image']['name'];
    $tmp_dir = $_FILES['Image']['tmp_name'];
    $imgSize = $_FILES['Image']['size'];
    $upload_dir = 'images/';
    $imgExt = strtolower(pathinfo($Image,PATHINFO_EXTENSION)); 
    $valid_extensions = array('jpeg', 'jpg', 'png', 'gif');
    $imageName = rand(1000,1000000).".".$imgExt;


    $Admin =$_SESSION["AdminName"];
    date_default_timezone_set("Asia/Kolkata");
    $CurrentTime=time();
    $DateTime=strftime("%B-%d-%Y %H:%M:%S",$CurrentTime);

   
    
    
    if(strlen($AHeadline)>30){
        $_SESSION["ErrorMessage"] ="Headline Should Be Less Then thirteen Charecter ";
        Redirect_to("MyProfile.php");
    }elseif(strlen($ABio)>499){
        $_SESSION["ErrorMessage"] ="Bio Should Be Less The 1000 charecter";
        Redirect_to("MyProfile.php");
    }else{
        // QUERY TO UPDATE ADMIN DATABASE
        global $ConnectDB;

        if(!empty($Image)){
            $sql ="UPDATE admins SET aname='$AName', AHeadline='$AHeadline' ,AImage='$imageName', ABio='$ABio'  WHERE id='$AdminId' ";
        }
        else{
            $sql ="UPDATE admins SET aname='$AName', AHeadline='$AHeadline'   WHERE id='$AdminId' ";
        }
        $Execute=$ConnectDB->query($sql);
        move_uploaded_file($tmp_dir,$upload_dir.$imageName);
        if($Execute){
            $_SESSION["SuccessMessage"] ="Post Details Updated Successfully ";
            Redirect_to("MyProfile.php");
        }
        else{
            $_SESSION["ErrorMessage"] ="Something Went Wrong ";
            Redirect_to("MyProfile.php");

        }

    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile</title>
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
                    <a href="MyProfile.php" class="nav-link"> <i class="fa fa-user text-success"></i>  My Profile</a>
                </li>
                <li class="nav-item">
                    <a href="Dashboard.php" class="nav-link">DashBoard </a>
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
                    <h1> <i class="fa fa-user color-icon"></i> <?php echo '@'.$ExistingUserName ;?> </h1>

                    <small class="badge badge-success"><?php echo $ExistingHeadline; ?></small>
                </div>
            </div>
        </div>
    </header>
    



    <!-- HEADER -->
    <br>
    <!-- MAIN AREA -->
    <section class="container py-2 md-4">
        <div class="row">
<!-- LEFT AREA -->
        <div class="col-md-3">
            <div class="card">
                <div class="card-header bg-dark text-light">
                    <h3><?php   echo $ExistingName; ?></h3>

                </div>
                <div class="card-body">
                    <img src="images/<?php echo $ExistingImage ;?>" class="block img-fluid mb-4" alt="">
                    <div class="text">
                        <?php echo $ExistingBio; ?>
                    </div>
                </div>
            </div>
        </div>
<!-- RIGHT AREA -->
        <div class="col-md-9" style="min-height: 400px;">
            <?php 
            echo ErrorMessage();
            echo SuccessMessage();
            
            
            ?>
            <form action="MyProfile.php" method="post" enctype="multipart/form-data">
                <div class="card bg-dark text-light md-3">
                    <div class="card-header bg-secondary text-light">
                        <h4>Edit Profile</h4>
                    </div>
                    
                    <div class="card-body bg-dark"> 
                        <div class="form-group">
                            <input class="form-control" type="text" name="name" id="Title" placeholder="Enter Your Name Here" value="">
                            
                        </div>

                        <div class="form-group">
                            <input class="form-control" type="text" name="headline" id="Title" placeholder="headline" value="">
                            <small class="text-muted">Add a professinal Headline like, 'Engineer at XYZ or 'Architecture'</small>
                            <span class="text-danger">Not More Then 30 Character</span>

                        </div>

                        <div class="form-group">
                            <textarea class="form-control" name="bio" id="Post" cols="30" rows="10" placeholder="Bio"></textarea>
                        </div>

                       
                        <div class="form-group">  
                                <div class="custom-file mb-1 mt-3">
                                <input class="form-control custom-file-input" type="file" name="Image" id="ImageSelect" placeholder="Enter The Title Here" value="">
                                <label for="imageSelect" class="custom-file-label">Select Image</label>
                                </div>
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