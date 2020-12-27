<?php 
    define('TITLE',"login | Macroprime photos");
?>
<head>
	<link href="mycss.css" rel="stylesheet" type="text/css">
    <title> <?php echo TITLE; ?></title>
</head>


<div class="login">
    <a href="index.php" class="fa fa-home" style="font-size:20px;color: white; text-decoration: none;"></a>
    <div class="row">
        <div class="col-lg-8">
           <h4>Login to your account</h4>
 <?php 
            
            if(isset($_SESSION['userId']))
            {
               header("Location: index.php");
        exit();
            }
            else
            {
                if(isset($_GET['error']))
                {
                    if($_GET['error'] == 'emptyfields')
                    {
                        echo '<p class="closed">*please fill in all the fields</p>';
                    }
                    else if($_GET['error'] == 'nouser')
                    {
                        echo '<p class="closed">*username does not exist</p>';
                    }
                    else if ($_GET['error'] == 'wrongpwd')
                    {
                        echo '<p class="closed">*wrong password</p>';
                    }
                    else if ($_GET['error'] == 'deactivated')
                    {
                       echo "<h3>Sorry your account has been deactivated.</h3>
                       <p>please contact the administrator via live chat for more infomation</p>";
                    }
                    else if ($_GET['error'] == 'serverproblem')
                    {
                        echo '<p class="closed">*server problem. contact admin to have it fixed</p>';
                    }
                    else if ($_GET['error'] == 'sqlerror')
                    {
                        echo '<p class="closed">*website error. contact admin to have it fixed</p>';
                    }
                }

                echo '<form method="post" action="includes/login.inc.php" id="login-form">
                    <input type="text" id="name" name="mailuid" placeholder="Username..."> 
                    <input type="password" id="password" name="pwd" placeholder="Password..."><br>

                    <input type="checkbox" class="flipswitch" name="remember" /> &nbsp;<br><span>Remember me</span>

                    <input type="submit" class="button next login" name="login-submit" value="Login">
                </form>
                    <p>Create an account</p> <a href="signup.php" class="button previous">Signup</a>
                    ';               
            }
        ?>

       </div>
   </div>
</div>