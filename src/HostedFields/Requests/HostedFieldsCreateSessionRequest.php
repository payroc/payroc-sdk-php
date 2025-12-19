<?php

namespace Payroc\HostedFields\Requests;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;
use Payroc\HostedFields\Types\HostedFieldsCreateSessionRequestScenario;

class HostedFieldsCreateSessionRequest extends JsonSerializableType
{
    /**
     * @var string $idempotencyKey Unique identifier that you generate for each request. You must use the [UUID v4 format](https://www.rfc-editor.org/rfc/rfc4122) for the identifier. For more information about the idempotency key, go to [Idempotency](https://docs.payroc.com/api/idempotency).
     */
    public string $idempotencyKey;

    /**
     * Version of the Hosted Fields JavaScript library that you are using.
     *
     * The current production version is `1.6.0.172441`.
     *
     * @var string $libVersion
     */
    #[JsonProperty('libVersion')]
    public string $libVersion;

    /**
     * Indicates if a merchant wants to take a payment or tokenize a customer's payment details:
     *
     * - `payment` - The merchant wants to run a sale or run a sale and tokenize in the same transaction.
     * - `tokenization` - The merchant wants to save the customer's payment details to take a payment later or to update a customer's payment details that they've already saved.
     *
     * @var value-of<HostedFieldsCreateSessionRequestScenario> $scenario
     */
    #[JsonProperty('scenario')]
    public string $scenario;

    /**
     * Unique identifier that represents a customer's payment details.
     *
     * If a merchant wants to update a customer's payment details that are linked to a secure token, include the secureTokenId in your request.
     *
     * @var ?string $secureTokenId
     */
    #[JsonProperty('secureTokenId')]
    public ?string $secureTokenId;

    /**
     * @param array{
     *   idempotencyKey: string,
     *   libVersion: string,
     *   scenario: value-of<HostedFieldsCreateSessionRequestScenario>,
     *   secureTokenId?: ?string,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->idempotencyKey = $values['idempotencyKey'];
        $this->libVersion = $values['libVersion'];
        $this->scenario = $values['scenario'];
        $this->secureTokenId = $values['secureTokenId'] ?? null;
    }
}
