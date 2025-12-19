<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains information about the initial payment for the payment instruction.
 */
class FirstTxnReferenceData extends JsonSerializableType
{
    /**
     * Unique identifier of the first payment.
     * **Note:** We recommend that you always send a value for **paymentId**.
     *
     * @var ?string $paymentId
     */
    #[JsonProperty('paymentId')]
    public ?string $paymentId;

    /**
     * @var ?string $cardSchemeReferenceId Identifier that the card brand assigns to the payment instruction.
     */
    #[JsonProperty('cardSchemeReferenceId')]
    public ?string $cardSchemeReferenceId;

    /**
     * @param array{
     *   paymentId?: ?string,
     *   cardSchemeReferenceId?: ?string,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->paymentId = $values['paymentId'] ?? null;
        $this->cardSchemeReferenceId = $values['cardSchemeReferenceId'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
