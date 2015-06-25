<?php
namespace EuMatheusGomes\Komerci\Method;

use EuMatheusGomes\Komerci\Method\AbstractMethod;

class GetAuthorized extends AbstractMethod
{
    protected $options = [
        'Total'        => '',
        'Transacao'    => '',
        'Parcelas'     => '',
        'Filiacao'     => '',
        'NumPedido'    => '',
        'Nrcartao'     => '',
        'CVC2'         => '',
        'Mes'          => '',
        'Ano'          => '',
        'Portador'     => '',
        'ConfTxn'      => '',
        'IATA'         => '',
        'Distribuidor' => '',
        'Concentrador' => '',
        'TaxaEmbarque' => '',
        'Entrada'      => '',
        'Pax1'         => '',
        'Pax2'         => '',
        'Pax3'         => '',
        'Pax4'         => '',
        'Numdoc1'      => '',
        'Numdoc2'      => '',
        'Numdoc3'      => '',
        'Numdoc4'      => '',
        'AddData'      => ''
    ];

    public function __construct(
        \EuMatheusGomes\Komerci\KomerciClient $komerciClient,
        \SoapClient $soapClient
    ) {
        parent::__construct($komerciClient, $soapClient);

        $this->method = 'GetAuthorized';
        $this->resultNodeName = 'GetAuthorizedResult';

        $this->options['Filiacao'] = $komerciClient->getFiliacao();
    }

    public function approved($response)
    {
        if ((int) $response->CODRET === 0 && (string) trim($response->NUMCV) !== '') {
            return true;
        }

        return false;
    }
}
