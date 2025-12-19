<?php

namespace Payroc\Traits;

use Payroc\Types\Tip;
use Payroc\Types\Surcharge;
use Payroc\Types\DualPricing;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains information about the breakdown of the transaction.
 *
 * @property int $subtotal
 * @property ?int $cashbackAmount
 * @property ?Tip $tip
 * @property ?Surcharge $surcharge
 * @property ?DualPricing $dualPricing
 */
trait BreakdownBase
{
    /**
     * @var int $subtotal Amount of the transaction before tax and fees. The value is in the currency’s lowest denomination, for example, cents.
     */
    #[JsonProperty('subtotal')]
    public int $subtotal;

    /**
     * @var ?int $cashbackAmount Amount of cashback for the transaction.
     */
    #[JsonProperty('cashbackAmount')]
    public ?int $cashbackAmount;

    /**
     * @var ?Tip $tip Object that contains tip information for the transaction.
     */
    #[JsonProperty('tip')]
    public ?Tip $tip;

    /**
     * @var ?Surcharge $surcharge Object that contains surcharge information for the transaction.
     */
    #[JsonProperty('surcharge')]
    public ?Surcharge $surcharge;

    /**
     * @var ?DualPricing $dualPricing Object that contains dual pricing information for the transaction.
     */
    #[JsonProperty('dualPricing')]
    public ?DualPricing $dualPricing;
}
