<?php
namespace EuMatheusGomes\Komerci\Test\Method;

use EuMatheusGomes\Komerci\KomerciClient;
use EuMatheusGomes\Komerci\Method\VoidTransaction;

class VoidTransactionTest extends \PHPUnit_Framework_TestCase
{
    protected $_komerciClient;
    protected $_soapClientMock;

    protected function setUp()
    {
        $this->_komerciClient = new KomerciClient();

        $this->_soapClientMock = $this->getMockBuilder('SoapClient')
            ->disableOriginalConstructor()
            ->setMethods(array('VoidTransaction', 'VoidTransactionTst'))
            ->getMock();
    }

    /**
     * @expectedException BadMethodCallException
     */
    public function testInvalidSetterMethod()
    {
        $voidTransaction = new VoidTransaction($this->_komerciClient, $this->_soapClientMock);
        $voidTransaction->invalidMethodName();
    }

    /**
     * @expectedException BadMethodCallException
     */
    public function testInvalidAttributeNameForSetterMethod()
    {
        $voidTransaction = new VoidTransaction($this->_komerciClient, $this->_soapClientMock);
        $voidTransaction->setInvalidAttr();
    }

    /**
     * @expectedException InvalidArgumentException
     * @dataProvider validAttrNameProvider
     */
    public function testSetterMethodWithoutArgs($validAttrName)
    {
        $voidTransaction = new VoidTransaction($this->_komerciClient, $this->_soapClientMock);
        $voidTransaction->{"set{$validAttrName}"}();
    }

    /**
     * @dataProvider validAttrNameProvider
     */
    public function testSetterMethodReturnSelf($validAttrName)
    {
        $voidTransaction = new VoidTransaction($this->_komerciClient, $this->_soapClientMock);

        $this->assertSame(
            $voidTransaction,
            $voidTransaction->{"set{$validAttrName}"}('any value')
        );
    }

    public function testVoidTransactionTstCallInDevMode()
    {
        $response = new \StdClass;
        $response->VoidTransactionTstResult = new \StdClass;
        $response->VoidTransactionTstResult->any = '<any_valid_xml></any_valid_xml>';

        $this->_soapClientMock->expects($this->once())
            ->method('VoidTransactionTst')
            ->will($this->returnValue($response));

        $voidTransaction = new VoidTransaction($this->_komerciClient, $this->_soapClientMock);
        $voidTransaction->call();
    }

    public function testVoidTransactionCallInProdMode()
    {
        $response = new \StdClass;
        $response->VoidTransactionResult = new \StdClass;
        $response->VoidTransactionResult->any = '<any_valid_xml></any_valid_xml>';

        $this->_soapClientMock->expects($this->once())
            ->method('VoidTransaction')
            ->will($this->returnValue($response));

        $komerciClient = new KomerciClient('prod');
        $voidTransaction = new VoidTransaction($komerciClient, $this->_soapClientMock);

        $voidTransaction->call();
    }

    public function testReturnsSimpleXMLElement()
    {
        $response = new \StdClass;
        $response->VoidTransactionTstResult = new \StdClass;
        $response->VoidTransactionTstResult->any = '<any_valid_xml></any_valid_xml>';

        $this->_soapClientMock->expects($this->once())
            ->method('VoidTransactionTst')
            ->will($this->returnValue($response));

        $voidTransaction = new VoidTransaction($this->_komerciClient, $this->_soapClientMock);

        $this->assertEquals('SimpleXMLElement', get_class($voidTransaction->call()));
    }

    public function testApprovedMethodResponse()
    {
        $zero = 0;
        $responseXml = "<CONFIRMATION><root><codret>{$zero}</codret></root></CONFIRMATION>";

        $response = new \StdClass;
        $response->VoidTransactionTstResult = new \StdClass;
        $response->VoidTransactionTstResult->any = $responseXml;

        $this->_soapClientMock->expects($this->once())
            ->method('VoidTransactionTst')
            ->will($this->returnValue($response));

        $voidTransaction = new VoidTransaction($this->_komerciClient, $this->_soapClientMock);
        $response = $voidTransaction->call();

        $this->assertTrue($voidTransaction->approved($response));
    }

    public function testNotApprovedMethodResponse()
    {
        $notZero = rand(1, 99);
        $responseXml = "<CONFIRMATION><root><codret>{$notZero}</codret></root></CONFIRMATION>";

        $response = new \StdClass;
        $response->VoidTransactionTstResult = new \StdClass;
        $response->VoidTransactionTstResult->any = $responseXml;

        $this->_soapClientMock->expects($this->once())
            ->method('VoidTransactionTst')
            ->will($this->returnValue($response));

        $voidTransaction = new VoidTransaction($this->_komerciClient, $this->_soapClientMock);
        $response = $voidTransaction->call();

        $this->assertFalse($voidTransaction->approved($response));
    }

    public function validAttrNameProvider()
    {
        return [
            ['Total'],
            ['Filiacao'],
            ['NumCV'],
            ['NumAutor'],
            ['Concentrador'],
            ['Usr'],
            ['Pwd']
        ];
    }
}

