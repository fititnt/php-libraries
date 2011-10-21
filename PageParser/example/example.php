<?php
/*
 * @package         PageParser
 * @author          Emerson Rocha Luiz - emerson at webdesign.eng.br - http://fititnt.org
 * @copyright       Copyright (C) 2011 Webdesign Assessoria em Tecniligia da Informacao. All rights reserved.
 * @license         GNU General Public License version 3. See license-gpl3.txt
 * @license         Massachusetts Institute of Technology. See license-mit.txt
 * @version         0.1alpha
 * 
 */

include_once '../library/PageParser.php';

$pp = new PageParser();

$page = <<<EOT
<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Title of Page</title>
</head>
<body>
    <div id="header">
        <h1>H1 Title of page</h1>
        <span id="exampleid">Content of id exampleid (©, ã, ç ...)</span>
    </div>    
    <div class="article">
        <h2>Sub title one</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis non 
            libero ligula, eu elementum tortor. Aliquam mollis pulvinar tortor quis 
            dignissim.</p>
            <div class="exampleclass">One content of exampleclass</div>
        <h2>Sub title one</h2>
            <p>Aliquam erat volutpat. Sed ipsum tortor, consequat tincidunt porta sed, 
            pulvinar sit amet lectus. Morbi sapien ante, posuere in ullamcorper sit 
            amet, commodo nec urna.</p>
            <div class="exampleclass">One more example content of exampleclass</div>
    </div>
    <div id="footer">
        Check validation <a href="http://html5.validator.nu/">HTML5</a> and 
        <a href="http://jigsaw.w3.org/css-validator/#validate_by_uri">CSS3</a>
    </div>
</body>
</html>
EOT;

echo '<pre>' . htmlspecialchars($page) . '</pre>';

echo "\n" . 'ppId: ';

echo $pp->setPage($page)->ppId('exampleid');

