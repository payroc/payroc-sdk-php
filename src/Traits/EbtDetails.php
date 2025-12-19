<?php

namespace Payroc\Traits;

use Payroc\Types\EbtDetailsBenefitCategory;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains information about the Electronic Benefit Transfer (EBT) transaction.
 *
 * @property value-of<EbtDetailsBenefitCategory> $benefitCategory
 * @property ?bool $withdrawal
 */
trait EbtDetails
{
    /**
     * Indicates if the balance relates to an EBT Cash account or an EBT SNAP account.
     *  - `cash` – EBT Cash
     *  - `foodStamp` – EBT SNAP
     *
     * @var value-of<EbtDetailsBenefitCategory> $benefitCategory
     */
    #[JsonProperty('benefitCategory')]
    public string $benefitCategory;

    /**
     * Indicates whether the customer wants to withdraw cash.
     *
     * **Note:** Cash withdrawals are available only from EBT Cash accounts.
     *
     * @var ?bool $withdrawal
     */
    #[JsonProperty('withdrawal')]
    public ?bool $withdrawal;
}
