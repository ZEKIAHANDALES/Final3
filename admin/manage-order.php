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
        header('location: admin/login.php');

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
        <h1>Manage Order</h1>
        <br/><br/><br>
                <table class="tbl-full">

                    <?php 

                        if(isset($_SESSION['update']))
                        {
                            echo $_SESSION['update'];
                            unset($_SESSION['update']);
                        }

                    ?>
                    <br><br>
                <tr>
                    <th>ID</th>
                    <th>Food</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Order Date</th>
                    <th>Status</th>
                    <th>Customer Name</th>
                    <th>Table Number</th>
                    <th>Suggestions</th>
                    <th>Actions</th>
                </tr>

                <!--Retrieving database and method Here -->

                <?php 

                $sql = "SELECT * FROM tbl_order ORDER BY id DESC";
                $res = mysqli_query($conn, $sql);
                $count = mysqli_num_rows($res);
                $sn=1;

                if($count>0)
                {
                    while($row=mysqli_fetch_assoc($res))
                    {
                        $id = $row['id'];
                        $food = $row['food'];
                        $price = $row['price'];
                        $qty = $row['qty'];
                        $total = $row['total'];
                        $order_date = $row['order_date'];
                        $status = $row['status'];
                        $customer_name = $row['customer_name'];
                        $customer_table = $row['customer_table'];
                        $customer_suggestions = $row['customer_suggestions'];

                        ?>

                             <tr>
                                <td><?php echo $sn++; ?> </td>
                                <td><?php echo $food; ?> </td>
                                <td>Php <?php echo $price; ?></td>
                                <td><?php echo $qty; ?></td>
                                <td>Php <?php echo $total; ?></td>
                                <td><?php echo $order_date; ?></td>

                                <td>
                                    <?php  

                                    if($status=="Ordered")
                                    {
                                        echo "<label>$status</label>";
                                    }
                                    elseif($status=="Preparing")
                                    {
                                        echo "<label style='color: yellow;'>$status</label>";
                                    }
                                    elseif($status=="Delivered")
                                    {
                                        echo "<label style='color: green;'>$status</label>";
                                    }
                                    elseif($status=="Cancelled")
                                    {
                                        echo "<label style='color: red;'>$status</label>";
                                    }

                                    ?> 
                                </td>

                                <td><?php echo $customer_name; ?></td>
                                <td><?php echo $customer_table; ?></td>
                                <td><?php echo $customer_suggestions; ?></td>
                                <td>
                                    <a href="admin/update-order.php?id=<?php echo $id;?>"class="btn-secondary">Update Order</a>
                                </td>
                            </tr>

                        <?php
                    }
                }
                else
                {
                    echo "<tr><td colspan='12' class='error'>Orders not available</td></tr>";
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
