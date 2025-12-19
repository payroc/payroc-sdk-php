<?php

namespace Payroc\Traits;

use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains information about the initial cost that a customer pays to set up the subscription.
 *
 * @property ?string $orderId
 * @property ?int $amount
 * @property ?string $description
 */
trait SubscriptionPaymentOrderBase
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
}
