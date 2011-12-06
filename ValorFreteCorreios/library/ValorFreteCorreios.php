<?php

/**
 * @package         ValorFreteCorreios  
 * @author          Emerson Rocha Luiz ( emerson@webdesign.eng.br - @fititnt -  http://fititnt.org )
 * @copyright       Copyright (C) 2005 - 2011 Webdesign Assessoria em Tecnologia da Informacao.
 * @license         WTFPLv2 ( http://sam.zoy.org/wtfpl )
 * @version         0.5beta1 (2011-08-23)
 */
class ValorFreteCorreios {

    /** Seu código administrativo junto à ECT. O código está disponível no corpo 
     * do contrato firmado com os Correios.
     * 
     * Exigido: Não, mas o parâmetro tem que ser passado mesmo vazio.
     * 
     * @var String    
     */
    private $nCdEmpresa = '';

    /**
     * Senha para acesso ao serviço, associada ao seu código administrativo. A 
     * senha inicial corresponde aos 8 primeiros dígitos do CNPJ informado no 
     * contrato. A qualquer momento, é possível alterar a senha no endereço 
     * http://www.corporativo.correios.com.br/encomendas/servicosonline/recuperaSenha
     * 
     * Exigido: Não, mas o parâmetro tem que ser passado mesmo vazio.
     * 
     * @var String    
     */
    private $sDsSenha = '';

    /**
     * Código do serviço 
     * Código       Serviço
     * 41106        PAC sem contrato
     * 40010        SEDEX sem contrato
     * 40045        SEDEX a Cobrar, sem contrato
     * 40126        SEDEX a Cobrar, com contrato
     * 40215        SEDEX 10, sem contrato
     * 40290        SEDEX Hoje, sem contrato
     * 40096        SEDEX com contrato
     * 40436        SEDEX com contrato
     * 40444        SEDEX com contrato
     * 81019        e-SEDEX, com contrato
     * 41068        PAC com contrato
     * 40568        SEDEX com contrato
     * 40606        SEDEX com contrato
     * 81868        (Grupo 1) e-SEDEX, com contrato
     * 81833        (Grupo 2) e-SEDEX, com contrato
     * 81850        (Grupo 3) e-SEDEX, com contrato
     * 
     * Exigido: Sim. Pode ser mais de um numa consulta separados por vírgula.
     * 
     * @var String    
     */
    private $nCdServico = '41106,40010';

    /**
     * CEP de Origem sem hífen Exemplo: 05311900
     * 
     * Exigido: Sim
     * 
     * var      string     
     */
    private $sCepDestino;

    /**
     * Peso da encomenda, incluindo sua embalagem. O peso deve ser informado em 
     * quilogramas.
     * 
     * Exigido: Sim
     * 
     * @var string     
     */
    private $nVlPeso = 1;

    /**
     * PFormato da encomenda (incluindo embalagem).
     * Valores possíveis: 1 ou 2
     * 1 – Formato caixa/pacote
     * 2 – Formato rolo/prisma
     * 
     * Exigido: Sim
     * 
     * @var      Int     
     */
    private $nCdFormato = 1;

    /**
     * Comprimento da encomenda (incluindo embalagem), em centímetros.
     * 
     * Exigido: Sim
     * 
     * @var      Decimal     
     */
    private $nVlComprimento = 33; //Valor maximo, por padrao

    /**
     * Altura da encomenda (incluindo embalagem), em centímetros.
     * 
     * Exigido: Sim
     * 
     * var      Decimal     
     */
    private $nVlAltura = 22; //Valor maximo, por padrao

    /**
     * Largura da encomenda (incluindo embalagem), em centímetros.
     * 
     * Exigido: Sim
     * 
     * @var      Decimal     
     */
    private $nVlLargura = 33; //Valor maximo, por padrao

    /**
     * Diâmetro da encomenda (incluindo embalagem), em centímetros.
     * 
     * Exigido: Sim
     * 
     * @var      Decimal     
     */
    private $nVlDiametro;

    /**
     * Indica se a encomenda será entregue com o serviço adicional mão própria.
     * Valores possíveis: S ou N (S – Sim, N – Não)
     * 
     * Exigido: Sim
     * 
     * var      String     
     */
    private $sCdMaoPropria = 'N';

    /**
     * Indica se a encomenda será entregue com o serviço adicional valor 
     * declarado. Neste campo deve ser apresentado o valor declarado desejado, 
     * em Reais.
     * 
     * Exigido: Sim. Se não optar pelo serviço informar zero.
     * 
     * @var      Decimal     
     */
    private $nVlValorDeclarado = 0;

    /**
     * Indica se a encomenda será entregue com o serviço adicional aviso de 
     * recebimento.
     * Valores possíveis: S ou N (S – Sim, N – Não)
     * 
     * Exigido: Sim.Se não optar pelo serviço informar 'N'
     * 
     * var      string     
     */
    private $sCdAvisoRecebimento = 'N';

