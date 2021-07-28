<?php 
    include('../config/constants.php');

        if (isset($_GET['id']) AND isset($_GET['image_name'])) 
    {
      
        $id = $_GET['id'];
        $image_name = $_GET['image_name'];

        if ($image_name != "") 
        {
            $path = "../img/food/".$image_name;
            $remove = unlink($path);

            if ($remove==false) 
            {
                $_SESSION['remove'] = "<div class='error'>Failed to remove Food Image </div>";  

                header('location:'.SITEURL.'admin/manage-food.php'); 
                die();

            }
        }

        //delete from db

        $sql = "DELETE FROM tbl_food WHERE id=$id";

        $res = mysqli_query($conn, $sql);

        if ($res==true) 
        {

            $_SESSION['delete'] = "<div class='success'>Food Deleted Successfully </div>";
            header('location:'.SITEURL.'admin/manage-food.php');
            
        }
        else
        {

            $_SESSION['delete'] = "<div class='error'>Failed to delete food </div>";
            header('location:'.SITEURL.'admin/manage-food.php');

        }

    }

    else
    {
        $_SESSION['anauth'] = "<div class='error'>Unauthorized Access </div>";
        header('location:'.SITEURL.'admin/manage-food.php');

    }
?>