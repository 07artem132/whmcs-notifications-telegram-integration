<?php
namespace Virgil\Sdk\Client\Requests;


use Virgil\Sdk\Client\VirgilServices\VirgilCards\Mapper\RevokeRequestModelMapper;

use Virgil\Sdk\Client\VirgilServices\Model\SignedRequestModel;
use Virgil\Sdk\Client\VirgilServices\Model\RevokeCardContentModel;

/**
 * Class represents request for card revoking.
 */
class RevokeCardRequest extends AbstractSignableCardRequest
{
    /** @var string $id */
    private $id;

    /** @var string $reason */
    private $reason;


    /**
     * Class constructor.
     *
     * @param string $id
     * @param string $reason
     */
    public function __construct($id, $reason)
    {
        $this->id = $id;
        $this->reason = $reason;

        $this->contentSnapshot = $this->getSnapshot();
    }


    /**
     * Returns revoke request model mapper.
     *
     * @return RevokeRequestModelMapper
     */
    protected static function getRequestModelJsonMapper()
    {
        return new RevokeRequestModelMapper();
    }


    /**
     * Builds a revoke card request from request model.
     *
     * @param SignedRequestModel $signedRequestModel
     *
     * @return RevokeCardRequest
     */
    protected static function buildRequestFromRequestModel(SignedRequestModel $signedRequestModel)
    {
        /** @var RevokeCardContentModel $revokeCardContent */
        $revokeCardContent = $signedRequestModel->getRequestContent();

        return new self($revokeCardContent->getId(), $revokeCardContent->getRevocationReason());
    }


    /**
     * Returns revocation reason.
     *
     * @return string
     */
    public function getReason()
    {
        return $this->reason;
    }


    /**
     * Returns card id to revoke.
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * @inheritdoc
     */
    protected function getCardContent()
    {
        return new RevokeCardContentModel($this->id, $this->reason);
    }
}
