<?php

namespace Xoptov\INDXConnector;

use StdClass;
use XMLReader;
use RuntimeException;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Xoptov\TradingCore\ConnectorInterface;
use GuzzleHttp\Exception\BadResponseException;

class Connector implements ConnectorInterface
{
    /** @var Client */
    private $client;

    /** @var  */
    private $xmlReader;

    /**
     * Connector constructor.
     * @param string $baseUri
     */
    public function __construct($baseUri)
    {
        $this->client = new Client(array(
            "base_uri" => $baseUri,
            "headers" => array(
                "Content-Type" => "text/xml"
            )
        ));

        $this->xmlReader = new XMLReader();
    }

    /**
     * @param Credential $credential
     * @param string $culture
     * @return StdClass|null
     */
    public function getBalance(Credential $credential, $culture = "ru-RU")
    {
        $signature = sprintf("%s;%s;%s;%s", $credential->getLogin(), $credential->getPassword(), $culture, $credential->getWmid());

        $body = array(
            "Login" => $credential->getLogin(),
            "Password" => $credential->getPassword(),
            "Wmid" => $credential->getWmid(),
            "Culture" => $culture,
            "Signature" => $credential->encodeSignature($signature)
        );

        $requestBody = sprintf("<?xml version=\"1.0\" encoding=\"utf-8\"?><soap:Envelope xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xmlns:xsd=\"http://www.w3.org/2001/XMLSchema\" xmlns:soap=\"http://schemas.xmlsoap.org/soap/envelope/\"><soap:Body><Balance xmlns=\"http://indx.ru/\"><Request>%s</Request></Balance></soap:Body></soap:Envelope>", json_encode($body));

        $request = new Request("POST", null, array(
            "SOAPAction" => "http://indx.ru/Balance"
        ), $requestBody);

        $response = $this->client->send($request);

        if ($response->getStatusCode() != 200) {
            throw new BadResponseException("Bad request.", $request);
        }

        if (!$this->xmlReader->XML($response->getBody())) {
            throw new RuntimeException("Can not set xml data to XMLReader.");
        }

        if ($this->xmlReader->read()) {
            $content = $this->xmlReader->readString();

            return json_decode($content);
        }

        return null;
    }
}