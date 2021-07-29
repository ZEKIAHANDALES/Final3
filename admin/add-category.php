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
        
        <h1>Add Category</h1>

        <br><br>

        <?php 

                if(isset($_SESSION['add']))
                {
                 echo $_SESSION['add'];
                 unset($_SESSION['add']);
                }


                if(isset($_SESSION['upload']))
                {
                 echo $_SESSION['upload'];
                 unset($_SESSION['upload']);
                }
        ?>

        <br><br>


        <form action="" method="POST" enctype="multipart/form-data">
            
            <table class="tbl-30">
                
                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="title" placeholder="Category Title">
                    </td>
                </tr>

                <tr>
                    <td>Select image: </td>
                    <td>
                        <input type="file" name="image">
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
                    <td>Active</td>
                    <td>
                        <input type="radio" name="active" value="Yes"> Yes
                        <input type="radio" name="active" value="No"> No

                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Category" class="btn-secondary">
                    </td>
                </tr>

            </table>

        </form>

        <?php 


        if(isset($_POST['submit']))
        {

            $title = mysqli_real_escape_string($conn, $_POST['title']);

            if(isset($_POST['featured']))
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


            //print_r($_FILES['image']);

            //die(); //break code ditooooooo

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
                    header('location: add-category.php');

                    die();

                }

            } 
                
            }
            else
            {
                $image_name="";
            }


            $sql = "INSERT INTO tbl_category SET 
            title = '$title',
            image_name = '$image_name',
            featured = '$featured',
            active = '$active'
            ";

            $res = mysqli_query($conn, $sql);

            if($res==true)
            {

                $_SESSION['add'] = "<div class='success'>Category added successfully.</div>";

                header('location: manage-category.php');

            }
            else
            {
                $_SESSION['add'] = "<div class='error'>Failed to add category </div>";

                header('location: add-category.php');


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
