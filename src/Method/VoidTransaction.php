<?php
namespace EuMatheusGomes\Komerci\Method;

use EuMatheusGomes\Komerci\Method\AbstractMethod;

class VoidTransaction extends AbstractMethod
{
    protected $options = [
        'Total' => '',
        'Filiacao' => '',
        'NumCV' => '',
        'NumAutor' => '',
        'Concentrador' => '',
        'Usr' => '',
        'Pwd' => ''
    ];

    public function __construct(
        \EuMatheusGomes\Komerci\KomerciClient $komerciClient,
        \SoapClient $soapClient
    ) {
        parent::__construct($komerciClient, $soapClient);

        $this->method = 'VoidTransaction';
        $this->resultNodeName = 'VoidTransactionResult';

        $this->options['Filiacao'] = $komerciClient->getFiliacao();
        $this->options['Usr'] = $komerciClient->getUsr();
        $this->options['Pwd'] = $komerciClient->getPwd();
    }

    public function approved($response)
    {
        if ((int) $resposta->codret === 0) {
            return true;
        }

        return false;
    }
}
