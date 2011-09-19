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
    private $porPagina = 10;

    /*
     *
     * var      int
     */
    private $contagemAtual = 0;

    /*
     *
     * var      int
     */
    private $limiteInicial = 0;

/*
     *
     * var      int
     */
    private $limiteFinal = 0;

    /*
     *
     * var      int
     */
    private $exibirPaginacao = 0;


    
    
    function __contruct()
    {
        
    }

    /*
     *  @var        int          $valor:
     *
     * return       object      $this
     */
    public function porpagina( $valor )
    {
        $this->porPagina = $valor;
        return $this;
    }

    /*
     *  @var        int          $valor:
     *
     * return       object      $this
     */
    public function contagematual( $valor )
    {
        $this->contagemAtual = $valor;
        return $this;
    }

    /*  Method to show on page
     *  @var        string          $name: name of var
     * 
     * return       object      $this
     */
    public function calcula( )
    {
        if($this->total <= $this->porPagina){
            $this->exibirPaginacao = 0;//So pra garantir
        } else {
            $this->exibirPaginacao = 1;

            if( $this->contagemAtual < $this->porPagina ){
                $this->limiteInicial = 0;
                $this->limiteFinal = $this->porPagina;
            } else {
                $this->contagemAtual >= $this->total;
            }
        }

        //$this->limiteInicial = ($this->contagemAtual: $this->contagemAtual ? 0);
        $limiteFinal = $this->limiteInicial + $this->porPagina;
        if ($limiteFinal > $this->total){
            $this->limiteFinal = $this->total;
        } else {
            $this->limiteFinal = $limiteFinal;
        }


        return $this;
    }


    private function _checaConsistencia()
    {
        if ($this->contagemAtual >= $this->total ){
            return FALSE;
        }
        //return $this
    }
    
}