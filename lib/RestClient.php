<?php

namespace Paggi;

//Curl for manager the HTTP requests
use \Curl\Curl;

/**
 * Class RestClient - This class manager the requests
 * @package Paggi
 */
class RestClient
{
    private $curl;
    const BASE_STAGING = "https://staging-online.paggi.com/api/v4/"; //STAGING
    const BASE_PRODUCTION = "https://online.paggi.com/api/v4/"; //PRODUCTION
    private $endPoint;

    /**
     * RestClient constructor.
     */
    public function __construct()
    {
        //Get the Enviroment
        $this->endPoint = $this->getEnviroment(Paggi::isStaging());

        //Instance the curl
        $this->curl = new Curl();
        $this->curl->setBasicAuthentication(Paggi::getToken(), "");
        $this->curl->setDefaultJsonDecoder($assoc = true);
        $this->curl->setHeader('Content-Type', 'application/json; charset=utf-8');
        $this->curl->setDefaultTimeout();
    }

    /**
     * Return the Environment
     * @param $isStaging
     * @return string API Environment
     */
    private function getEnviroment($isStaging = false)
    {
        if ($isStaging == true) {
            return (self::BASE_STAGING);
        } else {
            return (self::BASE_PRODUCTION);
        }
    }

    /**
     * Get the Endpoint [banks - bank-accounts - customer - cards - charges]
     * @param $resource - The resource used [banks - bank-accounts - customer - cards - charges]
     * @return string [banks - bank-accounts - customer - cards - charges]
     */
    public function getEndpoint($resource)
    {
        return strtolower($this->endPoint . str_replace('\\', '/', $resource));
    }

    /**
     * Return the curl for manage the HTTP Requests
     * @return Curl
     */
    public function getCurl()
    {
        return $this->curl;
    }
}

?>
