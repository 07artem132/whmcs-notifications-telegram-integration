<?php
namespace Virgil\Sdk\Client\Requests;


use Virgil\Sdk\Buffer;

use Virgil\Sdk\Contracts\BufferInterface;

use Virgil\Sdk\Client\VirgilServices\VirgilCards\Mapper\CreateRequestModelMapper;
use Virgil\Sdk\Client\VirgilServices\Mapper\CardContentModelMapper;

use Virgil\Sdk\Client\VirgilServices\Model\CardContentModel;
use Virgil\Sdk\Client\VirgilServices\Model\DeviceInfoModel;
use Virgil\Sdk\Client\VirgilServices\Model\SignedRequestModel;

/**
 * Class represents request for card creation.
 */
class CreateCardRequest extends AbstractSignableCardRequest
{
    /** @var string $identity */
    private $identity;

    /** @var string $identityType */
    private $identityType;

    /** @var BufferInterface $publicKeyData */
    private $publicKeyData;

    /** @var array $data */
    private $data;

    /** @var DeviceInfoModel $info */
    private $info;

    /** @var string $scope */
    private $scope;


    /**
     * Class constructor.
     *
     * @param string          $identity
     * @param string          $identityType
     * @param BufferInterface $publicKeyData
     * @param string          $scope
     * @param array           $data
     * @param DeviceInfoModel $info
     */
    public function __construct(
        $identity,
        $identityType,
        BufferInterface $publicKeyData,
        $scope,
        $data = [],
        DeviceInfoModel $info = null
    ) {
        $this->identity = $identity;
        $this->identityType = $identityType;
        $this->publicKeyData = $publicKeyData;
        $this->data = $data;
        $this->info = $info;
        $this->scope = $scope;

        $this->contentSnapshot = $this->getSnapshot();
    }


    /**
     * Returns create request model mapper.
     *
     * @return CreateRequestModelMapper
     */
    protected static function getRequestModelJsonMapper()
    {
        return new CreateRequestModelMapper(new CardContentModelMapper());
    }


    /**
     * Builds a create card request from request model.
     *
     * @param SignedRequestModel $signedRequestModel
     *
     * @return CreateCardRequest
     */
    protected static function buildRequestFromRequestModel(SignedRequestModel $signedRequestModel)
    {
        /** @var CardContentModel $requestContentModel */
        $requestContentModel = $signedRequestModel->getRequestContent();

        return new self(
            $requestContentModel->getIdentity(),
            $requestContentModel->getIdentityType(),
            Buffer::fromBase64($requestContentModel->getPublicKey()),
            $requestContentModel->getScope(),
            $requestContentModel->getData(),
            $requestContentModel->getInfo()
        );
    }


    /**
     * Returns card identity.
     *
     * @return string
     */
    public function getIdentity()
    {
        return $this->identity;
    }


    /**
     * Returns card public key raw data.
     *
     * @return BufferInterface
     */
    public function getPublicKeyData()
    {
        return $this->publicKeyData;
    }


    /**
     * Returns card identity type.
     *
     * @return string
     */
    public function getIdentityType()
    {
        return $this->identityType;
    }


    /**
     * Returns card info.
     *
     * @return DeviceInfoModel
     */
    public function getInfo()
    {
        return $this->info;
    }


    /**
     * Returns card additional data.
     *
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }


    /**
     * Returns card scope.
     *
     * @return string
     */
    public function getScope()
    {
        return $this->scope;
    }


    /**
     * @inheritdoc
     */
    protected function getCardContent()
    {
        return new CardContentModel(
            $this->identity,
            $this->identityType,
            $this->publicKeyData->toBase64(),
            $this->scope,
            $this->data,
            $this->info
        );
    }
}
