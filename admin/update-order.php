<?php include('partials/menu.php');?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Order</h1>
        <br/><br/><br>

        <?php 

            if (isset($_GET['id'])) 
            {
                $id=$_GET['id'];
                $sql = "SELECT * FROM tbl_order WHERE id=$id";
                $res = mysqli_query($conn, $sql);

                $count = mysqli_num_rows($res);

                if($count>0)
                {
                    $row = mysqli_fetch_assoc($res);
                    $food = $row['food'];
                    $price = $row['price'];
                    $qty = $row['qty'];
                    $customer_table = $row['customer_table'];
                    $status = $row['status'];

                }
                else
                {
                    header('location:'.SITEURL.'admin/manage-order.php');
                }
            }
            else
            {
                header('location:'.SITEURL.'admin/manage-order.php');
            }

        ?>

        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Food Name</td>
                    <td><b><?php echo $food; ?></b></td>
                </tr>

                <tr>
                    <td>Price</td>
                    <td><b>Php <?php echo $price; ?></b></td>
                </tr>

                <tr>
                    <td>Quantity</td>
                    <td>
                        <input type="number" name="qty" value="<?php echo $qty; ?>">
                    </td>     
                </tr>
                <tr>
                    <td>Table Number</td>
                    <td>
                        <input type="number" name="table_number" value="<?php echo $customer_table; ?>">
                    </td>     
                </tr>
                    
                <tr>
                    <td>Status</td>
                    <td>
                        <select name="status">
                            <option <?php if($status=="Ordered"){echo "select";} ?>value="Ordered">Ordered</option>
                            <option  <?php if($status=="Preparing"){echo "selected";}?>value="Preparing">Preparing</option>
                            <option <?php if($status=="Delivered"){echo "selected";} ?> value="Delivered">Delivered</option>
                            <option <?php if($status=="Cancelled"){echo "selected";} ?>value="Cancelled">Cancelled</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="hidden" name="price" value="<?php echo $price; ?>">
                        <input type="submit" name="submit" value="update order" class="btn-secondary">
                    </td>
                </tr>

            </table>
        </form>
        <?php 

            if(isset($_POST['submit']))
            {
                $id = $_POST['id'];
                $price = $_POST['price'];
                $qty = $_POST['qty'];
                $total = $price * $qty;
                $status = $_POST['status'];
                $customer_table = $_POST['table_number'];

                 $sql2 = "UPDATE tbl_order SET 

                    qty = $qty,
                    total = $total,
                    status = '$status',
                    customer_table = '$customer_table'

                    WHERE id=$id

                 ";

                 $res2 = mysqli_query($conn, $sql2);

                 if($res2==true)
                 {
                    $_SESSION['update'] = "<div class='success'>Order Updated Successfully </div>";
                header('location: '.SITEURL.'admin/manage-order.php');
                 }
                 else
                 {
                   $_SESSION['update'] = "<div class='error'>Failed to updated order </div>";
                header('location: '.SITEURL.'admin/manage-order.php'); 
                 }
            }


        ?>


    </div>
</div>

<?php include('partials/footer.php');?>