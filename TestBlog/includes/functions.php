<?php
require_once("includes/DB.php");
function Redirect_to($New_Location){
    // $CUR_DIR=getcwd();
    // echo $CUR_DIR.$New_Location;
    // header("Location:Categories.php");
    header("Location:".$New_Location);
    
    exit;

}

function CheckUserNameExistsOrNot($Username){
    global $ConnectDB;
    $sql= "SELECT username FROM admins WHERE username='$Username'";
    // WHERE username=':username'
    $stmt=$ConnectDB->query($sql);

    $Result=$stmt->rowCount();
    if($Result==1){
        return true;
    }else{
        return false;
    }
}

function Login_Attempts($username,$password){
    global $ConnectDB;
        $sql="SELECT * FROM admins WHERE username=:uname AND password=:pword LIMIT 1" ;

        $stmt=$ConnectDB->prepare($sql);
        $stmt->bindValue(':uname',$username);
        $stmt->bindValue(':pword',$password);
        $stmt->execute();
        $result=$stmt->rowCount();
            if($result==1){
                return $Found_Accounts=$stmt->fetch();
                
            }
            else{
                return null;
            
            }

}




function Confirm_Login(){
    if(isset($_SESSION["User_Id"])){
        return true;
    }else{
        $_SESSION["ErrorMessage"] ="Login Is Required ";
        Redirect_to("login.php");
        
    }
}

function TotalPost($value){
    global $ConnectDB;
    $sql="SELECT COUNT(*) FROM $value";
    $stmt=$ConnectDB->query($sql);
    $TotalRows=$stmt->fetch();
    $TotalPosts=array_shift($TotalRows);
    echo $TotalPosts;


}
function approveAccordingComment($status,$Id){
global $ConnectDB;
$sqlApprove="SELECT COUNT(*) FROM comments WHERE post_id='$Id' AND status='$status' ";
$stmtApprove=$ConnectDB->query($sqlApprove);
$TotalRows=$stmtApprove->fetch();
$Total=array_shift($TotalRows);
return $Total;

}

function Pagination(){
    global $ConnectDB;
    $sql="SELECT COUNT(*) FROM posts ";
    $stmt=$ConnectDB->query($sql);
    $TotalRows=$stmt->fetch();
    $Total=array_shift($TotalRows);
    $postPagination=$Total/4;
    $postPagination=ceil($postPagination);    
    return $postPagination;

}
?>