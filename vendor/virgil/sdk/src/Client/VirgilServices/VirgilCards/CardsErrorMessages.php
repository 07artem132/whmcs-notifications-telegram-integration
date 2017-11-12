<?php
namespace Virgil\Sdk\Client\VirgilServices\VirgilCards;


use Virgil\Sdk\Client\VirgilServices\AbstractErrorMessages;

/**
 * Class keeps list of known Cards Service errors.
 */
class CardsErrorMessages extends AbstractErrorMessages
{
    /**
     * @inheritdoc
     */
    protected function getErrorsList()
    {
        return [
            10000 => "Internal application error.",
            20300 => "The Virgil access token was not specified or is invalid",
            20301 => "The Virgil authenticator service responded with an error",
            20302 => "The Virgil access token validation has failed on the Virgil Authenticator service",
            20303 => "The application was not found for the access token",
            20400 => "Request sign is invalid",
            20401 => "Request sign header is missing",
            20500 => "The Virgil Card is not available in this application",
            30000 => "JSON specified as a request is invalid",
            30010 => "A data inconsistency error",
            30100 => "Global Virgil Card identity type is invalid, because it can be only an 'email'",
            30101 => "Virgil Card scope must be either 'global' or 'application'",
            30102 => "Virgil Card id validation failed",
            30103 => "Virgil Card data parameter cannot contain more than 16 entries",
            30104 => "Virgil Card info parameter cannot be empty if specified and must contain 'device' and/or 'device_name' key",
            30105 => "Virgil Card info parameters length validation failed.The length cannot exceed 256 characters",
            30106 => "Virgil Card data parameter must be an associative array(https://en.wikipedia.org/wiki/Associative_array)",
            30107 => "A CSR parameter (content_snapshot) parameter is missing or is incorrect",
            30111 => "Virgil Card identities passed to search endpoint must be a list of non-empty strings",
            30113 => "Virgil Card identity type is invalid",
            30114 => "Segregated Virgil Card custom identity value must be a not empty string",
            30115 => "Virgil Card identity email is invalid",
            30116 => "Virgil Card identity application is invalid",
            30117 => "Public key length is invalid.It goes from 16 to 2048 bytes",
            30118 => "Public key must be base64-encoded string",
            30119 => "Virgil Card data parameter must be a key/value list of strings",
            30120 => "Virgil Card data parameters must be strings",
            30121 => "Virgil Card custom data entry value length validation failed.It mustn't exceed 256 characters",
            30122 => "Identity validation token is invalid",
            30123 => "SCR signs list parameter is missing or is invalid",
            30126 => "SCR sign item signer card id is irrelevant and doesn't match Virgil Card id or Application Id",
            30127 => "SCR sign item signed digest is invalid for the Virgil Card public key",
            30128 => "SCR sign item signed digest is invalid for the application",
            30131 => "Virgil Card id specified in the request body must match with the one passed in the URL",
            30134 => "Virgil Card data parameters key must be alphanumerical",
            30135 => "Virgil Card validation token must be an object with value parameter",
            30136 => "SCR sign item signed digest is invalid for the virgil identity service",
            30137 => "Global Virgil Card cannot be created unconfirmed(which means that Virgil Identity service sign is mandatory)",
            30138 => "Virgil Card with the same fingerprint exists already",
            30139 => "Virgil Card revocation reason isn't specified or is invalid",
            30140 => "SCR sign validation failed",
            30141 => "SCR one of signers Virgil Cards is not found ",
            30142 => "SCR sign item is invalid or missing for the Client",
        ];
    }
}
