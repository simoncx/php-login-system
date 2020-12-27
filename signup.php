<?php
    define('TITLE',"Signup");
    
    if(isset($_SESSION['userId']))
    {
        header("Location: index.php");
        exit();
    }
?>

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

    .signup textarea{
           width: 70%;
           border-radius: 10px;
           border: none;
           background-color: #f2f2f2;
           color: black;
}

       input[type="email"]{
        background-color: #f2f2f2;
       }
    
    </style>
</head>

<div class="signup">
    <hr>
    <a href="index.php" class="fa fa-home" style="font-size:20px;color: white; text-decoration: none;"></a>
    <?php
    
        $userName = ''; 
        $email = '';
    
        if(isset($_GET['error']))
        {
            if($_GET['error'] == 'emptyfields')
            {
                echo '<p class="closed">*Fill In All The Fields</p>';
                $userName = $_GET['uid'];
                $email = $_GET['mail'];
            }
            else if ($_GET['error'] == 'invalidmailuid')
            {
                echo '<p class="closed">*Please enter a valid email and user name</p>';
            }
            else if ($_GET['error'] == 'invalidmail')
            {
                echo '<p class="closed">*Please enter a valid email</p>';
            }
            else if ($_GET['error'] == 'invaliduid')
            {
                echo '<p class="closed">*Please enter a valid user name</p>';
            }
            else if ($_GET['error'] == 'passwordcheck')
            {
                echo '<p class="closed">*Passwords donot match</p>';
            }
            else if ($_GET['error'] == 'usertaken')
            {
                echo '<p class="closed">*This User name is already taken</p>';
            }
            else if ($_GET['error'] == 'emailtaken')
            {
                echo '<p class="closed">*This email is already taken</p>';
            }
            else if ($_GET['error'] == 'invalidimagetype')
            {
                echo '<p class="closed">*Invalid image type. Profile image must be a .jpg or .png file</p>';
            }
            else if ($_GET['error'] == 'imguploaderror')
            {
                echo '<p class="closed">*Image upload error</p>';
            }
            else if ($_GET['error'] == 'imgsizeexceeded')
            {
                echo '<p class="closed">*Image too large</p>';
            }
            else if ($_GET['error'] == 'sqlerror')
            {
                echo '<p class="closed">*Website Error: Contact admin to have the issue fixed</p>';
            }
        }
        else if (isset($_GET['signup']) == 'success')
        {
            echo '<p class="open">*Signup Successful. Please login from the button above</p>';
        }
    ?>
    <form action="includes/signup.inc.php" method='post' id="contact-form" enctype="multipart/form-data">

        <input type="text" id="name" name="uid" placeholder="Username" value=<?php echo $userName; ?>>
        <input type="email" id="email" name="mail" placeholder="email" value=<?php echo $email; ?>>
        <input type="password" id="pwd" name="pwd" placeholder="password">
        <input type="password" id="pwd-repeat" name="pwd-repeat" placeholder="repeat password">
        
        <div class="upload-btn-wrapper">
        <input type="file" name="dp" id="file-1" class="inputfile inputfile-1" data-multiple-caption="{count} files selected" multiple style="display: none;" />
        <label for="file-1"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/></svg> <span>Choose a profile picture&hellip;</span></label>
        </div>
        <!-- <img id="userDp" src="" >-->
        <h5>Gender</h5>
        <label class="container" for="gender-m"><b style="margin-left: 15px;">Male</b>
          <input type="radio" checked="checked" name="gender" value="m" id="gender-m">
          <span class="checkmark"></span>
        </label>
        <label class="container" for="gender-f"><b style="margin-left: 15px;">Female</b>
          <input type="radio" name="gender" value="f" id="gender-f">
          <span class="checkmark"></span>
        </label>

        <h5>Optional</h5>
        <input type="text" id="f-name" name="f-name" placeholder="First Name" >
        <input type="text" id="l-name" name="l-name" placeholder="Last Name" >
        <h5>Bio</h5>
        <textarea id="bio" name="bio" placeholder="About you..."></textarea>
        
        <input type="submit" class="button next" name="signup-submit" value="signup">
        <p>Already have an account</p><a href="profile.php" class="btn" style="border: unset; margin-left: 0; color: dodgerblue; background-color: #222;transform: unset;">login</a>
        
    </form>

    <hr>
</div>
</div>
