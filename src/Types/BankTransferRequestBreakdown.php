<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Traits\BankTransferBreakdownBase;
use Payroc\Core\Json\JsonProperty;
use Payroc\Core\Types\ArrayType;

/**
 * Object that contains information about the transaction.
 */
class BankTransferRequestBreakdown extends JsonSerializableType
{
    use BankTransferBreakdownBase;

    /**
     * @var ?array<TaxRate> $taxes Array of tax objects.
     */
    #[JsonProperty('taxes'), ArrayType([TaxRate::class])]
    public ?array $taxes;

    /**
     * @param array{
     *   subtotal: int,
     *   tip?: ?Tip,
     *   taxes?: ?array<TaxRate>,
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
