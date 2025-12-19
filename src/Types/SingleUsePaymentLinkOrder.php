<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains information about the order.
 */
class SingleUsePaymentLinkOrder extends JsonSerializableType
{
    /**
     * @var string $orderId Unique identifier that the merchant assigned to the order.
     */
    #[JsonProperty('orderId')]
    public string $orderId;

    /**
     * @var ?string $description A brief description of the transaction.
     */
    #[JsonProperty('description')]
    public ?string $description;

    /**
     * @var SingleUsePaymentLinkOrderCharge $charge Indicates whether the merchant or the customer enters the amount for the transaction.
     */
    #[JsonProperty('charge')]
    public SingleUsePaymentLinkOrderCharge $charge;

    /**
     * @param array{
     *   orderId: string,
     *   charge: SingleUsePaymentLinkOrderCharge,
     *   description?: ?string,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->orderId = $values['orderId'];
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
