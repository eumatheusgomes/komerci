<?php
namespace EuMatheusGomes\Komerci\Test\Method;

use EuMatheusGomes\Komerci\KomerciClient;
use EuMatheusGomes\Komerci\Method\GetAuthorized;

class GetAuthorizedTest extends \PHPUnit_Framework_TestCase
{
    protected $_komerciClient;
    protected $_soapClientMock;

    protected function setUp()
    {
        $this->_komerciClient = new KomerciClient();

        $this->_soapClientMock = $this->getMockBuilder('SoapClient')
            ->disableOriginalConstructor()
            ->setMethods(array('GetAuthorized', 'GetAuthorizedTst'))
            ->getMock();
    }

    /**
     * @expectedException BadMethodCallException
     */
    public function testInvalidSetterMethod()
    {
        $getAuthorized = new GetAuthorized($this->_komerciClient, $this->_soapClientMock);
        $getAuthorized->invalidMethodName();
    }

    /**
     * @expectedException BadMethodCallException
     */
    public function testInvalidAttributeNameForSetterMethod()
    {
        $getAuthorized = new GetAuthorized($this->_komerciClient, $this->_soapClientMock);
        $getAuthorized->setInvalidAttr();
    }

    /**
     * @expectedException InvalidArgumentException
     * @dataProvider validAttrNameProvider
     */
    public function testSetterMethodWithoutArgs($validAttrName)
    {
        $getAuthorized = new GetAuthorized($this->_komerciClient, $this->_soapClientMock);
        $getAuthorized->{"set{$validAttrName}"}();
    }

    /**
     * @dataProvider validAttrNameProvider
     */
    public function testSetterMethodReturnSelf($validAttrName)
    {
        $getAuthorized = new GetAuthorized($this->_komerciClient, $this->_soapClientMock);

        $this->assertSame(
            $getAuthorized,
            $getAuthorized->{"set{$validAttrName}"}('any value')
        );
    }

    public function testGetAuthorizedTstCallInDevMode()
    {
        $response = new \StdClass;
        $response->GetAuthorizedTstResult = new \StdClass;
        $response->GetAuthorizedTstResult->any = '<any_valid_xml></any_valid_xml>';

        $this->_soapClientMock->expects($this->once())
            ->method('GetAuthorizedTst')
            ->will($this->returnValue($response));

        $getAuthorized = new GetAuthorized($this->_komerciClient, $this->_soapClientMock);
        $getAuthorized->call();
    }

    public function testGetAuthorizedCallInProdMode()
    {
        $response = new \StdClass;
        $response->GetAuthorizedResult = new \StdClass;
        $response->GetAuthorizedResult->any = '<any_valid_xml></any_valid_xml>';

        $this->_soapClientMock->expects($this->once())
            ->method('GetAuthorized')
            ->will($this->returnValue($response));

        $komerciClient = new KomerciClient('prod');
        $getAuthorized = new GetAuthorized($komerciClient, $this->_soapClientMock);

        $getAuthorized->call();
    }

    public function testReturnsSimpleXMLElement()
    {
        $response = new \StdClass;
        $response->GetAuthorizedTstResult = new \StdClass;
        $response->GetAuthorizedTstResult->any = '<any_valid_xml></any_valid_xml>';

        $this->_soapClientMock->expects($this->once())
            ->method('GetAuthorizedTst')
            ->will($this->returnValue($response));

        $getAuthorized = new GetAuthorized($this->_komerciClient, $this->_soapClientMock);

        $this->assertEquals('SimpleXMLElement', get_class($getAuthorized->call()));
    }

    public function testApprovedMethodResponse()
    {
        $zero = 0;
        $notEmptyString = 'not empty string';
        $responseXml = "<AUTHORIZATION><CODRET>{$zero}</CODRET><NUMCV>{$notEmptyString}</NUMCV></AUTHORIZATION>";

        $response = new \StdClass;
        $response->GetAuthorizedTstResult = new \StdClass;
        $response->GetAuthorizedTstResult->any = $responseXml;

        $this->_soapClientMock->expects($this->once())
            ->method('GetAuthorizedTst')
            ->will($this->returnValue($response));

        $getAuthorized = new GetAuthorized($this->_komerciClient, $this->_soapClientMock);
        $response = $getAuthorized->call();

        $this->assertTrue($getAuthorized->approved($response));
    }

    public function testNotApprovedMethodResponse()
    {
        $notZero = rand(1, 99);
        $emptyString = '';
        $responseXml = "<AUTHORIZATION><CODRET>{$notZero}</CODRET><NUMCV>{$emptyString}</NUMCV></AUTHORIZATION>";

        $response = new \StdClass;
        $response->GetAuthorizedTstResult = new \StdClass;
        $response->GetAuthorizedTstResult->any = $responseXml;

        $this->_soapClientMock->expects($this->once())
            ->method('GetAuthorizedTst')
            ->will($this->returnValue($response));

        $getAuthorized = new GetAuthorized($this->_komerciClient, $this->_soapClientMock);
        $response = $getAuthorized->call();

        $this->assertFalse($getAuthorized->approved($response));
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

