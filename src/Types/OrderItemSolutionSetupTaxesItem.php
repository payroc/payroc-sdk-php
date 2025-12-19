<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Tax that applies to the merchant's transactions.
 */
class OrderItemSolutionSetupTaxesItem extends JsonSerializableType
{
    /**
     * @var float $taxRate Rate of tax that the terminal applies to each transaction.
     */
    #[JsonProperty('taxRate')]
    public float $taxRate;

    /**
     * @var string $taxLabel Short description of the tax rate, for example, "Sales Tax".
     */
    #[JsonProperty('taxLabel')]
    public string $taxLabel;

    /**
     * @param array{
     *   taxRate: float,
     *   taxLabel: string,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->taxRate = $values['taxRate'];
        $this->taxLabel = $values['taxLabel'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
