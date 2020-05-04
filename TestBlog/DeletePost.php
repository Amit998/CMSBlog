
<?php
require_once("includes/functions.php"); 
require_once("includes/DB.php");
?>
<?php
require_once("includes/sessons.php");
?>
<?php
$SearchQueryParameter=$_GET["id"];

global $ConnectDB;
$sql ="SELECT * FROM posts WHERE id='$SearchQueryParameter'";
$stmtPost=$ConnectDB->query($sql);
    while($DataRows=($stmtPost->fetch())){
        $TitleToBeDeleted  =$DataRows["title"];
        $CategoryToBDeleted   =$DataRows["category"];
        $ImageToBeDeleted      =$DataRows["image"];
        $PostTextToBeUDeleted    =$DataRows["post"];
    }
    
   
// echo $ImageToBeDeleted;
if(isset($_POST["Submit"])){
    $sql ="DELETE FROM posts WHERE id='$SearchQueryParameter' ";
    $Execute=$ConnectDB->query($sql);
        //move_uploaded_file($tmp_dir,$upload_dir.$imageName);        
        if($Execute){
            $Target_Path_To_Delete_Image="Uploads/{$ImageToBeDeleted}" ;
            unlink($Target_Path_To_Delete_Image);
            $_SESSION["SuccessMessage"] ="Post with ID ". $SearchQueryParameter." Deleted Successfully ";
            Redirect_to("posts.php");
        }
        else{
            $_SESSION["ErrorMessage"] ="Something Went Wrong ";
            Redirect_to("posts.php");

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
                    <h1> <i class="fa fa-edit color-icon"></i> Edit Post </h1>
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
            <form action="DeletePost.php?id=<?php echo $SearchQueryParameter; ?>" method="post" enctype="multipart/form-data">
                <div class="card bg-secondary text-light md-3">
                    
                    <div class="card-body bg-dark"> 
                        <div class="form-group">
                            <label for="title"><span class="field-Info">Add New Category</span></label>
                                <input disabled class="form-control" type="text" name="PostTitle" id="Title" placeholder="Enter The Title Here" value="<?php echo $TitleToBeDeleted  ;?>">
                        </div>

                        <div class="form-group">
                            <span class="FieldInfo">Existing Category:</span>
                            <span class="Text-bold"><?php echo $CategoryToBDeleted ;?></span>
                            <br>
                            

                        </div>

                        <div class="form-group">
                                <span class="FieldInfo">Existing Image:</span>
                                <img class="ml-2" src="Uploads/<?php echo$ImageToBeDeleted  ;?>" alt="" height="120px" width="120px" >
                                <br>
                        
                                
                        </div>

                        <div class="form-group">
                            <label for="Post"><span class="field-Info">Write The Post:</span></label>

                            <textarea disabled class="form-control" name="PostDescription" id="Post" cols="30" rows="10" placeholder="Write The Post Here">
                            <?php echo $PostTextToBeUDeleted  ;?>
                            </textarea>
                        </div>


                        <div class="row">
                            <div class="col-lg-6 mb-2">
                                <a href="index.php" class="btn btn-warning btn-lg btn-block"><i class="fa fa-arrow-left"></i> Back To Dashboard</a>
                            </div>
                            <div class="col-lg-6 mb-6">
                                <button type="submit" class="btn btn-danger btn-lg btn-block" name="Submit"><i class="fa fa-trash"></i> DELETE</button>
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