<?php
namespace EuMatheusGomes\Komerci\Method;

abstract class AbstractMethod
{
    protected $_komerciClient;
    protected $_soapClient;

    protected $options;
    protected $method;
    protected $resultNodeName;

    public function __construct(
        \EuMatheusGomes\Komerci\KomerciClient $komerciClient,
        \SoapClient $soapClient
    ) {
        $this->_komerciClient = $komerciClient;
        $this->_soapClient = $soapClient;
    }

    public function call()
    {
        if ($this->_komerciClient->getMode() == 'dev') {
            $this->method .= 'Tst';
            $this->resultNodeName = str_replace('Result', 'TstResult', $this->resultNodeName);
        }

        $response = $this->_soapClient->{$this->method}($this->options);
        return simplexml_load_string($response->{$this->resultNodeName}->any);
    }

    public function __call($method, $args)
    {
        if (strpos($method, 'set') === false) {
            throw new \BadMethodCallException('Invalid method name: ' . $method);
        }

        $attr = str_replace('set', '', $method);

        if (!in_array($attr, array_keys($this->options))) {
            throw new \BadMethodCallException('Invalid attribute name: ' . $attr);
        }

        if (!is_array($args) || count($args) == 0) {
            throw new \InvalidArgumentException('Missing method arguments: ' . $method);
        }

        $this->options[$attr] = $args[0];
        return $this;
    }

    abstract public function approved($response);
}
