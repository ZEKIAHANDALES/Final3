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
        <h1>Manage Category</h1>
        <br><br>

        <?php 

                if(isset($_SESSION['add']))
                {
                 echo $_SESSION['add'];
                 unset($_SESSION['add']);
                }
                if(isset($_SESSION['remove']))
                {
                 echo $_SESSION['remove'];
                 unset($_SESSION['remove']);
                }
                if(isset($_SESSION['delete']))
                {
                 echo $_SESSION['delete'];
                 unset($_SESSION['delete']);
                }
                if(isset($_SESSION['no-category-found']))
                {
                 echo $_SESSION['no-category-found'];
                 unset($_SESSION['no-category-found']);
                }
                if(isset($_SESSION['update']))
                {
                 echo $_SESSION['update'];
                 unset($_SESSION['update']);
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

        ?>

        <br><br>

         <a href="add-category.php" class="btn-primary">Add Category </a>
                <table class="tbl-full">

                <br/><br/><br>

                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Image</th>
                    <th>Featured</th>
                    <th>Active</th>
                    <th>Actions</th>
                </tr>

                <?php 


                    $sql = "SELECT * FROM tbl_category";

                    $res = mysqli_query($conn, $sql);

                    $count = mysqli_num_rows($res);

                    $sn=1;

                    if($count>0)
                    {

                        while ($row=mysqli_fetch_assoc($res)) 
                        {
                            $id = $row['id'];
                            $title = $row['title'];
                            $image_name = $row['image_name'];
                            $featured = $row['featured'];
                            $active = $row['active'];

                            ?>

                            <tr>
                                <td><?php echo $sn++; ?> </td>
                                <td><?php echo $title; ?></td>

                                <td>

                                    <?php  

                                    if ($image_name!="") 
                                    {
                                        
                                        ?>

                                        <img src="img/category/<?php echo $image_name; ?>" width="100px">

                                        <?php

                                    }

                                    else
                                    {

                                        echo "<div class='error'>No Image Available </div>";

                                    }

                                    ?>
                                    
                                </td>

                                <td><?php echo $featured; ?></td>
                                <td><?php echo $active; ?></td>

                                <td>
                                    <a href="update-category.php?id=<?php echo $id; ?>"class="btn-secondary">Update Category</a>
                                    <a href="delete-category.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>" class="btn-danger">Delete Category</a>
                                </td>
                            </tr>

                            <?php
                        }

                    }
                    else
                    {

                        ?>
                        <tr>
                                
                            <td colspan="6"><div class="error">No Category Added</div></td>

                        </tr>
                        <?php


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
