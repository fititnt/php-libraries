<?php
/*
 * @package         DynamicFileCreate
 * @subpackage      
 * @author          Emerson Rocha Luiz ( emerson@webdesign.eng.br - @fititnt -  http://fititnt.org )
 * @copyright       Copyright (C) 2005 - 2011 Webdesign Assessoria em Tecnologia da Informacao.
 * @license         GPL3
 * @version         0.5beta1 (2011-14-08)
 */


class PaginacaoSimples { 
    
    /*
     * 
     * var      int
     */
    private $total;

    /*
     *
     * var      int
     */
    private $limit = 10;

    /*
     *  First Value to show
     *
     * var      int
     */
    private $start = 1;

    /* Last value to show
     *
     * var      int
     */
    private $end = NULL;
    
    /* Fist value to show
     *
     * var      int
     */
    private $datastart = NULL;
    
    /* Last value to show
     *
     * var      int
     */
    private $dataend = NULL;

    /*
     *
     * var      int
     */
    private $url = NULL;
    
    /*
     *
     * var      int
     */
    private $params = array();
    
    /* Contem o objeto e todos os valores usados para montar a query
     * $objeto->
     * 
     *
     * var      object
     */
    private $objeto = 0;


    /*
     * This construct have a few defaul values for brazilian portuguese
     * You can change it here or just use $params to overide on functions
     */
   function __construct()
    {
        $this->params['startvar'] = 'start';
        $this->params['show'] = 0 ; //Mostrar mesmo que for desnecessaria?
        $this->params['text-start'] = 'Inicio';
        $this->params['text-before'] = 'Anterior';
        $this->params['text-next'] = 'Pr&oacute;ximo';
        $this->params['text-end'] = 'Fim';
        $this->params['text-page'] = 'P&aacute;gina';
        $this->params['text-of'] = 'de';
    } 
    
    /*
     *  @var        int          $valor:
     *
     * return       object      $this
     */
    public function total( $valor )
    {
        $this->total = $valor;
        return $this;
    }

    /*
     *  @var        int          $valor:
     *
     * return       object      $this
     */
    public function limit( $valor )
    {
        $this->limit = $valor;
        return $this;
    }

    /*
     *  @var        int          $valor:
     *
     * return       object      $this
     */
    public function start( $valor  = NULL)
    {
        if ( $valor )
        {
            $this->start = $valor;
        }        
        return $this;
    }
    
    /*
     *  @var        string          $valor:
     *
     * return       object          $this
     */
    public function url( $valor )
    {
        $this->url = $valor;
        return $this;
    }
    
    /*
     * Return private var
     * 
     * @var        string          $name: name of var to return
     *
     * return       mixed          $this
     */
    public function get( $name )
    {
        return $this->$name;
    }

    /*  Method to calc the object
     *  Is public because, if you really need call this function, do it
     *  Can be useful if you do not need generate the HTML output, but want
     *  just the object 
     *  @var        string          $name: name of var
     * 
     * return       object      $this
     */
    public function calc( )
    {
        if( $this->total > $this->limit || isset($this->params['show']) )
        {            
            
            $pages = ceil($this->total / $this->limit); //Numero de paginas
            
            $pageCurrent = $this->start;
            
            $pageBefore = $pageCurrent - 1; //Pode retornar zero
            $pageNext = $pageCurrent == $pages ? 0 : $pageCurrent + 1;

            if ($pages > 10){
                if ($pageCurrent > 5){
                    if ( $pageCurrent <= ($pages - 5) ){
                        $pageStart = $pageCurrent - 5;
                        $pageEnd = $pageCurrent + 5;
                    } else {
                        $pageStart = $pages - 10;
                        $pageEnd = $pages;
                    }
                } else {
                    $pageStart = 0;
                    $pageEnd = 9;
                }                
            } else {
                $pageStart = 1;
                $pageEnd = $pages;
            }
        }
        
        $pag = new stdClass();
        
        $pag->url = $this->url . $this->params['startvar'] . '=' ; // Maybe problem here. Depents of base URL
        $pag->current = $pageCurrent;
        $pag->start = $pageStart;
        $pag->end = $pageEnd;
        $pag->before = $pageBefore;
        $pag->next = $pageNext;
        $pag->npages = $pages;
        $pag->pages = array();
        for( $i=$pageStart; $i<$pageEnd;  ){
            $pag->pages[]= ++$i;
        }
        $this->objeto = $pag;
        
        //Data start and end
        $this->datastart = ($pageCurrent * $this->limit) - $this->limit;//O know...
        if($this->datastart < $this->total){
            $this->dataend = $this->datastart + $this->limit;
        } else {
            $this->dataend = $this->total;
        }
        //Overide limit start if is not equals to zero. Must be  + 1
        //Maybe have a better way to do it. I hope.
        if ($this->datastart !== 0){
            ++$this->datastart;
        }
        
        
        return $this;
    }
    
