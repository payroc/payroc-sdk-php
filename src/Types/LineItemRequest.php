<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Traits\LineItemBase;
use Payroc\Core\Json\JsonProperty;
use Payroc\Core\Types\ArrayType;

class LineItemRequest extends JsonSerializableType
{
    use LineItemBase;

    /**
     * @var ?array<Tax> $taxes Array of objects that contain information about each tax that applies to the item.
     */
    #[JsonProperty('taxes'), ArrayType([Tax::class])]
    public ?array $taxes;

    /**
     * @param array{
     *   unitPrice: float,
     *   quantity: float,
     *   commodityCode?: ?string,
     *   productCode?: ?string,
     *   description?: ?string,
     *   unitOfMeasure?: ?value-of<UnitOfMeasure>,
     *   discountRate?: ?float,
     *   taxes?: ?array<Tax>,
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
        $this->taxes = $values['taxes'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
