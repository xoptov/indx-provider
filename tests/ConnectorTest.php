<?php

namespace Xoptov\INDXConnector\Tests;

use DateTime;
use StdClass;
use XMLReader;
use ReflectionObject;
use PHPUnit\Framework\TestCase;
use Xoptov\INDXConnector\Connector;
use Xoptov\INDXConnector\Credential;

class ConnectorTest extends TestCase
{
    public function testGetBalance()
    {
        $credential = new Credential(INDX_LOGIN, INDX_PASSWORD, INDX_WMID);
        $connector = new Connector("https://secure.indx.ru/api/v1/tradejson.asmx");

        $result = $connector->getBalance($credential);

        $this->assertInstanceOf(StdClass::class, $result);
        $this->assertEquals(0, $result->code);
    }

    public function testBalanceParseResponse()
    {
        $this->markTestIncomplete("Need make this test complete when all methods will be done.");

        $data = ""; //TODO: place real data from exchange response.

        $xmlReader = new XMLReader();
        $xmlReader->XML($data);
    }

    public function testGetTools()
    {
        $this->markTestIncomplete("Need make this test complete when all methods will be done.");

        $credential = new Credential(INDX_LOGIN, INDX_PASSWORD, INDX_WMID);
        $connector = new Connector("https://secure.indx.ru/api/v1/tradejson.asmx");

        $result = $connector->getTools($credential);

        $this->assertInstanceOf(StdClass::class, $result);
        $this->assertEquals(0, $result->code);
    }

    public function testGetHistoryTrading()
    {
        $credential = new Credential(INDX_LOGIN, INDX_PASSWORD, INDX_WMID);
        $connector = new Connector("https://secure.indx.ru/api/v1/tradejson.asmx");

        $result = $connector->getHistoryTrading($credential, SYMBOL_ID, new DateTime(TRADING_START), new DateTime(TRADING_END));

        $this->assertInstanceOf(StdClass::class, $result);
        $this->assertEquals(0, $result->code);
    }

    public function testCreateXML()
    {
        $this->markTestIncomplete("Need make this test complete when all methods will be done.");

        $connector = new Connector(null);
        $reflection = new ReflectionObject($connector);
        $method = $reflection->getMethod("createXML");
        $method->setAccessible(true);
        $result = $method->invoke($connector, "test", "Balance");

        return;
    }
}
