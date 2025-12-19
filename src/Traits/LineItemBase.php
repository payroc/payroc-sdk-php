<?php

namespace Payroc\Traits;

use Payroc\Types\UnitOfMeasure;
use Payroc\Core\Json\JsonProperty;

/**
 * List of line items.
 *
 * @property ?string $commodityCode
 * @property ?string $productCode
 * @property ?string $description
 * @property ?value-of<UnitOfMeasure> $unitOfMeasure
 * @property float $unitPrice
 * @property float $quantity
 * @property ?float $discountRate
 */
trait LineItemBase
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
}
