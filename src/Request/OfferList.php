<?php

namespace Xoptov\INDXConnector\Request;

use JsonSerializable;
use Xoptov\INDXConnector\Credential;

class OfferList extends AbstractRequest implements JsonSerializable
{
    /** @var string */
    protected $url = "https://api.indx.ru/api/v2/trade/OfferList";

    /** @var string */
    protected $method = "POST";

    /** @var integer */
    private $symbolId;

    /**
     * OfferList constructor.
     *
     * @param Credential $credential Credential object.
     * @param string     $symbolId   Symbol ID.
     * @param string     $culture    Culture symbol.
     */
    public function __construct(Credential $credential, $symbolId, $culture = "ru_RU")
    {
        parent::__construct($credential, $culture);

        $this->symbolId = $symbolId;
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
            $this->symbolId
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
                "ID" => $this->symbolId
            ]
        ];

        return $data;
    }
}