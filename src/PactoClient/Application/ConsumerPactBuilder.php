<?php

namespace Madkom\PactoClient\Application;

/**
 * Class ConsumerPactBuilder
 * @package Madkom\PactoClient\Application
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 */
final class ConsumerPactBuilder
{

    /** @var  string */
    private $providerState;

    /** @var  string */
    private $requestInformation;

    /** @var  array */
    private $requestData;

    /** @var  array */
    private $responseData;

    /**
     * Provider state while sending a request.
     * For example ("An alligator named Mary exists")
     *
     * @param string $providerState
     *
     * @return $this
     */
    public function given($providerState)
    {
        $this->providerState = $providerState;

        return $this;
    }

    /**
     * Request information for example ("A request for an alligator")
     *
     * @param string $requestInfo
     *
     * @return $this
     */
    public function uponReceiving($requestInfo)
    {
        $this->requestInformation = $requestInfo;

        return $this;
    }

    /**
     * Request data, which will be send to the consumer
     *
     *  Example:
     *  [
            "method" => "get",
                "path"   => "/alligators/Mary",
            "headers" => [
                "Accept" => "application/json"
            ],
            "body" => [
                "param" => 1
            ],
            "query" => [
                "name" => "fred"
            ]
        ]
     *
     * @param array $requestData
     *
     * @return $this
     */
    public function with(array $requestData)
    {
        $this->requestData = $requestData;

        return $this;
    }

    /**
     * Response data, which should be be received from provider after doing request
     *
     * Example:
     *  [
            "status"    => 200,
            "headers"   => ["Content-Type" => "application/json"],
            "body"      => [
                "name"      => "Mary",
                "children"  => Pact::eachLike(["name" => "Fred", "age" => 2])
            ]
        ]
     *
     * @param array $responseData
     */
    public function willRespondWith(array $responseData)
    {
        $this->responseData = $responseData;
    }

    
}