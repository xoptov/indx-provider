<?php

namespace Xoptov\INDXConnector\Request;

use Xoptov\INDXConnector\Credential;

abstract class AbstractRequest implements RequestInterface
{
    /** @var string */
    protected $url;

    /** @var string */
    protected $method;

    /** @var Credential */
    protected $credential;

    /** @var string */
    protected $culture;

    /**
     * AbstractRequest constructor.
     *
     * @param Credential $credential
     * @param string $culture
     */
    public function __construct(Credential $credential, $culture = "ru_RU")
    {
        $this->credential = $credential;
        $this->culture = $culture;
    }

    /**
     * {@inheritdoc}
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * {@inheritdoc}
     */
    public function getMethod()
    {
        return $this->method;
    }
}