    /**
     * Tipo de retorn
     * Indica a forma de retorno da consulta.
     * XML - Resultado em XML
     * Popup - Resultado em uma janela popup
     * <URL> * Resultado via post em uma página do requisitante
     * 
     * Exigido: Sim.
     * 
     * @var String    
     */
    private $StrRetorno = 'XML';

    /*
     * Resultado bruto da pagina dos correios
     * 
     * @param String     
     */
    private $resultado = NULL;

    function __contruct() {
        
    }

    /**
     *  Metodo para exibir em formaso JSON
     * 
     * @param String $type: mime-type a ser retornado.    
     * @return Object $this
     */
    public function json($type = NULL) {
        if ($type == NULL) {
            $type = 'json';
        }
        $this->_sendHeader($type);
        $this->StrRetorno = 'XML';
        $resultado = $this->_correio();
        echo json_encode($resultado);
        return $this;
    }

    /**
     * Metodo para exibir em formato XML
     *
     * @param String $type: mime-type a ser retornado.    
     * @return       object      $this
     */
    public function xml($type = NULL) {
        if ($type == NULL) {
            $type = 'xml';
        }

        $this->_sendHeader($type);
        $this->StrRetorno = 'XML';
        $resultado = $this->_correio();
        echo $this->resultado;
        return $this;
    }

    /**
     * Metodo para retornar o objeto resultante
     *   
     * @return Object $objeto
     */
    public function objeto() {
        $this->StrRetorno = 'XML';
        $objeto = $this->_correio();
        return $objeto;
    }

    /**
     * @param string $name: name of var
     * @param mixed $value: value of var
     * @return object $this
     */
    public function set($name, $value) {
        $this->$name = $value;
        return $this;
    }

    /**
     * @param String $name: name of var
     * @return Object $this
     */
    public function del($name) {
        $this->$name = NULL;
        return $this;
    }

    /**
     * CEP de origem. Apenas numeros
     * 
     * @param string          $name: name of var
     * 
     * return       object          $this
     */
    public function origem($value) {
        $this->sCepOrigem = $value;
        return $this;
    }

    /**
     * CEP de destino. Apenas numeros
     * 
     * @param String $name: name of var
     * 
     * @return Object $this
     */
    public function destino($value) {
        $this->sCepDestino = $value;
        return $this;
    }

    /**
     * CEP de destino. Apenas numeros
     * 
     * @param string $name: name of var
     * @return object $this
     */
    public function peso($value) {
        $this->nVlPeso = $value;
        return $this;
    }

    /**
     * Numero do servico
     * 
     * @param string $name: name of var
     * @return object $this
     */
    public function servico($value) {
        $this->nCdServico = $value;
        return $this;
    }

    /**
     * Send header of document
     * @see http://www.ietf.org/rfc/rfc4627.txt
     * 
     * @return       void
     */
    private function _sendHeader($type) {
        switch ((string) $type) {
            case 'xml':
                header('Content-type: text/xml');
                break;
            case 'json':
                header('Content-type: application/json');
            default:
                header('Content-type: ' . $type);
        }
        header('Pragma: no-cache');
    }

    /**
     * Send header of document
     * @see http://www.ietf.org/rfc/rfc4627.txt
     * 
     * @return       void
     */
    private function _correio() {
        $queries = array('nCdEmpresa' => $this->nCdEmpresa,
            'sDsSenha' => $this->sDsSenha,
            'nCdServico' => $this->nCdServico,
            'sCepOrigem' => $this->sCepOrigem,
            'sCepDestino' => $this->sCepDestino,
            'nVlPeso' => $this->nVlPeso,
            'nCdFormato' => $this->nCdFormato,
            'nVlComprimento' => $this->nVlComprimento,
            'nVlAltura' => $this->nVlAltura,
            'nVlLargura' => $this->nVlLargura,
            'nVlDiametro' => $this->nVlDiametro,
            'sCdMaoPropria' => $this->sCdMaoPropria,
            'nVlValorDeclarado' => $this->nVlValorDeclarado,
            'sCdAvisoRecebimento' => $this->sCdAvisoRecebimento,
            'StrRetorno' => $this->StrRetorno
        );
        $urlQuerie = http_build_query($queries, '', '&'); //Usa ;& como separador
        $url = 'http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx?' . $urlQuerie;
        $this->resultado = $this->_getPageContent($url);

        $xml = new SimpleXMLElement($this->resultado); //@todo: Checar se SimpleXML e mesmo o meio mais eficiente de fazer isso

        return $xml;
    }

    /**
     * Get external URL
     * Check best way to load one URL, and return it
     * 
     * @todo: tratar um erro que acontece quando a pagina dos correios esta indisponivel
     * 
     * @param String $url: url to import
     * @return String
     * 
     */
    private function _getPageContent($url) {

        if (!function_exists('curl_init')) {
            $c = curl_init();
            curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($c, CURLOPT_URL, $url);
            $page = curl_exec($c);
            curl_close($c);
        } else {
            $page = file_get_contents($url);
        } //@todo: maybe add later fopen(), file()...

        return $page;
    }

}