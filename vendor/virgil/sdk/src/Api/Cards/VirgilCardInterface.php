<?php
namespace Virgil\Sdk\Api\Cards;


use Virgil\Sdk\Client\Card;

use Virgil\Sdk\Contracts\BufferInterface;
use Virgil\Sdk\Contracts\PublicKeyInterface;

use Virgil\Sdk\Client\Card\CardSerializerInterface;

use Virgil\Sdk\Api\Cards\Identity\IdentityVerificationAttemptInterface;
use Virgil\Sdk\Api\Cards\Identity\IdentityVerificationOptionsInterface;

/**
 * Interface represents an information about the user and his public key. The Virgil Card identifies the user by one of
 * his available types, such as an email, a phone number, etc.
 */
interface VirgilCardInterface
{
    /**
     * Returns public key.
     *
     * @return PublicKeyInterface
     */
    public function getPublicKey();


    /**
     * Initiates an identity verification process for current Card identity type. It is only working for Global
     * identity types like Email.
     *
     * @param IdentityVerificationOptionsInterface $identityVerificationOptions
     *
     * @return IdentityVerificationAttemptInterface
     */
    public function checkIdentity(IdentityVerificationOptionsInterface $identityVerificationOptions = null);


    /**
     * Encrypts the specified data for current virgil card recipient.
     *
     * @param mixed $content
     *
     * @return BufferInterface
     */
    public function encrypt($content);


    /**
     * Verifies the specified content and signature with current virgil card recipient.
     *
     * @param mixed $content
     * @param mixed $signature base64 encoded string or Buffer
     *
     * @return bool
     */
    public function verify($content, $signature);


    /**
     * Exports a current virgil card instance into base64 encoded string.
     *
     * @return string
     */
    public function export();


    /**
     * Sets custom card serializer.
     *
     * @param CardSerializerInterface $cardSerializer
     *
     * @return $this
     */
    public function setCardSerializer(CardSerializerInterface $cardSerializer);


    /**
     * Gets a card from virgil card is built.
     *
     * @return Card
     */
    public function getCard();


    /**
     * Sets a card.
     *
     * @param Card $card
     *
     * @return $this
     */
    public function setCard(Card $card);
}
