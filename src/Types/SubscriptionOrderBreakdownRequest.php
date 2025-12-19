<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Traits\SubscriptionOrderBreakdownBase;
use Payroc\Core\Json\JsonProperty;
use Payroc\Core\Types\ArrayType;

/**
 * Object that contains information about the taxes to apply to the transaction.
 */
class SubscriptionOrderBreakdownRequest extends JsonSerializableType
{
    use SubscriptionOrderBreakdownBase;

    /**
     * @var ?array<TaxRate> $taxes Array of tax objects.
     */
    #[JsonProperty('taxes'), ArrayType([TaxRate::class])]
    public ?array $taxes;

    /**
     * @param array{
     *   subtotal: int,
     *   convenienceFee?: ?ConvenienceFee,
     *   taxes?: ?array<TaxRate>,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->subtotal = $values['subtotal'];
        $this->convenienceFee = $values['convenienceFee'] ?? null;
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
