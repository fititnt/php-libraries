<?php
/*
 * @package         WebDig
 * @author          Emerson Rocha Luiz - emerson at webdesign.eng.br - http://fititnt.org
 * @copyright       Copyright (C) 2011 Webdesign Assessoria em Tecniligia da Informacao. All rights reserved.
 * @license         GNU General Public License version 3. See license-gpl3.txt
 * @license         Massachusetts Institute of Technology. See license-mit.txt
 * @version         0.1alpha
 * 
 */
$loginError = FALSE;
session_start();

if( isset($_REQUEST['logout']))
{    
    $_SESSION = array();
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    session_destroy();
} 
else if( isset($_REQUEST['username']) )
{
    
    if ( $_REQUEST['username'] == 'user' && $_REQUEST['password'] == 'pass')
    {   
        //Session
        $_SESSION['username'] = $_REQUEST['username'];
        $_SESSION['password'] = $_REQUEST['password'];
        $_SESSION['autorized'] = TRUE;
        
        //Redirect
        header('Location: result.php');
        
    } else {
        $loginError = TRUE;
        //header('Location: error.php');
    }
}


?>
<!DOCTYPE HTML>
<html>
<head>
    <title>Login</title>
</head>
<body>
<fieldset>  
    <legend>Login</legend>
    <?php if ( $loginError ) { ?>
    <p>Your username and password do not mach, or you do not have one account. <a href="login.php">Try again</a></p>
    <?php } ?>    
    <form action="login.php" method="post">
        <label>Username</label>
        <input name="username" id="mod-login-username" type="text" size="15" />
        <br />
        <label>Password</label>
        <input name="password" type="password" size="15" />
        <br />
        <input type="submit"/>
    </form>
</fieldset>

    <div id="menu">
        <ul>
            <li><a href="login.php">Login</a></li>
            <li><a href="result.php">Result</a></li>
            <li><a href="etc.php">Etc</a></li>
            <li><a href="login.php?logout=1">Logout</a></li>
        </ul>
    </div>
</body>
</html>
