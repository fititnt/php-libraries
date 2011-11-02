<?php

if( isset($POST['url'])){
    $urld = new URLDecrypter();
    $solution = $urld->target( $POST['url'] )->solve();
}


?>

<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>URLDecrypter Example</title>
</head>
<body>
    <fieldset>
        <?php
        if( isset( $POST['url'] ) ){
            echo '<strong>'.$POST['url'].'</strong><br />';
            echo '<strong>'.$solution.'</strong><br />';
        }
        ?>        
        <legend>Decript URL</legend>
        <form action="form.php" method="post">
        URL <input type="text" name="url" />
        <input type="submit" value="Decript" />
        </form>
    </fieldset>
    
</body>
</html>
