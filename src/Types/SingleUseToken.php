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
     * @var ?SingleUseTokenPaymentMethod $paymentMethod Object that contains information about the customer's payment details.
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
     * @var SingleUseTokenSource $source Object that contains information about the payment method that we tokenized.
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
