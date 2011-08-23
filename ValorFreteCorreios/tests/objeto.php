<?php
/*
 * @package         ValorFreteCorreios
 * @subpackage      
 * @author          Emerson Rocha Luiz ( emerson@webdesign.eng.br - @fititnt -  http://fititnt.org )
 * @copyright       Copyright (C) 2005 - 2011 Webdesign Assessoria em Tecnologia da Informacao.
 * @license         WTFPLv2 ( http://sam.zoy.org/wtfpl )
 * @version         0.5beta1 (2011-08-23)
 */

//Include Library
include_once '../library/ValorFreteCorreios.php';
$correio = new ValorFreteCorreios;

$resultado = $correio->origem( '90650000' )->destino( '86010060' )->objeto(); //Retorna um objeto

var_dump($resultado);