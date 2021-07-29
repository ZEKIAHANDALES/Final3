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


    <!--main content sec starts-->
    <div class="main-content">
        <div class="menu">
        <div class="wrapper">
            <h1>Manage Admin</h1>

            <br/>


            <?php
                if(isset($_SESSION['add']))
                {
                    echo $_SESSION['add']; //disp
                    unset($_SESSION['add']); //to remove message from session
                }

                if(isset($_SESSION['delete']))
                {
                    echo $_SESSION['delete']; //disp
                    unset($_SESSION['delete']); //to
                }

                if(isset($_SESSION['update']))
                {
                    echo $_SESSION['update']; //disp
                    unset($_SESSION['update']); //to remove message from session
                }

                if(isset($_SESSION['user-not-found']))
                {
                    echo $_SESSION['user-not-found'];
                    unset($_SESSION['user-not-found']);
                }

                if(isset($_SESSION['pwd-not-match']))
                {
                    echo $_SESSION['pwd-not-match'];
                    unset($_SESSION['pwd-not-match']);
                }

                if(isset($_SESSION['change-pwd']))
                {
                    echo $_SESSION['change-pwd'];
                    unset($_SESSION['change-pwd']);
                }


            ?>

            <br><br><br>
                <!--btn add admin -->

                <a href="add-admin.php" class="btn-primary">Add Admin </a>
                <table class="tbl-full">

                <br/><br/><br>

                <tr>
                    <th>ID</th>
                    <th>Full Name</th>
                    <th>Username</th>
                    <th>Actions</th>
                </tr>


                <?php
                        //get admin
                    $sql = "SELECT * FROM tbl_admin";
                    //exec
                    $res = mysqli_query($conn, $sql);


                    if($res==TRUE)
                    {
                        //count
                        $count = mysqli_num_rows($res); //get all rows db
                        $sn=1; 

                        if($count>0)
                        {
                            while($rows=mysqli_fetch_assoc($res))
                            {
                                $id=$rows['id'];
                                $full_name=$rows['full_name'];
                                $username=$rows['username'];

                                ?>

                            <tr>
                                <td><?php echo $sn++; ?> </td>
                                <td><?php echo $full_name; ?></td>
                                <td><?php echo $username; ?></td>
                                <td>
                                    <a href="admin/update-password.php?id=<?php echo $id; ?>" class="btn-primary">Change Password</a>
                                    <a href="admin/update-admin.php?id=<?php echo $id; ?>"class="btn-secondary">Update Admin</a>
                                    <a href="admin/delete-admin.php?id=<?php echo $id; ?>"class="btn-danger">Delete Admin</a>
                                </td>
                            </tr>

                                <?php
                            }
                        }
                        else
                        {

                        }
                        //no data
                    }

                ?>


            </table>

        </div>
    </div>
 
    <!--main content sec ends-->
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
