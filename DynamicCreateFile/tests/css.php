<?php
/*
 * @package         DynamicFileCreate
 * @subpackage      Test files
 * @author          Emerson Rocha Luiz ( emerson@webdesign.eng.br - @fititnt -  http://fititnt.org )
 * @copyright       Copyright (C) 2005 - 2011 Webdesign Assessoria em Tecnologia da Informacao.
 * @license         GPL3
 */


//Tip: AWAYLS check user input to avoid XSS atacks! One PHP switch case could help you with this task
if (isset($_GET['width'])) {
    switch($_GET['width']){
        case 1200:
            $width = 1200;
            break;
        case 420:
            $width = 420;
            break;
        case 960:
        default:
            $width = 960;
    }
} else {
    $width = 960;
}

$css =<<<CSS
#main{
    width: $width;
}
CSS;


//Include Library
include_once '../library/DynamicCreateFile.php';
$dcf = new DynamicCreateFile;//Fluent Interface!
$dcf->content( $css )->type('css')->show();
/*
Result for url /tests/css.php?width=1200:
#main{
    width: 1200;
}
Result for url /tests/css.php?width=1201:
#main{
    width: 960;
}
Result for url /tests/css.php
#main{
    width: 960;
}
 */



//@todo: solve next command
//$dcf->content( $css )->path( dirname(__FILE__) )->name('test.css')->type('css')->save();