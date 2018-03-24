<?php

namespace Xoptov\INDXConnector;

use DateTime;
use StdClass;
use XMLReader;
use XMLWriter;
use RuntimeException;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\BadResponseException;

/**
 * Class for connecting to INDX exchange.
 */
class Connector
{
    /** @var Client */
    private $client;

    /** @var string */
    private $userAgent = "INDXConnector v1.0, github.com/xoptov/indx-connector";

    /** @var XMLReader */
    private $xmlReader;

    /** @var XMLWriter */
    private $xmlWriter;

    /**
     * Connector constructor.
     *
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
        $this->xmlWriter = new XMLWriter();
    }

    /**
     * Method for getting Balance from exchange.
     *
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

        $body = $this->createXML(json_encode($body), "Balance");

        $request = new Request("POST", null, array(
	        "User-Agent" => $this->userAgent,
            "SOAPAction" => "http://indx.ru/Balance"
        ), $body);

        return $this->send($request);
    }

    /**
     * Method for getting trading tools from exchange.
     *
     * @param Credential $credential
     * @param string $culture
     * @todo Don't work, need ask in INDX forum what is wrong with this method in service?
     */
    public function getTools(Credential $credential, $culture = "ru-RU")
    {
    	throw new RuntimeException("Method not work because broken on INDX.");
    }

	/**
     * Method for getting symbols list from exchange.
     *
	 * @param bool $includeExpired
	 * @param bool $tradedOnly
	 * @return stdClass
	 */
    public function getSymbolList($includeExpired = false, $tradedOnly = true)
    {
    	$body = array(
    		"includeExpired" => $includeExpired,
		    "tradedOnly" => $tradedOnly
	    );

    	$request = new Request("POST", "https://indx.ru/TradingStats.asmx/GetSymbolList", array(
		    "Content-Type" => "application/json",
		    "User-Agent" => $this->userAgent
	    ), json_encode($body));

		$response = $this->client->send($request);

	    if ($response->getStatusCode() != 200) {
		    throw new BadResponseException("Bad request.", $request);
	    }

	    $result = json_decode($response->getBody());

	    return $result;
    }

    /**
     * Method for getting trading history for some symbol from exchange.
     *
     * @param Credential $credential
     * @param int $symbolId
     * @param DateTime $start
     * @param DateTime $end
     * @param string $culture
     * @return stdClass
     */
    public function getHistoryTrading(Credential $credential, $symbolId, DateTime $start, DateTime $end, $culture = "ru-RU")
    {
        $signature = sprintf(
            "%s;%s;%s;%s;%d;%s;%s",
            $credential->getLogin(),
            $credential->getPassword(),
            $culture,
            $credential->getWmid(),
            $symbolId,
            $start->format("Ymd"),
            $end->format("Ymd")
        );

        $body = array(
            "Login" => $credential->getLogin(),
            "Wmid" => $credential->getWmid(),
            "Culture" => $culture,
            "Signature" => $credential->encodeSignature($signature),
            "Trading" => array(
                "ID" => $symbolId,
                "DateStart" => $start->format("Ymd"),
                "DateEnd" => $end->format("Ymd")
            )
        );

        $body = $this->createXML(json_encode($body), "HistoryTrading");

        $request = new Request("POST", null, array(
	        "User-Agent" => $this->userAgent,
            "SOAPAction" => "http://indx.ru/HistoryTrading"
        ), $body);

        return $this->send($request);
    }

	/**
     * Method for getting transaction history from exchange.
     *
	 * @param Credential $credential
	 * @param int $symbolId
	 * @param DateTime $start
	 * @param DateTime $end
	 * @param string $culture
	 * @return stdClass
	 */
    public function getHistoryTransaction(Credential $credential, $symbolId, DateTime $start, DateTime $end, $culture = "ru-RU")
    {
		$signature = sprintf(
			"%s;%s;%s;%s;%d;%s;%s",
			$credential->getLogin(),
			$credential->getPassword(),
			$culture,
			$credential->getWmid(),
			$symbolId,
			$start->format("Ymd"),
			$end->format("Ymd")
		);

		$body = array(
			"Login" => $credential->getLogin(),
			"Wmid" => $credential->getWmid(),
			"Culture" => $culture,
			"Signature" => $credential->encodeSignature($signature),
			"Trading" =>  array(
				"ID" => $symbolId,
				"DateStart" => $start->format("Ymd"),
				"DateEnd" => $end->format("Ymd")
			)
		);

		$body = $this->createXML(json_encode($body), "HistoryTransaction");

	    $request = new Request("POST", null, array(
		    "User-Agent" => $this->userAgent,
		    "SOAPAction" => "http://indx.ru/HistoryTransaction"
	    ), $body);

	    return $this->send($request);
    }

