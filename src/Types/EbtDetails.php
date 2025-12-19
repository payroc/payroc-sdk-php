<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains information about the Electronic Benefit Transfer (EBT) transaction.
 */
class EbtDetails extends JsonSerializableType
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

    /**
     * @param array{
     *   benefitCategory: value-of<EbtDetailsBenefitCategory>,
     *   withdrawal?: ?bool,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->benefitCategory = $values['benefitCategory'];
        $this->withdrawal = $values['withdrawal'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
