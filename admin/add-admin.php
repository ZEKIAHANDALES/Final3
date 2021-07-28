<?php include('partials/menu.php');?>


<div class="main-content">
    <div class="wrapper">
        <h1>Add Admin</h1>

        <br><br>
        <?php
            if(isset($_SESSION['add']))
            {
                echo $_SESSION['add'];
                unset($_SESSION['add']);
            }
        ?>

        <form action="" method="POST">
            
            <table class="tbl-30">
                <tr>
                   <td>Full name: </td>
                   <td>
                    <input type="text" name="full_name" placeholder="Enter Name">
                </td>
                </tr>

                <tr>
                    <td>Username: </td>
                    <td>
                        <input type="text" name="username" placeholder="Enter Username">
                    </td>
                </tr>

                <tr>
                    <td>Password: </td>
                    <td>
                        <input type="password" name="password" placeholder="Enter Password">
                    </td>

                </tr>

                <tr>
                    <td colspan="2"> 
                        <input type="submit" name="submit" value="Add Admin" class="btn-secondary">

                    </td>
                </tr>

            </table>


        </form>
    </div>
</div>

<?php include('partials/footer.php');?>

<?php 
    //process value form and save it to database
    //check whether the sub btn is clicked

    if(isset($_POST['submit']))
    {
        // btn clicked 
        //echo "Button Clicked";

        //get data from form

        $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = mysqli_real_escape_string($_POST['password']); //password encryption md5 if want

        //SQL query to save data to database

        $sql = "INSERT INTO tbl_admin SET
            full_name='$full_name',
            username='$username',
            password='$password'
        ";

        //exec query and save to database
        $res = mysqli_query($conn, $sql) or die(mysqli_error());

        if($res==TRUE)
        {
            //data inserted
            //session var to disp message
            $_SESSION['add'] = "Admin added successfully";
            //redirect to MAdmin
            header("location:".SITEURL.'admin/manage-admin.php');
        }
        else
        {
            $_SESSION['add'] = "Failed to add admin";
            //redirect to addAdmin
            header("location:".SITEURL.'admin/add-admin.php');
            
        }


            }
?>