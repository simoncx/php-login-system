<?php

if (isset($_POST['login-submit']))
{    
    require 'dbh.inc.php';
    
    $mailuid = $_POST['mailuid'];
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
                    
                    header("Location: ../index.php?login=success");
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
}
 else 
{
    header("Location: ../login.php?error=serverproblem");
    exit();
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

?>