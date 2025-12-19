<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains a tax rate with a short description of the tax rate.
 */
class ProcessingTerminalTaxesItem extends JsonSerializableType
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
