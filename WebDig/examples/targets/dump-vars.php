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

echo '<fieldset><legend>$_POST</legend><pre>';
if ( isset($_POST ) && !empty( $_POST ) ){
    print_r( $_POST );
} else {
    echo 'Not set or empty';
}
echo '</pre></fieldset>';

echo '<fieldset><legend>$_GET</legend><pre>';
if ( isset( $_GET ) && !empty( $_GET ) ){
    print_r( $_GET );
} else {
    echo 'Not set or empty';
}
echo '</pre></fieldset>';

echo '<fieldset><legend>$_COOKIE</legend><pre>';
if ( isset( $_COOKIE ) && !empty( $_COOKIE ) ){
    print_r( $_COOKIE );
} else {
    echo 'Not set or empty';
}
echo '</pre></fieldset>';

echo '<fieldset><legend>$_SESSION</legend><pre>';
if ( isset($_SESSION ) && !empty($_SESSION ) ){
    print_r( $_SESSION );
} else {
    echo 'Not set or empty';
}
echo '</pre></fieldset>';
