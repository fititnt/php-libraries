<?php

/*
 * Funcao para resolver adicao de horas
 * Deve existir um meio mais decente de fazer isso
 */
function somaHora($hora, $valor, $comZero = FALSE)
{
	$resultado = $hora + $valor;
	if ($resultado < 0)
	{
		$resultado = 24 - abs($resultado);
	}
	if ($resultado > 24)
	{
		$resultado = abs($resultado) - 24;
	}
	if ($comZero && $resultado < 10)
	{
		$resultado = '0'.$resultado;
	}
	
	return $resultado;
}
echo somaHora( 02, -3 ); //Imprime 23