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
     * @var MultiUsePaymentLinkOrderCharge $charge Indicates whether the merchant or the customer enters the amount for the transaction.
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
