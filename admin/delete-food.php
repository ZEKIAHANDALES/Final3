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

//auth access control
    if(!isset($_SESSION['user']))
    {

        $_SESSION['no-login-message'] = "<div class='error text-center'> Please Login to access </div>";
        header('location: login.php');

    }

        if (isset($_GET['id']) AND isset($_GET['image_name'])) 
    {
      
        //$id = $_GET['id'];
        //$image_name = $_GET['image_name'];

        //if ($image_name != "") 
        //{
            //$path = "../img/food/".$image_name;
            //$remove = unlink($path);

           // if ($remove==false) 
            //{
              //  $_SESSION['remove'] = "<div class='error'>Failed to remove Food Image </div>";  

               // header('location: manage-food.php'); 
              //  die();

          //  }
       // }

        //delete from db

        $sql = "DELETE FROM tbl_food WHERE id=$id";

        $res = mysqli_query($conn, $sql);

        if ($res==true) 
        {

            $_SESSION['delete'] = "<div class='success'>Food Deleted Successfully </div>";
            header('location: manage-food.php');
            
        }
        else
        {

            $_SESSION['delete'] = "<div class='error'>Failed to delete food </div>";
            header('location: manage-food.php');

        }

    }

    else
    {
        $_SESSION['anauth'] = "<div class='error'>Unauthorized Access </div>";
        header('location: manage-food.php');

    }
?>
