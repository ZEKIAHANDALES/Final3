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
                header('location:'.SITEURL);
            }

        }
        else
        {
            header('location:'.SITEURL);
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

                            header('location:'.SITEURL);
                    }
                    else
                    {   
                        $_SESSION['order'] = "<div class='error text-center'>Order failed</div>";

                            header('location:'.SITEURL);
                    }

                }                

            ?>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->

    <!-- social Here -->
?>
