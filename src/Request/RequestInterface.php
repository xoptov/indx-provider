<?php

namespace Xoptov\INDXConnector\Request;

interface RequestInterface
{
    /**
     * Method for retrieving url.
     *
     * @return string
     */
    public function getUrl();

    /**
     * Method for retrieving method type.
     *
     * @return string
     */
    public function getMethod();
}