<?php

namespace Xoptov\INDXConnector;

class Credential
{
    /** @var string */
    private $login;

    /** @var string */
    private $password;

    /** @var string */
    private $wmid;

    /**
     * Constructor.
     *
     * @param string $wmid
     */
    public function __construct($login, $password, $wmid)
    {
        $this->login = $login;
        $this->password = $password;
        $this->wmid = $wmid;
    }

    /**
     * Method for get login.
     *
     * @return string
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * Method for get password.
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getWmid()
    {
        return $this->wmid;
    }

    /**
     * Method for encoding signature for connection with API.
     *
     * @param string $signature
     * @return string
     */
    public function encodeSignature($signature)
    {
        return base64_encode(hash("sha256", $signature, true));
    }
}