<?php
namespace Virgil\Sdk\Api\Cards;


use Virgil\Sdk\Buffer;

use Virgil\Sdk\Client\Card;

use Virgil\Sdk\Client\Card\CardSerializerInterface;

use Virgil\Sdk\Client\VirgilClientInterface;

use Virgil\Sdk\Contracts\BufferInterface;
use Virgil\Sdk\Contracts\CryptoInterface;

use Virgil\Sdk\Api\Cards\Identity\IdentityVerificationAttempt;
use Virgil\Sdk\Api\Cards\Identity\IdentityVerificationOptions;
use Virgil\Sdk\Api\Cards\Identity\IdentityVerificationOptionsInterface;

/**
 * A Virgil Card is the main entity of the Virgil Security services, it includes an information about the user and his
 * public key. The Virgil Card identifies the user by one of his available types, such as an email, a phone number,
 * etc.
 */
class VirgilCard implements VirgilCardInterface
{
    /** @var Card */
    private $card;

    /** @var CryptoInterface */
    private $virgilCrypto;

    /** @var VirgilClientInterface */
    private $virgilClient;

    /** @var CardSerializerInterface */
    private $cardSerializer;


    /**
     * Class constructor.
     *
     * @param CryptoInterface         $crypto
     * @param VirgilClientInterface   $virgilClient
     * @param CardSerializerInterface $cardSerializer
     * @param Card                    $card
     */
    public function __construct(
        CryptoInterface $crypto,
        VirgilClientInterface $virgilClient,
        CardSerializerInterface $cardSerializer,
        Card $card
    ) {
        $this->virgilCrypto = $crypto;
        $this->virgilClient = $virgilClient;
        $this->cardSerializer = $cardSerializer;
        $this->card = $card;
    }


    /**
     * @inheritdoc
     */
    public function getPublicKey()
    {
        $publicKeyData = $this->card->getPublicKeyData();

        return $this->virgilCrypto->importPublicKey($publicKeyData);
    }


    /**
     * @inheritdoc
     */
    public function checkIdentity(IdentityVerificationOptionsInterface $identityVerificationOptions = null)
    {
        if ($identityVerificationOptions === null) {
            $identityVerificationOptions = new IdentityVerificationOptions();
        }

        $actionId = $this->virgilClient->verifyIdentity(
            $this->card->getIdentity(),
            $this->card->getIdentityType(),
            $identityVerificationOptions->getExtraFields()
        );

        return new IdentityVerificationAttempt(
            $this->virgilClient,
            $actionId,
            $identityVerificationOptions->getTimeToLive(),
            $identityVerificationOptions->getCountToLive(),
            $this->card->getIdentityType(),
            $this->card->getIdentity()
        );
    }


    /**
     * @inheritdoc
     */
    public function encrypt($content)
    {
        return $this->virgilCrypto->encrypt((string)$content, [$this->getPublicKey()]);
    }


    /**
     * @inheritdoc
     */
    public function verify($content, $signature)
    {
        if (!$signature instanceof BufferInterface) {
            $signature = Buffer::fromBase64($signature);
        }

        return $this->virgilCrypto->verify((string)$content, $signature, $this->getPublicKey());
    }


    /**
     * @inheritdoc
     */
    public function export()
    {
        return $this->cardSerializer->serialize($this->card);
    }


    /**
     * @inheritdoc
     */
    public function setCardSerializer(CardSerializerInterface $cardSerializer)
    {
        $this->cardSerializer = $cardSerializer;

        return $this;
    }


    /**
     * @inheritdoc
     */
    public function getCard()
    {
        return $this->card;
    }


    /**
     * @inheritdoc
     */
    public function setCard(Card $card)
    {
        $this->card = $card;

        return $this;
    }
}
