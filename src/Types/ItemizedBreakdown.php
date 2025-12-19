<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Traits\Breakdown;
use Payroc\Core\Json\JsonProperty;
use Payroc\Core\Types\ArrayType;

/**
 * Object that contains information about the breakdown of the transaction.
 */
class ItemizedBreakdown extends JsonSerializableType
{
    use Breakdown;

    /**
     * @var ?int $dutyAmount Amount of duties or fees that apply to the order. The value is in the currency's lowest denomination, for example, cents.
     */
    #[JsonProperty('dutyAmount')]
    public ?int $dutyAmount;

    /**
     * @var ?int $freightAmount Amount for shipping in the currency's lowest denomination, for example, cents.
     */
    #[JsonProperty('freightAmount')]
    public ?int $freightAmount;

    /**
     * @var ?ConvenienceFee $convenienceFee
     */
    #[JsonProperty('convenienceFee')]
    public ?ConvenienceFee $convenienceFee;

    /**
     * @var ?array<LineItem> $items Array of objects that contain information about each item that the customer purchased.
     */
    #[JsonProperty('items'), ArrayType([LineItem::class])]
    public ?array $items;

    /**
     * @param array{
     *   subtotal: int,
     *   taxes?: ?array<RetrievedTax>,
     *   cashbackAmount?: ?int,
     *   tip?: ?Tip,
     *   surcharge?: ?Surcharge,
     *   dualPricing?: ?DualPricing,
     *   dutyAmount?: ?int,
     *   freightAmount?: ?int,
     *   convenienceFee?: ?ConvenienceFee,
     *   items?: ?array<LineItem>,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->taxes = $values['taxes'] ?? null;
        $this->subtotal = $values['subtotal'];
        $this->cashbackAmount = $values['cashbackAmount'] ?? null;
        $this->tip = $values['tip'] ?? null;
        $this->surcharge = $values['surcharge'] ?? null;
        $this->dualPricing = $values['dualPricing'] ?? null;
        $this->dutyAmount = $values['dutyAmount'] ?? null;
        $this->freightAmount = $values['freightAmount'] ?? null;
        $this->convenienceFee = $values['convenienceFee'] ?? null;
        $this->items = $values['items'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
