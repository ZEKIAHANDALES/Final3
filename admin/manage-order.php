<?php include('partials/menu.php');?>

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
                                    <a href="<?php echo SITEURL; ?>admin/update-order.php?id=<?php echo $id;?>"class="btn-secondary">Update Order</a>
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

<?php include('partials/footer.php');?>