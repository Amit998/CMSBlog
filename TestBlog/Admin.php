
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


if(isset($_POST["Submit"])){ 
    $Username=$_POST["Username"];
    $Password=$_POST["password"];
    $ConfirmPassword=$_POST["confirmPassword"];
    $name=$_POST["name"];
    $Admin =$_SESSION["Username"];
    date_default_timezone_set("Asia/Kolkata");
    $CurrentTime=time();
    $DateTime=strftime("%B-%d-%Y %H:%M:%S",$CurrentTime);
    $AddedBy=$_SESSION["AdminName"];


    // $hash = password_hash($Password, PASSWORD_DEFAULT);
    // echo $hash;

    // if (password_verify($Password, $hash)) {
    //     echo "Let me in, I'm genuine!";
    // }
    if((empty($Username)) || (empty($Password)) || (empty($ConfirmPassword)) ){
        $_SESSION["ErrorMessage"] ="All Field should Be Field Out";
        Redirect_to("Admin.php");
    }elseif(strlen($password)>8){
        $_SESSION["ErrorMessage"] ="Admin Password Should Be greater then Eight ";
        Redirect_to("Admin.php");
    }elseif($Password !== $ConfirmPassword){
        $_SESSION["ErrorMessage"] ="Please Add Same Passoword into both confirm password and password";
        Redirect_to("Admin.php");
    }
    
    elseif(CheckUserNameExistsOrNot($Username)){
        $_SESSION["ErrorMessage"] ="User Name Already Exist u should try diffrent One";
        Redirect_to("Admin.php");
    }
    
    else{
        global $ConnectDB;
        $sql ="INSERT INTO admins(datetime,username,password,aname,addedBy) VALUES (:dateTime,:uname,:pword,:Name,:adBy)";
        // -- VALUES ('$Category','$Admin','$DateTime')";
        $stmt=$ConnectDB->prepare($sql);
        $stmt->bindValue(':dateTime',$DateTime);
        $stmt->bindValue(':uname',$Username);
        $stmt->bindValue(':pword',$Password);
        $stmt->bindValue(':Name',$name);
        $stmt->bindValue(':adBy',$AddedBy);
        $Execute=$stmt->execute();
        
        if($Execute){
            $_SESSION["SuccessMessage"] ="Admin Added Successfully ";
            Redirect_to("Admin.php");
        }
        else{
            $_SESSION["ErrorMessage"] ="Something Went Wrong ";
            Redirect_to("Admin.php");

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
                    <a href="MyProfile.php" class="nav-link"> <i class="fa fa-user text-success"></i> Manage Admin</a>
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
                <div class="col-md-12">
                    <h1> <i class="fa fa-edit color-icon"></i> ADD ADMIN</h1>
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
            <form action="Admin.php" method="post">
                <div class="card bg-secondary text-light md-3">
                    <div class="card-header">
                        <h1>Add New Admin</h1>

                    </div>
                    <div class="card-body bg-dark"> 
                        <div class="form-group">
                            <label for="username"><span class="field-Info">User Name:</span></label>
                                <input class="form-control" type="text" name="Username" id="username" placeholder="Username" value="">
                        </div>

                        <div class="form-group">
                            <label for="Name"><span class="field-Info">Your Name:</span></label>
                                <input class="form-control" type="text" name="name" id="name" placeholder="Enter Your Name" value="">
                        </div>

                        <div class="form-group">
                            <label for="password"><span class="field-Info">Password:</span></label>
                                <input class="form-control" type="password" name="password" id="password" placeholder="Password" value="">
                        </div>

                        <div class="form-group">
                            <label for="confirmPassword"><span class="field-Info">Confirm Password</span></label>
                                <input class="form-control" type="password" name="confirmPassword" id="confirmPassword" placeholder="Please Re-Enter Your Password" value="">
                        </div>

                        <div class="row">
                            <div class="col-lg-6 mb-2">
                                <a href="index.php" class="btn btn-warning btn-lg btn-block"><i class="fa fa-arrow-left"></i> Back To Dashboard</a>
                            </div>
                            <div class="col-lg-6 mb-6">
                                <button type="submit" class="btn btn-success btn-lg btn-block" name="Submit"><i class="fa fa-check"></i> Add</button>
                            </div>
                        </div>
                    </div> 
                </div>

            </form>
            <hr>
            <hr>

            <table class="table table-striped table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>No.</th>
                    <th>Name</th>
                    <th>username</th>
                    <th>Date & Time</th>
                    
                    <th>Added By</th>   
                    <th>Action</th>
                                      
                </tr>
            </thead>
        
        
           
            <?php
            global $ConnectDB;
            $sql="SELECT * FROM admins ORDER BY id desc ";
            $Execute=$ConnectDB->query($sql);
            $srNo=0;
            
            while($DataRows=$Execute->fetch()){
                $AdminId=$DataRows["id"];
                $AdminDateTime=$DataRows["datetime"];
                $AdminUsername=$DataRows["username"];

                $AdminFullName=$DataRows["aname"];
                
                $AdminAddedBy=$DataRows["addedBy"];
                $srNo++;
                // if(strlen($commentername)>10){
                //     $commentername=substr($commentername,0,10).'...';
                // }
                // if(strlen($commentDateTime)>12){
                //     $commentDateTime=substr($commentDateTime,0,12).'...';
                // }
            ?>
            <tbody>
                <tr>
                    <td><?php echo htmlentities($srNo);?></td>
                    <td><?php echo htmlentities($AdminFullName);?></td>
                    <td><?php echo htmlentities($AdminUsername);?></td>
                    <td><?php echo htmlentities($AdminDateTime);?></td>
                    <td><?php echo htmlentities($AdminAddedBy);?></td>
                    
                    <td style="width:140px;"><a href="DeleteAdmin.php?id=<?php echo $AdminId ; ?>" class="btn btn-danger btn-block">DELETE</a> </td>
                    
                    
                </tr>
            </tbody>
            
        <?php } ?>
        </table>



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