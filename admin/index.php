<?php include('partials/menu.php');?>


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
<?php include('partials/footer.php');?>
