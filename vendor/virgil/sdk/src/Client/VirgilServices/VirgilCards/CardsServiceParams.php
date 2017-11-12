<?php
namespace Virgil\Sdk\Client\VirgilServices\VirgilCards;


use Virgil\Sdk\Client\VirgilServices\AbstractServiceParams;

/**
 * Class provides Cards Service params.
 */
class CardsServiceParams extends AbstractServiceParams implements CardsServiceParamsInterface
{
    const GET_ENDPOINT = '/v4/card';
    const SEARCH_ENDPOINT = '/v4/card/actions/search';
    const CREATE_ENDPOINT = '/v4/card';
    const DELETE_ENDPOINT = '/v4/card';

    /** @var string $searchEndpoint */
    private $searchEndpoint;

    /** @var string $createEndpoint */
    private $createEndpoint;

    /** @var string $deleteEndpoint */
    private $deleteEndpoint;

    /** @var string $getEndpoint */
    private $getEndpoint;

    /** @var string $immutableHost */
    private $immutableHost;

    /** @var string $mutableHost */
    private $mutableHost;


    /**
     * Class constructor.
     *
     * @param string $immutableHost
     * @param string $mutableHost
     * @param string $searchEndpoint
     * @param string $createEndpoint
     * @param string $deleteEndpoint
     * @param string $getEndpoint
     */
    public function __construct(
        $immutableHost,
        $mutableHost,
        $searchEndpoint = self::SEARCH_ENDPOINT,
        $createEndpoint = self::CREATE_ENDPOINT,
        $deleteEndpoint = self::DELETE_ENDPOINT,
        $getEndpoint = self::GET_ENDPOINT
    ) {
        $this->immutableHost = $immutableHost;
        $this->mutableHost = $mutableHost;
        $this->searchEndpoint = $searchEndpoint;
        $this->createEndpoint = $createEndpoint;
        $this->deleteEndpoint = $deleteEndpoint;
        $this->getEndpoint = $getEndpoint;
    }


    /**
     * @inheritdoc
     */
    public function getSearchUrl()
    {
        return $this->buildUrl($this->immutableHost, $this->searchEndpoint);
    }


    /**
     * @inheritdoc
     */
    public function getCreateUrl()
    {
        return $this->buildUrl($this->mutableHost, $this->createEndpoint);
    }


    /**
     * @inheritdoc
     */
    public function getDeleteUrl($id = null)
    {
        return $this->buildUrl($this->mutableHost, $this->deleteEndpoint, $id);
    }


    /**
     * @inheritdoc
     */
    public function getGetUrl($id)
    {
        return $this->buildUrl($this->immutableHost, $this->getEndpoint, $id);
    }
}
