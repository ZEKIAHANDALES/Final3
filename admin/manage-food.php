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

<div class="main-content">
    <div class="wrapper">
        <h1>Manage Food</h1>

            <br><br>
            <br><br>
                <!--btn add admin -->

                <a href="add-food.php" class="btn-primary">Add Food</a>
                <table class="tbl-full">
                    
            <br><br>
            <br>

            <?php 

                if(isset($_SESSION['add']))
                {
                 echo $_SESSION['add'];
                 unset($_SESSION['add']);
                }
                if(isset($_SESSION['delete']))
                {
                 echo $_SESSION['delete'];
                 unset($_SESSION['delete']);
                }
                if(isset($_SESSION['remove']))
                {
                 echo $_SESSION['remove'];
                 unset($_SESSION['remove']);
                }
                if(isset($_SESSION['unauth']))
                {
                 echo $_SESSION['unauth'];
                 unset($_SESSION['unauth']);
                }
                if(isset($_SESSION['upload']))
                {
                 echo $_SESSION['upload'];
                 unset($_SESSION['upload']);
                }
                if(isset($_SESSION['failed-remove']))
                {
                 echo $_SESSION['failed-remove'];
                 unset($_SESSION['failed-remove']);
                }
                if(isset($_SESSION['update']))
                {
                 echo $_SESSION['update'];
                 unset($_SESSION['update']);
                }
            ?>

                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Price</th>
                    <th>Image</th>
                    <th>Featured</th>
                    <th>Active</th>
                    <th>Actions</th>
                </tr>
            <?php
                $sql = "SELECT * FROM tbl_food";

                    $res = mysqli_query($conn, $sql);

                    $count = mysqli_num_rows($res);

                    $sn=1;

                     if($count>0)
                    {

                        while ($row=mysqli_fetch_assoc($res)) 
                        {
                            $id = $row['id'];
                            $title = $row['title'];
                            $price = $row['price'];
                            $image_name = $row['image_name'];
                            $featured = $row['featured'];
                            $active = $row['active'];
                            ?>

                            <tr>
                                <td><?php echo $sn++; ?></td>
                                <td><?php echo $title; ?></td>
                                <td>Php <?php echo $price; ?></td>
                                <td>
                                    <?php
                                        if ($image_name=="") 
                                        {
                                            echo "<div class='error'>No Image Available </div>"; 
                                         }
                                         else
                                         {
                                            ?>
                                            <img src="img/food/<?php echo $image_name; ?>" width="100px">
                                            <?php
                                         } 
                                    ?>
                                        
                                </td>
                                <td><?php echo $featured; ?></td>
                                <td><?php echo $active; ?></td>
                                <td>
                                    <a href="update-food.php?id=<?php echo $id; ?>"class="btn-secondary">Update Food</a>
                                    <a href="delete-food.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>"class="btn-danger">Delete Food</a>
                                </td>
                            </tr>

                            <?php
                        }

                    }
                    else
                    {
                        echo "<tr><td colspan='7 class='error'> Please add food </td></tr>";
                    }

            ?> 

            </table>
    </div>
</div>

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
