<?php

namespace Payroc\Traits;

use Payroc\Types\Tip;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains information about the transaction.
 *
 * @property int $subtotal
 * @property ?Tip $tip
 */
trait BankTransferBreakdownBase
{
    /**
     * @var int $subtotal Total amount of the transaction before tax and tip. The value is in the currency's lowest denomination, for example, cents.
     */
    #[JsonProperty('subtotal')]
    public int $subtotal;

    /**
     * @var ?Tip $tip Object that contains tip information for the transaction.
     */
    #[JsonProperty('tip')]
    public ?Tip $tip;
}
