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
    <link rel="stylesheet" href="css/style.css">
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

    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search text-center">
        <div class="container">
            
            <form action="food-search.php" method="POST">
                <input type="search" name="search" placeholder="Search for Food.." required>
                <input type="submit" name="submit" value="Search" class="btn btn-primary">
            </form>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->


    <!-- fOOD MEnu Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Featured on Menu</h2>

            <?php  

            $sql = "SELECT * FROM tbl_food WHERE active='Yes' && featured='Yes'";

            $res = mysqli_query($conn, $sql);

            $count = mysqli_num_rows($res);

            if ($count>0) 
            {
                while ($row=mysqli_fetch_assoc($res)) 
                {
                    $id = $row['id'];
                    $title = $row['title'];
                    $description = $row['description'];
                    $price = $row['price'];
                    $image_name = $row['image_name'];
                    ?>

            <div class="food-menu-box">
                <div class="food-menu-img">

                    <?php 
                    if ($image_name=="") 
                    {
                        echo "<div class='error'>Image not Available </div>";
                    }
                    else
                    {
                        ?>

                            <img src="img/food/<?php echo $image_name; ?>" class="img-responsive img-curve">

                        <?php
                    }

                    ?>

                </div>

                <div class="food-menu-desc">
                    <h4><?php echo $title; ?></h4>
                    <p class="food-price"><?php echo $price; ?></p>
                    <p class="food-detail"><?php echo $description; ?></p>

                    <br>
                    <a href="order.php?food_id=<?php echo $id; ?>" class="btn btn-primary"> Order </a>
                </div>
            </div>


                    <?php
                }
            }
            else
            {
                echo "<div class='error'>Food is currently unavailable. Please try again later.</div>";
            }

            ?>


            <div class="clearfix"></div>

        </div>
    </section>
    <!-- Food Menu Section Ends Here -->

    <!-- Footer Here -->
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
