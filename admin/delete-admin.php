<?php 


    //session needed to be changed if deploying online for this is from local database
    session_start();
    
        //create cnstnts to store non repeating values
      
//Get Heroku ClearDB connection information
//Get Heroku ClearDB connection information
$cleardb_url = parse_url(getenv("CLEARDB_DATABASE_URL"));
$cleardb_server = $cleardb_url["host"];
$cleardb_username = $cleardb_url["user"];
$cleardb_password = $cleardb_url["pass"];
$cleardb_db = substr($cleardb_url["path"],1);
$active_group = 'default';
$query_builder = TRUE;
// Connect to DB
$conn = mysqli_connect($cleardb_server, $cleardb_username, $cleardb_password, $cleardb_db);
?>

<?php 

    //auth access control
    if(!isset($_SESSION['user']))
    {

        $_SESSION['no-login-message'] = "<div class='error text-center'> Please Login to access </div>";
        header('location: login.php');

    }

?>
   
   $id = $_GET['id'];

   $sql = "DELETE FROM tbl_admin WHERE id=$id";

   $res = mysqli_query($conn, $sql);

   if($res==true)
   {
        $_SESSION['delete'] = "<div class='success'>Admin Deleted Successfully.</div>";
        header('location: manage-admin.php');
   }
   else
   {
        $_SESSION['delete'] = "<div class='error'>Failed to Delete Admin</div>";
        header('location: manage-admin.php');
   }

?>
