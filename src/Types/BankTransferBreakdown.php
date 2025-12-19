<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Traits\BankTransferBreakdownBase;
use Payroc\Core\Json\JsonProperty;
use Payroc\Core\Types\ArrayType;

/**
 * Object that contains information about the transaction.
 */
class BankTransferBreakdown extends JsonSerializableType
{
    use BankTransferBreakdownBase;

    /**
     * @var ?array<RetrievedTax> $taxes Array of tax objects.
     */
    #[JsonProperty('taxes'), ArrayType([RetrievedTax::class])]
    public ?array $taxes;

    /**
     * @param array{
     *   subtotal: int,
     *   tip?: ?Tip,
     *   taxes?: ?array<RetrievedTax>,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->subtotal = $values['subtotal'];
        $this->tip = $values['tip'] ?? null;
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
