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
        <h1>Add Admin</h1>

        <br><br>
        <?php
            if(isset($_SESSION['add']))
            {
                echo $_SESSION['add'];
                unset($_SESSION['add']);
            }
        ?>

        <form action="" method="POST">
            
            <table class="tbl-30">
                <tr>
                   <td>Full name: </td>
                   <td>
                    <input type="text" name="full_name" placeholder="Enter Name">
                </td>
                </tr>

                <tr>
                    <td>Username: </td>
                    <td>
                        <input type="text" name="username" placeholder="Enter Username">
                    </td>
                </tr>

                <tr>
                    <td>Password: </td>
                    <td>
                        <input type="password" name="password" placeholder="Enter Password">
                    </td>

                </tr>

                <tr>
                    <td colspan="2"> 
                        <input type="submit" name="submit" value="Add Admin" class="btn-secondary">

                    </td>
                </tr>

            </table>


        </form>
    </div>
</div>


    <!--footer sec starts-->
    <div class="footer">
        <div class="menu">
        <div class="wrapper">
        <p class="text-center">2021 All rights reserved.</p>
        </div>
    </div>

<?php 
    //process value form and save it to database
    //check whether the sub btn is clicked

    if(isset($_POST['submit']))
    {
        // btn clicked 
        //echo "Button Clicked";

        //get data from form

        $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = mysqli_real_escape_string($_POST['password']); //password encryption md5 if want

        //SQL query to save data to database

        $sql = "INSERT INTO tbl_admin SET
            full_name='$full_name',
            username='$username',
            password='$password'
        ";

        //exec query and save to database
        $res = mysqli_query($conn, $sql) or die(mysqli_error());

        if($res==TRUE)
        {
            //data inserted
            //session var to disp message
            $_SESSION['add'] = "Admin added successfully";
            //redirect to MAdmin
            header('admin/manage-admin.php');
        }
        else
        {
            $_SESSION['add'] = "Failed to add admin";
            //redirect to addAdmin
            header('admin/add-admin.php');
            
        }


            }
?>
    </body>
</html>
