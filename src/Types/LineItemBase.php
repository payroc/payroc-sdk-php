<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * List of line items.
 */
class LineItemBase extends JsonSerializableType
{
    /**
     * @var ?string $commodityCode Commodity code of the item.
     */
    #[JsonProperty('commodityCode')]
    public ?string $commodityCode;

    /**
     * @var ?string $productCode Product code of the item.
     */
    #[JsonProperty('productCode')]
    public ?string $productCode;

    /**
     * @var ?string $description Description of the item.
     */
    #[JsonProperty('description')]
    public ?string $description;

    /**
     * @var ?value-of<UnitOfMeasure> $unitOfMeasure
     */
    #[JsonProperty('unitOfMeasure')]
    public ?string $unitOfMeasure;

    /**
     * @var float $unitPrice Price of each unit.
     */
    #[JsonProperty('unitPrice')]
    public float $unitPrice;

    /**
     * @var float $quantity Number of units.
     */
    #[JsonProperty('quantity')]
    public float $quantity;

    /**
     * @var ?float $discountRate Discount rate that the merchant applies to the item.
     */
    #[JsonProperty('discountRate')]
    public ?float $discountRate;

    /**
     * @param array{
     *   unitPrice: float,
     *   quantity: float,
     *   commodityCode?: ?string,
     *   productCode?: ?string,
     *   description?: ?string,
     *   unitOfMeasure?: ?value-of<UnitOfMeasure>,
     *   discountRate?: ?float,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->commodityCode = $values['commodityCode'] ?? null;
        $this->productCode = $values['productCode'] ?? null;
        $this->description = $values['description'] ?? null;
        $this->unitOfMeasure = $values['unitOfMeasure'] ?? null;
        $this->unitPrice = $values['unitPrice'];
        $this->quantity = $values['quantity'];
        $this->discountRate = $values['discountRate'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
