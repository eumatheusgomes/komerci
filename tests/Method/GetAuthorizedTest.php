<?php
namespace EuMatheusGomes\Komerci\Test\Method;

use EuMatheusGomes\Komerci\KomerciClient;
use EuMatheusGomes\Komerci\Method\GetAuthorized;
use EuMatheusGomes\Komerci\Test\Stub\SoapClientStub;

class GetAuthorizedTest extends \PHPUnit_Framework_TestCase
{
    protected $getAuthorized;

    protected function setUp()
    {
        $komerciClient = new KomerciClient();
        $soapClientStub = new SoapClientStub($komerciClient->getUrl());

        $this->getAuthorized = new GetAuthorized($komerciClient, $soapClientStub);
    }

    /**
     * @expectedException BadMethodCallException
     */
    public function testInvalidSetterMethod()
    {
        $this->getAuthorized->invalidMethodName();
    }

    /**
     * @expectedException BadMethodCallException
     */
    public function testInvalidAttributeNameForSetterMethod()
    {
        $this->getAuthorized->setInvalidAttr();
    }

    /**
     * @expectedException InvalidArgumentException
     * @dataProvider validAttrNameProvider
     */
    public function testSetterMethodWithoutArgs($validAttrName)
    {
        $this->getAuthorized->{"set{$validAttrName}"}();
    }

    /**
     * @dataProvider validAttrNameProvider
     */
    public function testSetterMethodReturnSelf($validAttrName)
    {
        $this->assertSame(
            $this->getAuthorized ,
            $this->getAuthorized->{"set{$validAttrName}"}('any value')
        );
    }

    public function testReturnsSimpleXMLElement()
    {
    }

    public function testGetAuthorizedCallInProdMode()
    {
    }

    public function testGetAuthorizedTstCallInDevMode()
    {
    }

    public function testApprovedMethodResponse()
    {
    }

    public function testNotApprovedMethodResponse()
    {
    }

    public function validAttrNameProvider()
    {
        return [
            ['Total'],
            ['Transacao'],
            ['Parcelas'],
            ['Filiacao'],
            ['NumPedido'],
            ['Nrcartao'],
            ['CVC2'],
            ['Mes'],
            ['Ano'],
            ['Portador'],
            ['ConfTxn'],
            ['IATA'],
            ['Distribuidor'],
            ['Concentrador'],
            ['TaxaEmbarque'],
            ['Entrada'],
            ['Pax1'],
            ['Pax2'],
            ['Pax3'],
            ['Pax4'],
            ['Numdoc1'],
            ['Numdoc2'],
            ['Numdoc3'],
            ['Numdoc4'],
            ['AddData']
        ];
    }
}

