<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains information about the initial cost that a customer pays to set up the subscription.
 */
class SubscriptionPaymentOrderBase extends JsonSerializableType
{
    /**
     * @var ?string $orderId A unique identifier assigned by the merchant.
     */
    #[JsonProperty('orderId')]
    public ?string $orderId;

    /**
     * Total amount for the transaction. The value is in the currency's lowest denomination, for example, cents.<br/>
     * <br/>**Important:** Do not add the surcharge to the amount parameter in the request. If the transaction is eligible for surcharging, our gateway adds the surcharge to the amount in the request, and then returns the updated amount in the response.
     *
     * @var ?int $amount
     */
    #[JsonProperty('amount')]
    public ?int $amount;

    /**
     * @var ?string $description Description of the transaction.
     */
    #[JsonProperty('description')]
    public ?string $description;

    /**
     * @param array{
     *   orderId?: ?string,
     *   amount?: ?int,
     *   description?: ?string,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->orderId = $values['orderId'] ?? null;
        $this->amount = $values['amount'] ?? null;
        $this->description = $values['description'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
