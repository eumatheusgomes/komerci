<?php
namespace EuMatheusGomes\Komerci;

class KomerciClient
{
    const WSURL = 'https://ecommerce.userede.com.br/pos_virtual/wskomerci/cap.asmx';
    const WSURL_TESTE = 'https://ecommerce.userede.com.br/pos_virtual/wskomerci/cap_teste.asmx';

    const TRANSACAO_AVISTA = '04';
    const TRANSACAO_PARCELADO_EMISSOR = '06';
    const TRANSACAO_PARCELADO_ESTABELECIMENTO = '08';
    const TRANSACAO_IATA_AVISTA = '39';
    const TRANSACAO_IATA_PARCELADO = '40';
    const TRANSACAO_PRE_AUTORIZACAO = '73';

    private $mode;
    private $filiacao;
    private $url;

    private $usr;
    private $pwd;

    public function __construct(
        $mode = 'dev',
        $filiacao = '999999999',
        $usr = 'usr',
        $pwd = 'pwd'
    ) {
        $this->mode = $mode;
        $this->filiacao = $filiacao;
        $this->usr = $usr;
        $this->pwd = $pwd;

        if ($this->mode == 'dev') {
            ini_set('soap.wsdl_cache_enabled', '0');
            $this->url = self::WSURL_TESTE;
        } else {
            $this->url = self::WSURL;
        }
    }

    public function getMode()
    {
        return $this->mode;
    }

    public function getFiliacao()
    {
        return $this->filiacao;
    }

    public function getUrl()
    {
        return $this->url . '?WSDL';
    }

    public function getUsr()
    {
        return $this->usr;
    }

    public function getPwd()
    {
        return $this->pwd;
    }
}
