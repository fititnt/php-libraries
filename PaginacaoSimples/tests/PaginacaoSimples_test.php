<?php
/*
 * @package         PaginacaoSimples
 * @subpackage      Test files
 * @author          Emerson Rocha Luiz ( emerson@webdesign.eng.br - @fititnt -  http://fititnt.org )
 * @copyright       Copyright (C) 2005 - 2011 Webdesign Assessoria em Tecnologia da Informacao.
 * @license         GPL3
 */

include_once '../library/PaginacaoSimples.php';
$pags = new PaginacaoSimples;

$params = array('startvar' => 'start',
                'show' => 1
                );

$start = isset($_GET['start']) ? (int) $_GET['start'] : 0 ;


$pagination = $pags->total(300)->limit(10)->start( $start )->url('http://localhost/app/PaginacaoSimples/tests/PaginacaoSimples_test.php?')->getHtml( $params );
?>
<div class="example">
    <p>Here your list with querie like:</p>
    <pre>
    <?php echo 'SELECT * FROM #__table LIMIT ' . $pags->get('datastart'). ', '. $pags->get('dataend'). ';'; ?>
    </pre>
</div>
<?php echo $pagination; ?>





<h2>Final objective is like</h2>
<style>
/* Just for this test file. This CSS in real world must be in a external file */
div.example{
    width: 350px;
    margin: 0 auto;
}
div.pagination ul, p.counter {
    text-align: center;
}
div.pagination ul li {
    list-style-type: none;
    display: inline;
}
</style>
<div class="pagination">
    <p class="counter"> Pagina 1 de 10 </p> 
    <ul>
        <li class="pagination-start"><span class="pagenav">Inicio</span></li>
        <li class="pagination-prev"><span class="pagenav">Anterior</span></li>
        <li><span class="pagenav">1</span></li>
        <li><a href="/index.php?start=7" class="pagenav">2</a></li>
        <li><a href="/index.php?start=14" class="pagenav">3</a></li>
        <li><a href="/index.php?start=21" class="pagenav">4</a></li>
        <li><a href="/index.php?start=28" class="pagenav">5</a></li>
        <li><a href="/index.php?start=35" class="pagenav">6</a></li>
        <li><a href="/index.php?start=42" class="pagenav">7</a></li>
        <li><a href="/index.php?start=49" class="pagenav">8</a></li>
        <li><a href="/index.php?start=56" class="pagenav">9</a></li>
        <li><a href="/index.php?start=63" class="pagenav">10</a></li>
        <li class="pagination-next"><a title="Próx" href="/index.php?start=7" class="pagenav">Pr&oacute;ximo</a></li>
        <li class="pagination-end"><a title="Fim" href="/index.php?start=63" class="pagenav">Fim</a></li>
    </ul>	
</div>