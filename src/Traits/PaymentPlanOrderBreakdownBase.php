<?php

namespace Payroc\Traits;

use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains information about the taxes that apply to the transaction.
 *
 * @property int $subtotal
 */
trait PaymentPlanOrderBreakdownBase
{
    /**
     * @var int $subtotal Total amount for the transaction before tax. The value is in the currency's lowest denomination, for example, cents.
     */
    #[JsonProperty('subtotal')]
    public int $subtotal;
}
