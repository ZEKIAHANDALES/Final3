
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
            <h1>Summary Dashboard</h1>

            <?php 

                if(isset($_SESSION['login']))
                {
                 echo $_SESSION['login'];
                 unset($_SESSION['login']);
                }
            ?>
            <br><br>

            <div class="col-4 text-center">
                <?php 

                    $sql = "SELECT * FROM tbl_category";

                    $res = mysqli_query($conn, $sql);

                    $count = mysqli_num_rows($res);


                ?>
                <h1><?php echo $count; ?></h1>
                <br/>
                Total Food Categories
            </div>


            <div class="col-4 text-center">
                <?php 

                    $sql2 = "SELECT * FROM tbl_food";

                    $res2 = mysqli_query($conn, $sql2);

                    $count2 = mysqli_num_rows($res2);


                ?>
                <h1><?php echo $count2; ?></h1>
                <br/>
                Total Foods on Menu
            </div>

            <div class="col-4 text-center">
                <?php 
                    $sql6 = "SELECT COUNT(featured) AS Featured FROM tbl_food WHERE featured='Yes'";

                    $res6 = mysqli_query($conn, $sql6);

                    $row6 = mysqli_fetch_assoc($res6);
                    $total_featured = $row6['Featured'];
                    
                    
                ?>
                <h1><?php echo $total_featured; ?></h1>
                <br/>
                Total Featured Foods
            </div>

            <div class="col-4 text-center">
                <?php 
                    $sql7 = "SELECT COUNT(active) AS Active FROM tbl_food WHERE Active='Yes'";

                    $res7 = mysqli_query($conn, $sql7);

                    $row7 = mysqli_fetch_assoc($res7);
                    $total_active = $row7['Active'];
                    
                    
                ?>

                
                <h1><?php echo $total_active; ?></h1>
                <br/>
                Total Active Foods
            </div>

            <div class="col-4 text-center">
                <?php 
                    $sql8 = "SELECT COUNT(active) AS Active FROM tbl_food WHERE active='No'";

                    $res8 = mysqli_query($conn, $sql8);

                    $row8 = mysqli_fetch_assoc($res8);
                    $total_inactive = $row8['Active'];
                    
                    
                ?>
                <h1><?php echo $total_inactive; ?></h1>
                <br/>
                Total Inactive Foods
            </div>


            <div class="col-4 text-center">
                <?php 

                    $sql3 = "SELECT * FROM tbl_order";

                    $res3 = mysqli_query($conn, $sql3);

                    $count3 = mysqli_num_rows($res3);

                ?>

                <h1><?php echo $count3; ?></h1>
                <br/>
                Total Orders
            </div>


            <div class="col-4 text-center">
                <?php 

                    
                    $sql4 = "SELECT SUM(total) AS Total FROM tbl_order WHERE status='Delivered'";

                    $res4 = mysqli_query($conn, $sql4);

                    $row4 = mysqli_fetch_assoc($res4);

                    $total_revenue = $row4['Total'];
                ?>
                <h1>Php <?php echo $total_revenue; ?></h1>
                <br/>
                Total Sales
            </div>

            <div class="col-4 text-center">
                <?php 
                    $sql5 = "SELECT * FROM tbl_admin";

                    $res5 = mysqli_query($conn, $sql5);

                    $count5 = mysqli_num_rows($res5);
                    
                    
                ?>
                <h1><?php echo $count5; ?></h1>
                <br/>
                Total Admins
            </div>

            <div class="clearfix"></div>

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
