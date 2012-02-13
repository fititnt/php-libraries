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

include_once '../../WebDig/library/WebDig.php';

$pp = new PageParser();
$wd = new WebDig(); 

$page = $wd->setTarget("http://maujor.com/w3ctuto/firstcss.html")->dig( TRUE );
echo $pp->setPage($page)->ppId('p5');

//@todo:
//$page = $wd->setUrl("http://www4.bcb.gov.br/pec/taxas/batch/taxas.asp?id=txdolar")->dig( TRUE );
//echo $pp->setPage($page)->ppId('salto')->nodeValue;

//$page = $wd->setUrl("http://fititnt.org/contato2.html")->dig( TRUE );
//echo $pp->setPage($page)->ppId('rodape-alpha')->nodeValue;
