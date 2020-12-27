<?php

if (isset($_POST['signup-submit']))
{    
    require 'dbh.inc.php';
    
    $userName = $_POST['uid'];
    $email = $_POST['mail'];
    $password = $_POST['pwd'];
    $passwordRepeat  = $_POST['pwd-repeat'];
    $gender = $_POST['gender'];
    $role = 'user';
    $bio = $_POST['bio'];
    $f_name = $_POST['f-name'];
    $l_name = $_POST['l-name'];
    
    if (empty($userName) || empty($email) || empty($password) || empty($passwordRepeat))
    {
        header("Location: ../signup.php?error=emptyfields&uid=".$userName."&mail=".$email);
        exit();
    }
    else if (!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/", $userName))
    {
        header("Location: ../signup.php?error=invalidmailuid");
        exit();
    }
    else if (!filter_var($email, FILTER_VALIDATE_EMAIL))
    {
        header("Location: ../signup.php?error=invalidmail&uid=".$userName);
        exit();
    }
    else if (!preg_match("/^[a-zA-Z0-9]*$/", $userName))
    {
        header("Location: ../signup.php?error=invaliduid&mail=".$email);
        exit();
    }
    else if ($password !== $passwordRepeat)
    {
        header("Location: ../signup.php?error=passwordcheck&uid=".$userName."&mail=".$email);
        exit();
    }
    else
    {
        // checking if a user already exists with the given username
        $sql = "select uidUsers from users where uidUsers=?;";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql))
        {
            header("Location: ../signup.php?error=sqlerror");
            exit();
        }
        else
        {
            mysqli_stmt_bind_param($stmt, "s", $userName);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            
            $resultCheck = mysqli_stmt_num_rows($stmt);
            
            if ($resultCheck > 0)
            {
                header("Location: ../signup.php?error=usertaken&mail=".$email);
                exit();
            }

        
           // checking if a useremail already exists with the given username
            $sql = "select emailUsers from users where emailUsers=?;";
            $stmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt, $sql))
            {
            header("Location: ../signup.php?error=sqlerror");
            exit();
            }
           else
           {
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            
            $resultCheck = mysqli_stmt_num_rows($stmt);
            
            if ($resultCheck > 0)
            {
                header("Location: ../signup.php?error=emailtaken&mail=".$email);
                exit();
            }

            else
            {
                $FileNameNew = 'default.png';
                require 'upload.inc.php';
                
                $sql = "insert into users(uidUsers, emailUsers, f_name, l_name, pwdUsers, gender, "
                        . "role, bio, userImg) "
                        . "values (?,?,?,?,?,?,?,?,?)";
                $stmt = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt, $sql))
                {
                    header("Location: ../signup.php?error=sqlerror");
                    exit();
                }
                else
                {
                    $hashedPwd = password_hash($password, PASSWORD_DEFAULT);
                    
                    mysqli_stmt_bind_param($stmt, "sssssssss", $userName, $email, $f_name, $l_name,
                            $hashedPwd, $gender,
                            $role, $bio, $FileNameNew);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_store_result($stmt);

                //Login user//
                    $mailuid = $_POST['uid'];
                    $password = $_POST['pwd'];
                    
                    if (empty($mailuid) || empty($password))
                    {
                        header("Location: ../login.php?error=emptyfields");
                        exit();
                    }
                    else
                    {
                        $sql = "SELECT * FROM users WHERE uidUsers=?;";
                        $stmt = mysqli_stmt_init($conn);
                        
                        if (!mysqli_stmt_prepare($stmt, $sql))
                        {
                            header("Location: ../login.php?error=sqlerror");
                            exit();
                        }
                        else
                        {
                            mysqli_stmt_bind_param($stmt, "s", $mailuid);
                            mysqli_stmt_execute($stmt);
                            
                            $result = mysqli_stmt_get_result($stmt);
                            
                            if($row = mysqli_fetch_assoc($result))
                            {    
                                if($row['status']== 'deactivated')

                                {
                                    header("Location: ../login.php?error=deactivated");
                                    exit();
                                }

                                $pwdCheck = password_verify($password, $row['pwdUsers']);
                                if ($pwdCheck == false)
                                {
                                    header("Location: ../login.php?error=wrongpwd");
                                    exit();
                                }
                                else if($pwdCheck == true)
                                {
                                    session_start();
                                    $_SESSION['userId'] = $row['idUsers'];
                                    $_SESSION['userUid'] = $row['uidUsers'];
                                    $_SESSION['emailUsers'] = $row['emailUsers'];
                                    $_SESSION['f_name'] = $row['f_name'];
                                    $_SESSION['l_name'] = $row['l_name'];
                                    $_SESSION['gender'] = $row['gender'];
                                    $_SESSION['headline'] = $row['headline'];
                                    $_SESSION['bio'] = $row['bio'];
                                    $_SESSION['userImg'] = $row['userImg'];
                                    $_SESSION['status'] = $row['status'] ;
                                    $_SESSION['role'] = $row['role'] ;
                                    $_SESSION['insta'] = $row['instagram'] ;
                                    
                                    header("Location: ../index.php?signup=success");
                                    
                                    exit();
                                }
                                else
                                { 
                                    header("Location: ../login.php?error=wrongpwd");
                                    exit();
                                }
                            }
                            else
                            {
                                header("Location: ../login.php?error=nouser");
                                exit();
                            }
                        }
                    }


                /*
                * -------------------------------------------------------------------------------
                *   Setting rememberme cookie
                * -------------------------------------------------------------------------------
                */

                        if($_POST['remember']) {
                             $year = time() + 31536000000000000000000000000000000000000;
                            setcookie('remember', $mailuid, $password, $year);
                    
                        }else

                           $year = time() + 31536000000000000000000000000000000000000;
                            setcookie('remember', $mailuid, $password, $year);
                    
                    header("Location: ../index.php?signup=success");
                    exit();
                }
            }
        }
    }
    
    mysqli_stmt_close($stmt);
    mysqli_close($conn);    
}
}

else
{
    header("Location: ../signup.php");
    exit();
}