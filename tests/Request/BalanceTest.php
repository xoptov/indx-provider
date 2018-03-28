<?php

namespace Xoptov\INDXConnector\Tests\Request;

use PHPUnit\Framework\TestCase;
use Xoptov\INDXConnector\Credential;
use Xoptov\INDXConnector\Request\Balance;

class BalanceTest extends TestCase
{
    public function testJsonEncode()
    {
        $credential = new Credential(INDX_LOGIN, INDX_PASSWORD, INDX_WMID);

        $request = new Balance($credential);
        $json = json_encode($request);
    }
}