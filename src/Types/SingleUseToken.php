<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;
use DateTime;
use Payroc\Core\Types\Date;

class SingleUseToken extends JsonSerializableType
{
    /**
     * @var ?string $processingTerminalId Unique identifier that we assigned to the terminal.
     */
    #[JsonProperty('processingTerminalId')]
    public ?string $processingTerminalId;

    /**
     * @var ?string $operator Operator who initiated the request.
     */
    #[JsonProperty('operator')]
    public ?string $operator;

    /**
     * @var ?SingleUseTokenPaymentMethod $paymentMethod Polymorphic object that contains payment card details.
     */
    #[JsonProperty('paymentMethod')]
    public ?SingleUseTokenPaymentMethod $paymentMethod;

    /**
     * Unique identifier that our gateway assigned to the payment details.
     * **Note:** Merchants can use the token with other terminals linked to their account.
     *
     * @var ?string $token
     */
    #[JsonProperty('token')]
    public ?string $token;

    /**
     * @var ?DateTime $expiresAt Date and time that the token expires. We return this value in the [ISO 8601](https://www.iso.org/iso-8601-date-and-time-format.html) format.
     */
    #[JsonProperty('expiresAt'), Date(Date::TYPE_DATETIME)]
    public ?DateTime $expiresAt;

    /**
     * Polymorphic object that contains the payment method that we tokenized.
     *
     * The value of the type parameter determines which variant you should use:
     * -	`ach` - Automated Clearing House (ACH) details
     * -	`pad` - Pre-authorized debit (PAD) details
     * -	`card` - Payment card details
     *
     * @var SingleUseTokenSource $source
     */
    #[JsonProperty('source')]
    public SingleUseTokenSource $source;

    /**
     * @param array{
     *   source: SingleUseTokenSource,
     *   processingTerminalId?: ?string,
     *   operator?: ?string,
     *   paymentMethod?: ?SingleUseTokenPaymentMethod,
     *   token?: ?string,
     *   expiresAt?: ?DateTime,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->processingTerminalId = $values['processingTerminalId'] ?? null;
        $this->operator = $values['operator'] ?? null;
        $this->paymentMethod = $values['paymentMethod'] ?? null;
        $this->token = $values['token'] ?? null;
        $this->expiresAt = $values['expiresAt'] ?? null;
        $this->source = $values['source'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
