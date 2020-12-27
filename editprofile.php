
<html>
<head>
<meta charset="utf-8">
<title>My Account</title>
	<link href="css/simpleGridTemplate.css" rel="stylesheet" type="text/css">
	<link href="mycss.css" rel="stylesheet" type="text/css">
    <link href="custom.css" rel="stylesheet" type="text/css">
    <style type="text/css">
		body{   
            background-image: url('bgfile1.jpg');
            background-color: aliceblue;
            background-size: cover;
            background-attachment: fixed;
            overflow-x: hidden; 
        }

        .signup h6{
            font-size: 20px;
            text-align: left;
            margin-left: 21%;
        }

@media screen and (max-width: 768px){
    .signup {
    color: white;
    margin-left:2% !important;
    padding: 20px;
}
}	
	</style>
</head>

<body>
<?php include 'includes/header.php'; ?>

<?php
    
    
    if (!isset($_SESSION['userId']))
    {
        header("Location: index.php");
        exit();
    }    
?>


<div class="signup">
	<div class="row">
		<div class="col-lg-12">
<a href="../profile.php" class="fa fa-sign-in" style="font-size:20px;color:white; text-decoration: none;">back</a>

<div style="text-align: center">
    <img id="userdp" src=<?php echo "./uploads/".$_SESSION['userImg']; ?> >
 
    <h6><?php echo strtolower($_SESSION['userUid']); ?></h6>


</div>

<?php
        $userName = '';
        $email = ''; 
    
        if(isset($_GET['error']))
        {
            if($_GET['error'] == 'emptyemail')
            {
                echo '<p class="closed">*Profile email cannot be empty</p>';
                $email = $_GET['mail'];
            }
            else if ($_GET['error'] == 'invalidmail')
            {
                echo '<p class="closed">*Please enter a valid email</p>';
            }
            else if ($_GET['error'] == 'emptyoldpwd')
            {
                echo '<p class="closed">*You must enter the current password to change it</p>';
            }
            else if ($_GET['error'] == 'emptynewpwd')
            {
                echo '<p class="closed">*Please enter the new password</p>';
            }
            else if ($_GET['error'] == 'emptyreppwd')
            {
                echo '<p class="closed">*Please confirm new password</p>';
            }
            else if ($_GET['error'] == 'wrongpwd')
            {
                echo '<p class="closed">*Current password is wrong</p>';
            }
            else if ($_GET['error'] == 'samepwd')
            {
                echo '<p class="closed">*New password cannot be same as old password</p>';
            }
            else if ($_GET['error'] == 'passwordcheck')
            {
                echo '<p class="closed">*Confirmation password is not the same as the new password</p>';
            }
            else if (isset($_GET['error']) == 'serverproblem')
            {
            echo '<p class="open">*SERVER PROBLEM* Please try again after some time.</p>';
            }
            else if (isset($_GET['edit']) == 'success')
            {
            echo '<p class="open">*Profile Updated Successfully</p>';
            }
        }
?>

<form action="includes/profileUpdate.inc.php" method='post' id="contact-form" enctype="multipart/form-data">

        <h5>Personal Information</h5>
        
        <label for="email">Email</label>
        <input type="email" id="email" name="email" placeholder="email" 
               value=<?php echo $_SESSION['emailUsers']; ?>><br>
                
        <label>Full Name</label>
        <input type="text" id="f-name" name="f-name" placeholder="First Name" 
               value=<?php echo $_SESSION['f_name']; ?>>
        <input type="text" id="l-name" name="l-name" placeholder="Last Name" 
               value=<?php echo $_SESSION['l_name']; ?>>
        
        <label class="container" for="gender-m"><b style="margin-left: 15px;">Male</b>
          <input type="radio" name="gender" value="m" id="gender-m"
                 <?php if ($_SESSION['gender'] == 'm' or 'male'){ ?> 
                 checked="checked"
                 <?php } ?>>
          <span class="checkmark"></span>
        </label>
        <label class="container" for="gender-f"><b style="margin-left: 15px;">Female</b>
          <input type="radio" name="gender" value="f" id="gender-f"
                 <?php if ($_SESSION['gender'] == 'f' or 'female'){ ?> 
                 checked="checked"
                 <?php } ?>>
          <span class="checkmark"></span>
        </label>
       
        
        <label for="bio">Profile Bio</label>
        <textarea id="bio" name="bio" maxlength="5000"
            placeholder="What you want to tell people about yourself" 
            ><?php echo $_SESSION['bio']; ?></textarea>
        
        <h5>Change Password</h5>
        <input type="password" id="old-pwd" name="old-pwd" placeholder="current password">
        <input type="password" id="pwd" name="pwd" placeholder="new password">
        <input type="password" id="pwd-repeat" name="pwd-repeat" placeholder="repeat new password"><br>

        <h5>Social Accounts</h5>
        <input type="text" id="insta" name="insta" placeholder="Instagram Account" value=<?php echo $_SESSION['insta']; ?>>
        
        <h5>Profile Picture</h5>
        <div class="upload-btn-wrapper"> 
        <input type="file" name="dp" id="file-1" class="inputfile inputfile-1" data-multiple-caption="{count} files selected" multiple style="display: none;" />
        <label for="file-1"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/></svg> <span>Choose a file&hellip;</span></label>
        </div>
        
        <input type="submit" class="button next" name="update-profile" value="Update Profile">
        
    </form>
</div>
</div>
</div>
</body>