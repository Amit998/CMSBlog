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
    $searchQueryParameter=$_GET["id"];
    $sql="DELETE FROM admins WHERE id=$searchQueryParameter  ";
    $Execute=$ConnectDB->query($sql);
    if($Execute){
        $_SESSION["SuccessMessage"] ="admin DELETED Succesfully ";
        Redirect_to("Admin.php");
    }
    else{
        $_SESSION["ErrorMessage"] ="Something Went Wrong Try Again ";
        Redirect_to("Admin.php");
    }
}

?>