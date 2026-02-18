<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains information about the order.
 */
class MultiUsePaymentLinkOrder extends JsonSerializableType
{
    /**
     * @var ?string $description A brief description of the transaction.
     */
    #[JsonProperty('description')]
    public ?string $description;

    /**
     * Polymorphic object that indicates who enters the amount for the payment link.
     *
     * The value of the type parameter determines which variant you should use:
     * -	`prompt` - Customer enters the amount.
     * -	`preset` - Merchant sets the amount.
     *
     * @var MultiUsePaymentLinkOrderCharge $charge
     */
    #[JsonProperty('charge')]
    public MultiUsePaymentLinkOrderCharge $charge;

    /**
     * @param array{
     *   charge: MultiUsePaymentLinkOrderCharge,
     *   description?: ?string,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->description = $values['description'] ?? null;
        $this->charge = $values['charge'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
