<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Traits\BreakdownBase;
use Payroc\Core\Json\JsonProperty;
use Payroc\Core\Types\ArrayType;

class BreakdownRequest extends JsonSerializableType
{
    use BreakdownBase;

    /**
     * @var ?array<Tax> $taxes List of taxes.
     */
    #[JsonProperty('taxes'), ArrayType([Tax::class])]
    public ?array $taxes;

    /**
     * @param array{
     *   subtotal: int,
     *   cashbackAmount?: ?int,
     *   tip?: ?Tip,
     *   surcharge?: ?Surcharge,
     *   dualPricing?: ?DualPricing,
     *   taxes?: ?array<Tax>,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->subtotal = $values['subtotal'];
        $this->cashbackAmount = $values['cashbackAmount'] ?? null;
        $this->tip = $values['tip'] ?? null;
        $this->surcharge = $values['surcharge'] ?? null;
        $this->dualPricing = $values['dualPricing'] ?? null;
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
