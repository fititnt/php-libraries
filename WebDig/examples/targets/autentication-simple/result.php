<?php
/**
 * @package         WebDig
 * @author          Emerson Rocha Luiz - emerson at webdesign.eng.br - http://fititnt.org
 * @copyright       Copyright (C) 2011 Webdesign Assessoria em Tecniligia da Informacao. All rights reserved.
 * @license         GNU General Public License version 3. See license-gpl3.txt
 * @license         Massachusetts Institute of Technology. See license-mit.txt
 * @version         0.1alpha
 * 
 */
session_start();

if ( !isset($_SESSION['autorized']) ) die('You are not autorized to see this page. You must have cookies enabled');
?>
<!DOCTYPE HTML>
<html>
<head>
    <title>Your are logged</title>
</head>
<body>
    <p>Hi, <?php echo $_SESSION['username']; ?></p>
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
