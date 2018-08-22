<?php
namespace App\Traits;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

trait StrathmoreWebService
{

    /**
     * Get data from the Strathmore Web Service
     * 
     * @return object|array $response
     */
    public function getDataFromStrathmoreWebService($url)
    {
        $client = new Client();

        try {
            $response = $client->get($url);
        } catch (RequestException $exception) {
            $errorCode = $exception->getResponse()->getStatusCode(true);
            abort($errorCode);
        }

        return $response;
    }
}
