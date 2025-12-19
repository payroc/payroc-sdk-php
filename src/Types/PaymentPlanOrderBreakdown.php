<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Traits\PaymentPlanOrderBreakdownBase;
use Payroc\Core\Json\JsonProperty;
use Payroc\Core\Types\ArrayType;

class PaymentPlanOrderBreakdown extends JsonSerializableType
{
    use PaymentPlanOrderBreakdownBase;

    /**
     * @var ?array<RetrievedTax> $taxes Array of tax objects.
     */
    #[JsonProperty('taxes'), ArrayType([RetrievedTax::class])]
    public ?array $taxes;

    /**
     * @param array{
     *   subtotal: int,
     *   taxes?: ?array<RetrievedTax>,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->subtotal = $values['subtotal'];
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