	/**
     * Method for getting own offers from exchange.
     *
	 * @param Credential $credential
	 * @param int $symbolId
	 * @param DateTime $start
	 * @param DateTime $end
	 * @param string $culture
	 * @return stdClass
	 */
    public function getOfferMy(Credential $credential, $symbolId, DateTime $start, DateTime $end, $culture = "ru-RU")
    {
		$signature = sprintf(
			"%s;%s;%s;%s;%d;%s;%s",
			$credential->getLogin(),
			$credential->getPassword(),
			$culture,
			$credential->getWmid(),
			$symbolId,
			$start->format("Ymd"),
			$end->format("Ymd")
		);

	    $body = array(
		    "Login" => $credential->getLogin(),
		    "Wmid" => $credential->getWmid(),
		    "Culture" => $culture,
		    "Signature" => $credential->encodeSignature($signature),
		    "Trading" =>  array(
			    "ID" => $symbolId,
			    "DateStart" => $start->format("Ymd"),
			    "DateEnd" => $end->format("Ymd")
		    )
	    );

	    $body = $this->createXML(json_encode($body), "OfferMy");

	    $request = new Request("POST", null, array(
		    "User-Agent" => $this->userAgent,
		    "SOAPAction" => "http://indx.ru/OfferMy"
	    ), $body);

	    return $this->send($request);
    }

	/**
     * Method for getting offers for symbol from exchange.
     *
	 * @param int $symbolId
	 * @param bool $fullQueue
	 * @return stdClass
	 */
    public function getOffer($symbolId, $fullQueue = false)
    {
    	$body = array(
    		"symbolid" => $symbolId,
		    "fullqueue" => $fullQueue
	    );

    	$request = new Request("POST", "https://indx.ru/TradingStats.asmx/GetOffers", array(
		    "Content-Type" => "application/json",
		    "User-Agent" => $this->userAgent
	    ), json_encode($body));

    	$response = $this->client->send($request);

	    if ($response->getStatusCode() != 200) {
		    throw new BadResponseException("Bad request.", $request);
	    }

	    $result = json_decode($response->getBody());

	    return $result;
    }

	/**
     * Method for getting offer list from exchange.
     *
	 * @param Credential $credential
	 * @param $symbolId
	 * @param string $culture
	 * @return stdClass
	 */
    public function getOfferList(Credential $credential, $symbolId, $culture = "ru-RU")
    {
		$signature = sprintf(
			"%s;%s;%s;%s;%d",
			$credential->getLogin(),
			$credential->getPassword(),
			$culture,
			$credential->getWmid(),
			$symbolId
		);

		$body = array(
			"Login" => $credential->getLogin(),
			"Wmid" => $credential->getWmid(),
			"Culture" => $culture,
			"Signature" => $credential->encodeSignature($signature),
			"Trading" => array(
				"ID" => $symbolId
			)
		);

	    $body = $this->createXML(json_encode($body), "OfferList");

	    $request = new Request("POST", null, array(
		    "User-Agent" => $this->userAgent,
		    "SOAPAction" => "http://indx.ru/OfferList"
	    ), $body);

	    return $this->send($request);
    }

