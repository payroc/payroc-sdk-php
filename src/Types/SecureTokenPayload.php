<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains information about the secure token that represents the customer’s payment details.
 */
class SecureTokenPayload extends JsonSerializableType
{
    /**
     * Indicates the customer’s account type.
     *
     * **Note:** Send a value for accountType only if the secure token represents bank account details.
     *
     * @var ?value-of<SecureTokenPayloadAccountType> $accountType
     */
    #[JsonProperty('accountType')]
    public ?string $accountType;

    /**
     * @var string $token Unique token that the gateway assigned to the payment details.
     */
    #[JsonProperty('token')]
    public string $token;

    /**
     * Indicates how the customer authorized the ACH transaction. Send one of the following values:
     *
     * - `web` – Online transaction.
     * - `tel` – Telephone transaction.
     * - `ccd` – Corporate credit card or debit card transaction.
     * - `ppd` – Pre-arranged transaction.
     *
     * @var ?value-of<SecureTokenPayloadSecCode> $secCode
     */
    #[JsonProperty('secCode')]
    public ?string $secCode;

    /**
     * @param array{
     *   token: string,
     *   accountType?: ?value-of<SecureTokenPayloadAccountType>,
     *   secCode?: ?value-of<SecureTokenPayloadSecCode>,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->accountType = $values['accountType'] ?? null;
        $this->token = $values['token'];
        $this->secCode = $values['secCode'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