    /*
     * Generate HTML of pagination to output
     * A bit hardcoded. Who cares?
     * 
     * @var         array       $params: Aditional params
     * 
     * @return      string      $pagination: string with HTML to output 
     */    
    public function getHtml( $params = NULL)
    {
        if ($params !== NULL)
        {
            if ( isset($params['startvar']) )
            {
                $this->params['startvar'] = $params['startvar'];
            }
            if ( isset($params['show']) )
            {
                $this->params['show'] = 1;
            }
            if ( isset($params['text-start']) )
            {
                $this->params['text-start'] = $params['text-start'];
            }
            if ( isset($params['text-before']) )
            {
                $this->params['text-before'] = $params['text-before'];
            }
            if ( isset($params['text-next']) )
            {
                $this->params['text-next'] = $params['text-next'];
            }
            if ( isset($params['text-end']) )
            {
                $this->params['text-end'] = $params['text-end'];
            }
            if ( isset($params['text-page']) )
            {
                $this->params['text-page'] = $params['text-page'];
            }
            if ( isset($params['text-of']) )
            {
                $this->params['text-of'] = $params['text-of'];
            }
        }
        $this->calc();
        $pag = $this->objeto; 
        
        $pagination = "\n";
        $pagination .= '<div class="pagination">'."\n";
        $pagination .= "\t".'<p class="counter"> ' . $this->params['text-page'] . ' '. $pag->current. ' '.$this->params['text-of'].' '.$pag->npages.' </p>'."\n";
        $pagination .= "\t".'<ul>'."\n";
        if ($pag->before){
            $pagination .= "\t\t".'<li class="pagination-start"><a href="'.$pag->url . '1' . '" class="pagenav">'.$this->params['text-start'].'</a></li>'."\n";        
            $pagination .= "\t\t".'<li class="pagination-prev"><a href="'.$pag->url . $pag->before . '" class="pagenav">'.$this->params['text-before'].'</a></li>'."\n";
        } else {
            $pagination .= "\t\t".'<li class="pagination-start"><span class="pagenav">'.$this->params['text-start'].'</span></li>'."\n";        
            $pagination .= "\t\t".'<li class="pagination-prev"><span class="pagenav">'.$this->params['text-before'].'</span></li>'."\n";
        }
        foreach($pag->pages AS $item){
            $pagination .= "\t\t".'<li><a href="'.$pag->url . $item . '" class="pagenav">' .$item . '</a></li>'."\n";
        }
        if ($pag->next){
            $pagination .= "\t\t".'<li class="pagination-next"><a href="'.$pag->url . $pag->next . '" class="pagenav">'.$this->params['text-next'].'</a></li>'."\n";
            $pagination .= "\t\t".'<li class="pagination-end"><a href="'.$pag->url . $pag->npages . '" class="pagenav">'.$this->params['text-end'].'</a></li>'."\n";
        } else {
            $pagination .= "\t\t".'<li class="pagination-next"><span class="pagenav">'.$this->params['text-next'].'</span></li>'."\n";
            $pagination .= "\t\t".'<li class="pagination-end"><span class="pagenav">'.$this->params['text-end'].'</span></li>'."\n";
        }
        $pagination .= "\t".'</ul>';
        $pagination .= '</div>'."\n";
        
        return $pagination;
    }    
}