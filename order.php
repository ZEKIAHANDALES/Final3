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


    <?php 

        if(isset($_GET['food_id']))
        {
            $food_id = $_GET['food_id'];

            $sql = "SELECT * FROM tbl_food WHERE id=$food_id";
            $res = mysqli_query($conn, $sql);
            $count = mysqli_num_rows($res);

            if ($count==1)
            {
                $row = mysqli_fetch_assoc($res);
                $title = $row['title'];
                $price = $row['price'];
                $image_name = $row['image_name'];
            }
            else
            {
                header('location: indexwelcome.php');
            }

        }
        else
        {
            header('location:indexwelcome.php');
        }

    ?>

    <section class="food-search">
        <div class="container">
            
            <h2 class="text-center text-white">Please provide the information needed to confirm your order.</h2>
<!--Need to revise here to css---->
            <form action="" method="POST" class="order">
                <fieldset>
                    <legend>Selected Food</legend>

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
                        <h3><?php echo $title; ?></h3>
                        <input type="hidden" name="food" value="<?php echo $title; ?>">
                        <p class="food-price"><?php echo $price; ?></p>
                        <input type="hidden" name="price" value="<?php echo $price; ?>">

                        <div class="order-label">Quantity</div>
                        <input type="number" name="qty" class="input-responsive" value="1" required>
                        
                    </div>

                </fieldset>
                
                <fieldset>
                    <legend>Serving Details</legend>
                    <div class="order-label">Name</div>
                    <input type="text" name="full-name" placeholder="E.g. Jon" class="input-responsive">

                    <div class="order-label">Table Number</div>
                    <input type="tel" name="table-number" placeholder="E.g. 5" class="input-responsive" required>


                    <div class="order-label">Suggestions</div>
                    <textarea name="suggestions" rows="10" placeholder="E.g. No mayonnaise" class="input-responsive"></textarea>

                    <input type="submit" name="submit" value="Confirm Order" class="btn btn-primary">
                </fieldset>

            </form>

            <!-- Retrieving from Database  Here -->

            <?php 


                if(isset($_POST['submit']))
                {
                    $food = $_POST['food'];
                    $price = $_POST['price'];
                    $qty = $_POST['qty'];
                    $total = $price * $qty;

                    $order_date = date("Y-m-d h:i:sa"); //order date!!

                    $status = "Ordered";

                    $customer_name = $_POST['full-name'];
                    $customer_table = $_POST['table-number'];
                    $customer_suggestions = $_POST['suggestions'];

                    $sql2 = "INSERT INTO tbl_order SET
                        food = '$food',
                        price = $price,
                        qty = $qty,
                        total = $total,
                        order_date = '$order_date',
                        status = '$status',
                        customer_name = '$customer_name',
                        customer_table = '$customer_table',
                        customer_suggestions = '$customer_suggestions'

                    ";

                    $res2 = mysqli_query($conn, $sql2);
                    
                    if($res2==true)
                    {
                        $_SESSION['order'] = "<div class='success text-center'>Order Placed Successfully</div>";

                            header('location:indexwelcome.php');
                    }
                    else
                    {   
                        $_SESSION['order'] = "<div class='error text-center'>Order failed</div>";

                            header('location: indexwelcome.php');
                    }

                }                

            ?>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->

    <!-- social Here -->
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
