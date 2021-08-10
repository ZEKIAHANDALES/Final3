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
        <h1>Add Food</h1>
        <br><br>

            <?php 

                if(isset($_SESSION['upload']))
                {
                 echo $_SESSION['upload'];
                 unset($_SESSION['upload']);
                }
            ?>

        <form action="" method="POST" enctype="multipart/form-data">
            
            <table class="tbl-30">
                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="title" placeholder="Enter Title of food">
                    </td>
                </tr>

                <tr>
                    <td>Description: </td>
                    <td>
                        <textarea name="description" cols="30" rows="5" placeholder="Description of Food"></textarea>
                    </td>
                </tr>

                <tr>
                    <td>Price: </td>
                    <td>
                        <input type="number" name="price">
                    </td>
                </tr>

                <tr>
                    <td>Select Image: </td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>

                <tr>
                    <td>Category: </td>
                    <td>
                        <select name="category">

                            <?php 

                                $sql = "SELECT * FROM tbl_category WHERE active='Yes'";

                                $res = mysqli_query($conn, $sql);
                                $count = mysqli_num_rows($res);

                                if($count>0)
                                {
                                    while($row=mysqli_fetch_assoc($res))
                                    {
                                        $id = $row['id'];
                                        $title = $row['title'];

                                        ?>
                                            <option value="<?php echo $id; ?>"><?php echo $title; ?></option>

                                        <?php 
                                    }

                                }
                                else
                                {

                            ?>
                                    
                                    <option value="0">No Category Found</option>
                                    <?php
                                }

                            ?>

                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Featured: </td>
                    <td>
                        <input type="radio" name="featured" value="Yes"> Yes
                        <input type="radio" name="featured" value="No"> No
                    </td>
                </tr>

                <tr>
                    <td>Active: </td>
                    <td>
                        <input type="radio" name="active" value="Yes"> Yes
                        <input type="radio" name="active" value="No"> No
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Food" class="btn-secondary">
                    </td>
                </tr>

            </table>


        </form>

        <?php 

            if(isset($_POST['submit']))
            {
                $title = mysqli_real_escape_string($conn, $_POST['title']);
                $description = mysqli_real_escape_string($conn, $_POST['description']);
                $price = mysqli_real_escape_string($conn, $_POST['price']);
                $category = mysqli_real_escape_string($conn, $_POST['category']);

                if (isset($_POST['featured'])) 
                {
                    $featured = $_POST['featured'];
                }
                else
                {
                    $featured = "No";
                }

                if (isset($_POST['active'])) 
                {
                    $active = $_POST['active'];
                }
                else
                {
                    $active = "No";
                }

                if (isset($_FILES['image']['name'])) 
                {
                   $image_name = $_FILES['image']['name'];
                   if ($image_name != "") 
                   {
                       $ext = end(explode('.', $image_name));

                       $image_name = "zaxxun-food".rand(000,9999).'.'.$ext;

                       $src = $_FILES['image']['tmp_name'];

                       $dst = "../img/food/".$image_name;
    
                       $upload = move_uploaded_file($src, $dst);

                       if($upload==false)
                       {

                        $_SESSION['upload'] = "<div class='error'>
                        Failed to upload image </div>";
                        header('location: add-food.php');
                        die();
                       }

                   }
                }
                else
                {
                   $image_name = ""; 
                }
                //wala single quote sa numerical
                $sql2 = "INSERT INTO tbl_food SET
                    title = '$title',
                    description = '$description',
                    price = $price,
                    image_name = '$image_name',
                    category_id = $category,
                    featured = '$featured',
                    active = '$active'
                ";

                $res2 = mysqli_query($conn, $sql2);

                if($res2==true)
                {
                    $_SESSION['add'] = "<div class='success'>
                        Food added successfully </div>";
                    header('location: manage-food.php');
                }
                else
                {
                    $_SESSION['add'] = "<div class='error'>
                        Failed to add food </div>";
                    header('location: manage-food.php');
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
