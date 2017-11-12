<?php
namespace Virgil\Sdk\Api\Cards;


use Virgil\Sdk\Api\Cards\Identity\IdentityValidationToken;

use Virgil\Sdk\Api\Keys\VirgilKey;

use Virgil\Sdk\Client\Validator\CardValidationException;

/**
 * Interface provides methods to work with virgil card.
 */
interface CardsManagerInterface
{

    /**
     * Creates a new virgil card that is representing user's Public key and information
     * about identity. This card has to be published to the Virgil's services.
     *
     * @param string    $identity
     * @param string    $identityType
     * @param VirgilKey $ownerKey
     * @param array     $customFields
     *
     * @return VirgilCard
     */
    public function create($identity, $identityType, VirgilKey $ownerKey, array $customFields = []);


    /**
     * Creates a new global virgil card that is representing user's
     * Public key and information about identity.
     *
     * @param string    $identity
     * @param string    $identityType
     * @param VirgilKey $ownerKey
     * @param array     $customFields
     *
     * @return VirgilCard
     */
    public function createGlobal($identity, $identityType, VirgilKey $ownerKey, array $customFields = []);


    /**
     * Imports a virgil card from string representation.
     *
     * @param string $exportedVirgilCard
     *
     * @throws CardValidationException
     *
     * @return VirgilCardInterface
     */
    public function import($exportedVirgilCard);


    /**
     * Finds virgil cards by specified identities and type in application scope.
     *
     * @param string $identityType
     * @param array  $identities
     *
     * @return VirgilCardsInterface
     */
    public function find(array $identities, $identityType);


    /**
     * Finds virgil cards by specified identities and type in global scope.
     *
     * @param string $identityType
     * @param array  $identities
     *
     * @return VirgilCardsInterface
     */
    public function findGlobal(array $identities, $identityType);


    /**
     * Gets a virgil card from Virgil Security services by specified Card ID.
     *
     * @param string $cardId
     *
     * @return VirgilCardInterface
     */
    public function get($cardId);


    /**
     * Publishes a virgil card into global Virgil Services scope.
     *
     * @param VirgilCard              $virgilCard
     * @param IdentityValidationToken $identityValidationToken
     *
     * @return $this
     */
    public function publishGlobal(VirgilCard $virgilCard, IdentityValidationToken $identityValidationToken);


    /**
     * Revokes a virgil card from application Virgil Services scope.
     *
     * @param VirgilCard $virgilCard
     *
     * @return $this
     */
    public function revoke(VirgilCard $virgilCard);


    /**
     * Revokes a global virgil card from Virgil Security services.
     *
     * @param VirgilCard              $virgilCard
     * @param VirgilKey               $virgilKey
     * @param IdentityValidationToken $identityValidationToken
     *
     * @return $this
     */
    public function revokeGlobal(
        VirgilCard $virgilCard,
        VirgilKey $virgilKey,
        IdentityValidationToken $identityValidationToken
    );


    /**
     * Publishes a virgil card into application Virgil Services scope.
     *
     * @param VirgilCard $virgilCard
     *
     * @return $this
     */
    public function publish(VirgilCard $virgilCard);
}
