<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Traits\SubscriptionOrderBreakdownBase;
use Payroc\Core\Json\JsonProperty;
use Payroc\Core\Types\ArrayType;

/**
 * Object that contains information about the surcharge and taxes that apply to the transaction.
 */
class SubscriptionOrderBreakdown extends JsonSerializableType
{
    use SubscriptionOrderBreakdownBase;

    /**
     * @var ?Surcharge $surcharge Object that contains information about the [surcharge](https://docs.payroc.com/knowledge/card-payments/credit-card-surcharging) that we applied to the transaction.
     */
    #[JsonProperty('surcharge')]
    public ?Surcharge $surcharge;

    /**
     * @var ?array<RetrievedTax> $taxes Array of tax objects.
     */
    #[JsonProperty('taxes'), ArrayType([RetrievedTax::class])]
    public ?array $taxes;

    /**
     * @param array{
     *   subtotal: int,
     *   convenienceFee?: ?ConvenienceFee,
     *   surcharge?: ?Surcharge,
     *   taxes?: ?array<RetrievedTax>,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->subtotal = $values['subtotal'];
        $this->convenienceFee = $values['convenienceFee'] ?? null;
        $this->surcharge = $values['surcharge'] ?? null;
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
