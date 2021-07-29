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
        header('location:'.SITEURL.'admin/login.php');

    }

?>

<html>
<head>
    <meta charset="utf-8">
    <title>zaxuun admin</title>
    <link rel="stylesheet" type="text/css" href="../css/admin.css">
</head>
<body>
    <!--menu section starts-->
    <div class="menu text-center">
        <div class="wrapper">
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="manage-admin.php">Admin</a></li>
                <li><a href="manage-category.php">Category</a></li>
                <li><a href="manage-food.php">Food</a></li>
                <li><a href="manage-order.php">Order</a></li>
                <li><a href="logout.php">Log Out</a></li>
            </ul>
        </div>
        
    </div>
    <!--menu section ends-->

<div class="main-content">
    <div class="wrapper">
        <h1>Change Password</h1>
        <br><br>

        <?php 
        if(isset($_GET['id']))
        {
            $id=$_GET['id'];
        }


        ?>

        <form action="" method="POST">
            
            <table class="tbl-30">
                <tr>
                    <td>Current Password: </td>
                    <td>
                        <input type="text" name="current_password" placeholder="Current Password">
                    </td>
                </tr>

                <tr>
                    <td>New Password: </td>
                    <td>
                        <input type="text" name="new_password" placeholder="New Password">
                    </td>
                </tr>

                <tr>
                    <td>Confirm Password: </td>
                    <td>
                        <input type="text" name="confirm_password" placeholder="Confirm Password">
                    </td>
                </tr>


                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id;?>">
                        <input type="submit" name="submit" value="Change Password" class="btn-secondary">
                    </td>
                </tr>
                
            </table>
        </form>

    </div>
</div>

<?php

    if(isset($_POST['submit']))
    {

        $id=$_POST['id'];
        $current_password = $_POST['current_password'];//md5 to encrypt
        $new_password = $_POST['new_password'];//md5 to encrypt
        $confirm_password = $_POST['confirm_password'];//md5 to encrypt

        $sql = "SELECT * FROM tbl_admin WHERE id=$id AND password='$current_password'";
        $res = mysqli_query($conn, $sql);

        if ($res==true) 
        {
            $count=mysqli_num_rows($res);

            if($count==1)
            {
                if ($new_password==$confirm_password) 
                {
                    $sql2 = "UPDATE tbl_admin SET
                    password='$new_password'
                    WHERE id=$id
                    ";

                    $res2 = mysqli_query($conn, $sql2);

                    if ($res2==true) 
                    {
                    $_SESSION['change-pwd'] = " <div class='success'> Password Changed Successfully </div>";

                    header('location: manage-admin.php'); 
                    }
                    else
                    {
                    $_SESSION['change-pwd'] = " <div class='error'> Failed to change password </div>";

                    header('location: manage-admin.php');  
                    }
                }
                else
                {
                $_SESSION['pwd-not-match'] = " <div class='error'> Password did not match </div>";

                header('location: manage-admin.php'); 
                }
            }
            else
            {
                $_SESSION['user-not-found'] = " <div class='error'> User Not Found. </div>";

                header('location: manage-admin.php');

            }
        }

    }

 ?>

<!--footer sec starts-->
    <div class="footer">
        <div class="menu">
        <div class="wrapper">
        <p class="text-center">2021 All rights reserved.</p>
        </div>
    </div>
    <!--footer sec ends-->
</body>
</html>
