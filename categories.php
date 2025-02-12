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
<!DOCTYPE html>
<html lang = "en">
<head>
    <meta charset="utf-8">
    <meta name = "viewport" content="width=device-width, initial-scale=1.0">
    <title>ZAXXUN ROBOT CAFE</title>

    <!-- link our css file -->
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
    <!-- Navbar Section Starts Here -->
    <section class="navbar">
        <div class="container">
            <div class="logo">
                <img src="img/logo.png" alt="Zaxxun Logo" class="img-responsive">
            </div>

            <div class="menu text-right">
                <ul>
                    <li>
                        <a href="indexwelcome.php">Home</a>
                    </li>
                    <li>
                        <a href="categories.php">Categories</a>
                    </li>

                    <li>
                        <a href="foods.php">Featured</a>
                    </li>

                </ul>       
            </div>

            <div class="clearfix"></div>
        </div>
    </section>
    <!-- Navbar Section Ends Here -->


    <!-- Categories Section Starts Here -->
    <section class="categories">
        <div class="container">
            <h2 class="text-center">All Categories</h2>


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
                    $image_name = $row['image_name'];
    ?>

                <a href="category-foods.php?category_id=<?php echo $id; ?>">
                    <div class="box-3 float-container">

    <?php 

                            if($image_name=="")
                            {
                                echo "<div class='error'>Image not available</div>";
                            }
                            else
                            {

    ?>

                            <img src="img/category/<?php echo $image_name; ?>" alt="Carbonara" class="img-responsive img-curve">

     <?php
                            }

    ?>

                        <h3 class="float-text text-color"><?php echo $title; ?></h3>
                    </div>
                </a>

    <?php 
                }
            }
            else
            {
                echo "<div class='error'> Category not Available </div>";
            }

    ?>
     

            <div class="clearfix"></div>
        </div>
    </section>
    <!-- Categories Section Ends Here -->


    <!-- social Section Starts Here -->
<section class="social">
        <div class="container text-center">
            <ul>
                <li>
                    <a href="https://www.facebook.com/zaxxunorg/"><img src="./img/fb.png"/></a>
                </li>
                <li>
                    <a href="https://www.instagram.com/zaxxun/"><img src="./img/ig.png"/></a>
                </li>
                <li>
                    <a href="https://twitter.com/zaxxun"><img src="./img/twitter.png"/></a>
                </li>   
            </ul>
        </div>
    </section>
    <!-- Social Section Ends Here -->

    <!-- Footer Section Starts Here -->
    <section class="footer">
        <div class="container text-center">
            <p>All rights reserved ©.</p>
        </div>
    </section>
    <!-- Footer Search Section Ends Here -->
	
</body>
</html>
