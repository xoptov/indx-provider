<?php

namespace Xoptov\INDXConnector\Request;

use JsonSerializable;

class Tools extends AbstractRequest implements JsonSerializable
{
    /** @var string */
    protected $url = "https://api.indx.ru/api/v2/trade/Tools";

    /** @var string */
    protected $method = "POST";

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize()
    {
        $parts = [
            $this->credential->getLogin(),
            $this->credential->getPassword(),
            $this->culture
        ];

        $signature = implode(';', $parts);

        $data = [
            "ApiContext" => [
                "Login" => $this->credential->getLogin(),
                "Wmid" => $this->credential->getWmid(),
                "Culture" => $this->culture,
                "Signature" => $this->credential->encodeSignature($signature)
            ]
        ];

        return $data;
    }
}