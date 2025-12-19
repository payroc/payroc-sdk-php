<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains information about the total funds available in the card.
 */
class CardBalance extends JsonSerializableType
{
    /**
     * Indicates if the balance relates to an EBT Cash account or EBT SNAP account.
     * - `cash` – EBT Cash
     * - `foodStamp` – EBT SNAP
     *
     * @var value-of<CardBalanceBenefitCategory> $benefitCategory
     */
    #[JsonProperty('benefitCategory')]
    public string $benefitCategory;

    /**
     * @var int $amount Current balance of the account. This value is in the currency's lowest denomination, for example, cents.
     */
    #[JsonProperty('amount')]
    public int $amount;

    /**
     * @var value-of<Currency> $currency
     */
    #[JsonProperty('currency')]
    public string $currency;

    /**
     * @param array{
     *   benefitCategory: value-of<CardBalanceBenefitCategory>,
     *   amount: int,
     *   currency: value-of<Currency>,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->benefitCategory = $values['benefitCategory'];
        $this->amount = $values['amount'];
        $this->currency = $values['currency'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
