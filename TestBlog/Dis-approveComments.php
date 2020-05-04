<?php
require_once("includes/functions.php"); 
require_once("includes/DB.php");
?>
<?php
require_once("includes/sessons.php");
?>

<?php
global $ConnectDB;
if(isset($_GET["id"])){
    $Admin=$_SESSION["AdminName"];
    $searchQueryParameter=$_GET["id"];
    $sql="UPDATE comments SET status='OFF' , approvedBy='pending' WHERE id=$searchQueryParameter  ";
    $Execute=$ConnectDB->query($sql);
    if($Execute){
        $_SESSION["SuccessMessage"] ="Comment DisApproved Succesfully ";
        Redirect_to("comments.php");
    }
    else{
        $_SESSION["ErrorMessage"] ="Something Went Wrong Try Again ";
        Redirect_to("comments.php");
    }
}

?>