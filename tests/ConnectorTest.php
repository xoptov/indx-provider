<?php

namespace Xoptov\INDXConnector\Tests;

use DateTime;
use StdClass;
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

    public function testGetTools()
    {
        $this->markTestIncomplete("Method not work on INDX.");

        $credential = new Credential(INDX_LOGIN, INDX_PASSWORD, INDX_WMID);
        $connector = new Connector("https://secure.indx.ru/api/v1/tradejson.asmx");

        $result = $connector->getTools($credential);

        $this->assertInstanceOf(StdClass::class, $result);
        $this->assertEquals(0, $result->code);
    }

    public function testGetSymbolList()
    {
	    $connector = new Connector(null);
	    $result = $connector->getSymbolList();

	    $this->assertInstanceOf(StdClass::class, $result);
    }

    public function testGetHistoryTrading()
    {
        $credential = new Credential(INDX_LOGIN, INDX_PASSWORD, INDX_WMID);
        $connector = new Connector("https://secure.indx.ru/api/v1/tradejson.asmx");

        $result = $connector->getHistoryTrading($credential, SYMBOL_ID, new DateTime(TRADING_START), new DateTime(TRADING_END));

        $this->assertInstanceOf(StdClass::class, $result);
        $this->assertEquals(0, $result->code);
    }

    public function testGetHistoryTransaction()
    {
	    $credential = new Credential(INDX_LOGIN, INDX_PASSWORD, INDX_WMID);
	    $connector = new Connector("https://secure.indx.ru/api/v1/tradejson.asmx");

	    $result = $connector->getHistoryTrading($credential, SYMBOL_ID, new DateTime(TRADING_START), new DateTime(TRADING_END));

	    $this->assertInstanceOf(StdClass::class, $result);
	    $this->assertEquals(0, $result->code);
    }

	public function testGetOfferMy()
	{
		$credential = new Credential(INDX_LOGIN, INDX_PASSWORD, INDX_WMID);
		$connector = new Connector("https://secure.indx.ru/api/v1/tradejson.asmx");

		$result = $connector->getOfferMy($credential, SYMBOL_ID, new DateTime(TRADING_START), new DateTime(TRADING_END));

		$this->assertInstanceOf(StdClass::class, $result);
		$this->assertEquals(0, $result->code);
	}

	public function testGetOfferList()
	{
		$credential = new Credential(INDX_LOGIN, INDX_PASSWORD, INDX_WMID);
		$connector = new Connector("https://secure.indx.ru/api/v1/tradejson.asmx");

		$result = $connector->getOfferList($credential, SYMBOL_ID);

		$this->assertInstanceOf(StdClass::class, $result);
		$this->assertEquals(0, $result->code);
	}

	public function testGetOffer()
	{
		$connector = new Connector(null);
		$result = $connector->getOffer(SYMBOL_ID, true);

		$this->assertInstanceOf(StdClass::class, $result);
	}

    public function testAddOffer()
    {
        $this->markTestSkipped("This test need mock whole requests.");

        $credential = new Credential(INDX_LOGIN, INDX_PASSWORD, INDX_WMID);
        $connector = new Connector("https://secure.indx.ru/api/v1/tradejson.asmx");

        $result = $connector->addOffer($credential, SYMBOL_ID, 1, 0.25);

        $this->assertInstanceOf(StdClass::class, $result);
        $this->assertEquals(0, $result->code);
    }

    public function testDeleteOffer()
    {
        $this->markTestSkipped("This test need mock whole requests.");

        $offerId = 5348571;

        $credential = new Credential(INDX_LOGIN, INDX_PASSWORD, INDX_WMID);
        $connector = new Connector("https://secure.indx.ru/api/v1/tradejson.asmx");

        $result = $connector->deleteOffer($credential, $offerId);

        $this->assertInstanceOf(StdClass::class, $result);
        $this->assertEquals(0, $result->code);
    }
}
