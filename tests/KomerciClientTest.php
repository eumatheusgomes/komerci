<?php
namespace EuMatheusGomes\Komerci\Test;

use EuMatheusGomes\Komerci\KomerciClient;

class KomerciClientTest extends \PHPUnit_Framework_TestCase
{
    protected $komerciClient;

    protected function setUp()
    {
        $this->komerciClient = new KomerciClient();
    }

    public function testModeGetter()
    {
        $this->assertSame('dev', $this->komerciClient->getMode());
    }

    public function testUrlGetter()
    {
        $this->assertStringStartsWith(KomerciClient::WSURL_TESTE, $this->komerciClient->getUrl());
    }

    public function testWSUrlOnProductionMode()
    {
        $komerciClient = new KomerciClient('prod', '', '', '');
        $this->assertStringStartsWith(KomerciClient::WSURL, $komerciClient->getUrl());
    }

    public function testFiliacaoGetter()
    {
        $this->assertSame('999999999', $this->komerciClient->getFiliacao());
    }

    public function testUsrGetter()
    {
        $this->assertSame('testews', $this->komerciClient->getUsr());
    }

    public function testPwdGetter()
    {
        $this->assertSame('testews', $this->komerciClient->getPwd());
    }
}
