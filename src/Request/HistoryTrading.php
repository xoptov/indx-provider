<?php

namespace Xoptov\INDXConnector\Request;

use JsonSerializable;
use Xoptov\INDXConnector\Credential;

class HistoryTrading extends AbstractRequest implements JsonSerializable
{
    /** @var string */
    protected $url = "https://api.indx.ru/api/v2/trade/HistoryTrading";

    /** @var string */
    protected $method = "POST";

    /** @var integer */
    private $symbolId;

    /** @var string */
    private $dateStart;

    /** @var string */
    private $dateEnd;

    /**
     * HistoryTrading constructor.
     *
     * @param Credential $credential Credential object.
     * @param string     $symbolId   Symbol ID for retrieving history.
     * @param string     $dateStart  Start date in "YYYYMMDD" format.
     * @param string     $dateEnd    End date on "YYYYMMDD" format.
     * @param string     $culture    Culture symbol.
     */
    public function __construct(Credential $credential, $symbolId, $dateStart, $dateEnd, $culture = "ru_RU")
    {
        parent::__construct($credential, $culture);

        $this->symbolId = $symbolId;
        $this->dateStart = $dateStart;
        $this->dateEnd = $dateEnd;
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize()
    {
        $parts = [
            $this->credential->getLogin(),
            $this->credential->getPassword(),
            $this->culture,
            $this->credential->getWmid(),
            $this->symbolId,
            $this->dateStart,
            $this->dateEnd
        ];

        $signature = implode(';', $parts);

        $data = [
            "ApiContext" => [
                "Login" => $this->credential->getLogin(),
                "Password" => $this->credential->getPassword(),
                "Wmid" => $this->credential->getWmid(),
                "Culture" => $this->culture,
                "Signature" => $this->credential->encodeSignature($signature)
            ],
            "Trading" => [
                "ID" => $this->symbolId,
                "DateStart" => $this->dateStart,
                "DateEnd" => $this->dateEnd
            ]
        ];

        return $data;
    }
}