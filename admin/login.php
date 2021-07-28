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
    <title>Zaxxun Login</title>
    <link rel="stylesheet" type="text/css" href="../css/admin.css">
</head>
<body>

    <div class="login">
        <h1 class="text-center">Login</h1>
        <br><br>

        <?php 

        if(isset($_SESSION['login']))
        {
            echo $_SESSION['login'];
            unset($_SESSION['login']);
        }

        if (isset($_SESSION['no-login-message'])) 
        {
            echo $_SESSION['no-login-message'];
            unset ($_SESSION['no-login-message']);
        }
        ?>
        <br><br>

        <form action="" method="POST" class="text-center">
            
            Username: <br>
            <input type="text" name="username" placeholder="Enter Username"><br><br>

            Password: <br>

            <input type="password" name="password" placeholder="Enter Password"> <br><br>

            <input type="submit" name="submit" value="Login" class="btn-primary">
            <br><br>

        </form>

        <p class="text-center">All Rights Reserved.</p>
    </div>

</body>
</html>

<!-- Method Here -->

<?php 
    if(isset($_POST['submit']))
    {
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = mysqli_real_escape_string($conn, $_POST['password']); //md5 if want encrypt

        $sql = "SELECT * FROM tbl_admin WHERE username='$username' AND password='$password'";

        $res = mysqli_query($conn, $sql);

        $count = mysqli_num_rows($res);

        if($count==1)
        {

            $_SESSION['login'] = "<div class='success'>Login Successful.</div>";
            $_SESSION['user'] = $username;

            header("admin/");

        }
        else
        {
            $_SESSION['login'] = "<div class='error'>User could not be found.</div>";
            header("admin/login.php");
        }

    }
?>
