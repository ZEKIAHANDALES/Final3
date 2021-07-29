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
        <h1>Update Category</h1>

        <br><br>

        <?php 

            if (isset($_GET['id'])) 
            {

                $id = $_GET['id'];

                $sql = "SELECT * FROM tbl_category WHERE id=$id";
                $res = mysqli_query($conn, $sql);

                $count = mysqli_num_rows($res);

                if($count>0)
                {

                    $row = mysqli_fetch_assoc($res);
                    $title = $row['title'];
                    $current_image = $row['image_name'];
                    $featured = $row['featured'];
                    $active = $row['active'];
                }
                else
                {

                    $_SESSION['no-category-found'] = "<div class='error'>Category not found </div>";
                    header('location: manage-category.php');

                }
                
            }
            else
            {

                header('location: manage-category.php');

            }

        ?>

    <form action="" method="POST" enctype="multipart/form-data">
        <table class="tbl-30">
            <tr>
                <td>Title: </td>
                <td>
                    <input type="text" name="title" value="<?php echo $title; ?>">

                </td>
            </tr>
            
            <tr>
                <td>Current Image: </td>
                <td>
                    <?php 
                        if ($current_image != "") 
                        {
                           
                            ?>
                            <img src=" img/category<?php echo $current_image; ?>"width="150px">
                            <?php

                        }
                        else
                        {

                            echo "<div class='error'>Image Not Added </div>";

                        }

                    ?>
                </td>
            </tr>

            <tr>
                <td>New Image: </td>
                <td>
                    <input type="file" name="image">
                </td>
            </tr>

            <tr>
                
                <td>Featured: </td>
                <td>
                    <input <?php if($featured=="Yes"){echo "checked";} ?> type="radio" name="featured" value="Yes"> Yes
                    <input  <?php if($featured=="No"){echo "checked";} ?> type="radio" name="featured" value="No"> No
                </td>
            </tr>

            <tr>
                <td>Active: </td>
                <td>
                    <input <?php if($active=="Yes"){echo "checked";} ?> type="radio" name="active" value="Yes"> Yes
                    <input <?php if($active=="No"){echo "checked";} ?> type="radio" name="active" value="No"> No
                </td>
            </tr>

            <tr>
                <td>
                    <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <input type="submit" name="submit" value="Update Category" class="btn-secondary">
                </td>
            </tr>

        </table>
     </form>

     <?php 

        if (isset($_POST['submit'])) 
        {

            $id = $_POST['id'];
            $title = mysqli_real_escape_string($conn, $_POST['title']);
            $current_image = $_POST['current_image'];
            $featured = $_POST['featured'];
            $active = $_POST['active'];

            if (isset($_FILES['image']['name'])) 
            {
                $image_name = $_FILES['image']['name'];
                if ($image_name != "") 
                {
                     //auto rename the image if parehas ng name

                $ext = end(explode('.', $image_name));

                //eto papalit ng pangalan

                $image_name = "zax_food_".rand(000, 999).'.'.$ext;

                $source_path = $_FILES['image']['tmp_name'];
                $destination_path = "../img/category".$image_name;

                $upload = move_uploaded_file($source_path, $destination_path);

                if($upload==false)
                {
                    $_SESSION['upload'] = "<div class='error'>Failed to upload image</div>";
                    header('location: manage-category.php');

                    die();
                }
                    if($current_image != "")
                    {
                     $remove_path = "../img/category".$current_image;
                         $remove = unlink($remove_path);

                         if ($remove==false) 
                    {
                        $_SESSION['failed-remove'] = "<div class='error'> Failed to remove currrent image </div>";
                        header('location: manage-category.php');
                        die();
                    }

                    }

                }
                else
                {
                    $image_name = $current_image;
                }
            }
            else
            {
                $image_name = $current_image;
            }

            $sql2 = "UPDATE tbl_category SET 
                title = '$title',
                image_name = '$image_name',
                featured = '$featured',
                active = '$active'
                WHERE id=$id
            ";

            $res2 = mysqli_query($conn, $sql2);

            if ($res2==true) 
            {
                $_SESSION['update'] = "<div class='sucess'>Category Updated Successfully </div>";
                header('location: manage-category.php');
            }
            else
            {
                $_SESSION['update'] = "<div class='error'>Faield to Update Category </div>";
                header('location: manage-category.php');
            }

        }

     ?>

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
