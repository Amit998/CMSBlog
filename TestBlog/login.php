<?php
require_once("includes/functions.php"); 
require_once("includes/DB.php");
?>
<?php
require_once("includes/sessons.php");
?>

<?php

if(isset($_SESSION["User_Id"])){
    Redirect_to("Dashboard.php");
}

if(isset($_POST["login"])){
    $username=$_POST["username"];
    $password=$_POST["password"];

   
    if(empty($username)){
        $_SESSION["ErrorMessage"] ="Usename Cant Be Empty";
        Redirect_to("login.php");
    }elseif(empty($password)){
        $_SESSION["ErrorMessage"] ="password Cant Be Empty";
        Redirect_to("login.php");
    }
    else{
        $Found_Account=Login_Attempts($username,$password);
        if($Found_Account){
            $_SESSION["User_Id"]=$Found_Account["id"];
            $_SESSION["Username"]=$Found_Account["username"];
            $_SESSION["AdminName"]=$Found_Account["aname"];
            
            
            // $_SESSION["SuccessMessage"] ="Welcome Admin ".$anana;
            if(isset($_SESSION["TrackingURL"])){
                Redirect_to($_SESSION["TrackingURL"]);
            }
            else{
            Redirect_to("Dashboard.php");
            }
        }else{
            $_SESSION["ErrorMessage"] ="incorrect Password or username";
            Redirect_to("login.php");
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
            
            </div>
        </div>
    </nav>
    <div class="footer-background bg-dark">
            

    </div>
    <!-- HEADER -->
    <br>

  
    



    <!-- HEADER -->
    <br>
        <!-- MAIN AREA END -->
        <div class="container py-10">
            <div class="row">
                <div class="offset-lg-4 col-lg-4" >
                    <div class="" style="text-align: center; height:40px" >
                        <h3><span class="badge badge-light" style="padding:10px;">ADMIN LOGIN</span></h3>
                    </div>
                        <?php 
                        echo ErrorMessage();
                        echo SuccessMessage();
                        ?>
                    
                    <form action="login.php" method="POST">
                        <div class="input-group mb-3 input-group-lg" style="margin-top: 10px;">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fa fa-user"></i></div>
                            </div>
                            <input type="text" class="form-control" placeholder="Enter The Username" name="username">
                        </div>

                        <div class="input-group mb-3 input-group-lg">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fa fa-lock"></i></div>
                            </div>
                            <input type="password" class="form-control" placeholder="Enter Password" name="password">
                        </div>

                        <button type="submit" class="btn btn-primary btn-block" name="login"> Login</button>
                        <button type="submit" class="btn btn-info btn-block" name="signin"> Sign In</button>

                    </form>


                </div>
            
            </div>
        </div>
        <br>
        <br>


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