    /**
     * Method for place offer of symbol to exchange.
     *
     * @param Credential $credential
     * @param int $symbolId
     * @param int $count
     * @param float $price
     * @param bool $isBid
     * @param bool $isAnonymous
     * @param string $culture
     * @return StdClass
     */
    public function addOffer(Credential $credential, $symbolId, $count, $price, $isBid = true, $isAnonymous = true, $culture = "ru-RU")
    {
        $signature = sprintf(
            "%s;%s;%s;%s;%d",
            $credential->getLogin(),
            $credential->getPassword(),
            $culture,
            $credential->getWmid(),
            $symbolId
        );

        $body = array(
            "Login" => $credential->getLogin(),
            "Wmid" => $credential->getWmid(),
            "Culture" => $culture,
            "Signature" => $credential->encodeSignature($signature),
            "Offer" => array(
                "ID" => $symbolId,
                "Count" => $count,
                "IsAnonymous" => $isAnonymous,
                "IsBid" => $isBid,
                "Price" => $price
            )
        );

        $body = $this->createXML(json_encode($body), "OfferAdd");

        $request = new Request("POST", null, array(
	        "User-Agent" => $this->userAgent,
            "SOAPAction" => "http://indx.ru/OfferAdd"
        ), $body);

        return $this->send($request);
    }

    /**
     * Method for delete offer from exchange.
     *
     * @param Credential $credential
     * @param int $offerId
     * @param string $culture
     * @return StdClass
     */
    public function deleteOffer(Credential $credential, $offerId, $culture = "ru-RU")
    {
        $signature = sprintf(
            "%s;%s;%s;%s;%d",
            $credential->getLogin(),
            $credential->getPassword(),
            $culture,
            $credential->getWmid(),
            $offerId
        );

        $body = array(
            "Login" => $credential->getLogin(),
            "Wmid" => $credential->getWmid(),
            "Culture" => $culture,
            "Signature" => $credential->encodeSignature($signature),
            "OfferID" => $offerId
        );

        $body = $this->createXML(json_encode($body), "OfferDelete");

        $request = new Request("POST", null, array(
        	"User-Agent" => $this->userAgent,
            "SOAPAction" => "http://indx.ru/OfferDelete"
        ), $body);

        return $this->send($request);
    }

    /**
     * Method for creating xml body for enveloping request body.
     *
     * @param string $requestContent
     * @param string $action
     * @return mixed
     */
    private function createXML($requestContent, $action)
    {
        $this->xmlWriter->openMemory();

        $this->xmlWriter->startDocument("1.0", "utf-8");
            $this->xmlWriter->startElementNS("soap", "Envelope", null);
                $this->xmlWriter->startAttributeNS("xmlns", "xsi", null);
                    $this->xmlWriter->text("http://www.w3.org/2001/XMLSchema-instance");
                $this->xmlWriter->endAttribute();
                $this->xmlWriter->startAttributeNS("xmlns", "xsd", null);
                    $this->xmlWriter->text("http://www.w3.org/2001/XMLSchema");
                $this->xmlWriter->endAttribute();
                $this->xmlWriter->startAttributeNS("xmlns", "soap", null);
                    $this->xmlWriter->text("http://schemas.xmlsoap.org/soap/envelope/");
                $this->xmlWriter->endAttribute();
                $this->xmlWriter->startElementNS("soap", "Body", null);
                    $this->xmlWriter->startElement($action);
                        $this->xmlWriter->startAttribute("xmlns");
                            $this->xmlWriter->text("http://indx.ru/");
                        $this->xmlWriter->endAttribute();
                        $this->xmlWriter->startElement("Request");
                            $this->xmlWriter->writeRaw($requestContent);
                        $this->xmlWriter->endElement();
                    $this->xmlWriter->endElement();
            $this->xmlWriter->endElement();
        $this->xmlWriter->endDocument();

        return $this->xmlWriter->flush();
    }

    /**
     * Method for sending request to exchange API.
     *
     * @param Request $request
     * @return stdClass
     */
    private function send(Request $request)
    {
        $response = $this->client->send($request);

        if ($response->getStatusCode() != 200) {
            throw new BadResponseException("Bad request.", $request);
        }

        if (!$this->xmlReader->XML($response->getBody())) {
            throw new RuntimeException("Can not set xml data to XMLReader.");
        }

        if ($this->xmlReader->read()) {
            $content = $this->xmlReader->readString();
            $json = json_decode($content);

            if ($json->code == 0) {
	            return $json;
            }

	        throw new BadResponseException(sprintf("Code: %d, Description: %s", $json->code, $json->desc), $request, $response);
        }

	    throw new BadResponseException("Empty response body.", $request, $response);
    }
}