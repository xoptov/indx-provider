<?php

namespace Xoptov\INDXConnector\Tests;

use XMLReader;
use PHPUnit\Framework\TestCase;
use Xoptov\INDXConnector\Connector;
use Xoptov\INDXConnector\Credential;

class ConnectorTest extends TestCase
{
    public function testBalance()
    {
        $this->markTestIncomplete("Need make this test complete when ASAP!");

        $login = "";
        $password = "";
        $wmid = "";

        $credential = new Credential($login, $password, $wmid);
        $connector = new Connector("https://secure.indx.ru/api/v1/tradejson.asmx");

        $result = $connector->getBalance($credential);
    }

    public function testBalanceParseResponse()
    {
        $this->markTestIncomplete("Need make this test complete when all methods will be done.");

        $data = ""; //TODO: place real data from exchange response.

        $xmlReader = new XMLReader();
        $xmlReader->XML($data);
    }
}
