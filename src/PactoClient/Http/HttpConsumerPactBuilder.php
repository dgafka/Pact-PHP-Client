<?php

namespace Madkom\PactoClient\Http;

use Http\Client\HttpClient;
use Madkom\PactoClient\Application\ConsumerPactBuilder;
use Madkom\PactoClient\Domain\Interaction\InteractionFactory;
use Madkom\PactoClient\Http\Service\RequestBuilder;

/**
 * Class ConsumerPactBuilder
 * @package Madkom\PactoClient\Http
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 */
class HttpConsumerPactBuilder extends ConsumerPactBuilder
{
    /**
     * @var HttpClient
     */
    private $client;
    /**
     * @var string
     */
    private $host;
    /**
     * @var RequestBuilder
     */
    private $requestBuilder;
    /**
     * @var string
     */
    private $consumerName;
    /**
     * @var string
     */
    private $providerName;
    /**
     * @var string
     */
    private $contractDir;

    /**
     * ConsumerPactBuilder constructor.
     *
     * @param HttpClient $client All Http Clients, which implement Httplug interface
     * @param string     $host   Example http://localhost:1234
     * @param string     $consumerName
     * @param string     $providerName
     * @param string     $contractDir If no passed, it take contract dir set up on mock-service startup
     */
    public function __construct(HttpClient $client, $host, $consumerName, $providerName, $contractDir = null)
    {
        $this->client = $client;
        $this->host = $host;
        $this->consumerName = $consumerName;
        $this->providerName = $providerName;
        $this->contractDir = $contractDir;

        $this->requestBuilder = new RequestBuilder($this->host);
        parent::__construct(new InteractionFactory());
    }

    /**
     * @inheritDoc
     */
    public function setupInteraction()
    {
        $interaction = parent::setupInteraction();

        $this->client->sendRequest($this->requestBuilder->buildRemoveExpectationsRequest());
        $this->client->sendRequest($this->requestBuilder->buildCreateInteractionRequest($interaction));
    }

    /**
     * It verifies set up interaction
     */
    public function verify()
    {
        $this->client->sendRequest($this->requestBuilder->buildVerifyInteractionRequest());
    }

    /**
     * It ends provider verification process
     *
     */
    public function finishProviderVerificationProcess()
    {
        $this->client->sendRequest($this->requestBuilder->buildEndProviderTestRequest($this->consumerName, $this->providerName, $this->contractDir));
    }

}
