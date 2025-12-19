<?php

namespace Payroc\Traits;

use Payroc\Types\ConvenienceFee;
use Payroc\Core\Json\JsonProperty;

/**
 * @property int $subtotal
 * @property ?ConvenienceFee $convenienceFee
 */
trait SubscriptionOrderBreakdownBase
{
    /**
     * @var int $subtotal Total amount for the transaction before tax. The value is in the currency's lowest denomination, for example, cents.
     */
    #[JsonProperty('subtotal')]
    public int $subtotal;

    /**
     * @var ?ConvenienceFee $convenienceFee
     */
    #[JsonProperty('convenienceFee')]
    public ?ConvenienceFee $convenienceFee;
}
