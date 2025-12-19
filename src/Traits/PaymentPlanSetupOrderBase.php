<?php

namespace Payroc\Traits;

use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains information about the initial cost that a customer pays to set up the subscription.
 *
 * @property ?int $amount
 * @property ?string $description
 */
trait PaymentPlanSetupOrderBase
{
    /**
     * @var ?int $amount Total amount before surcharges. The value is in the currency's lowest denomination, for example, cents.
     */
    #[JsonProperty('amount')]
    public ?int $amount;

    /**
     * @var ?string $description Description of the transaction.
     */
    #[JsonProperty('description')]
    public ?string $description;
}
