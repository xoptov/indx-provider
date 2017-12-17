<?php

namespace Xoptov\INDXConnector;

use Xoptov\TradingCore\Security\Credential as BaseCredential;

class Credential extends BaseCredential
{
    /** @var string */
    private $wmid;

    /**
     * {@inheritdoc}
     * @param string $wmid
     */
    public function __construct($login, $password, $wmid)
    {
        parent::__construct($login, $password);

        $this->wmid = $wmid;
    }

    /**
     * @return string
     */
    public function getWmid()
    {
        return $this->wmid;
    }

    /**
     * @param string $signature
     * @return string
     */
    public function encodeSignature($signature)
    {
        return base64_encode(hash("sha256", $signature, true));
    }
}