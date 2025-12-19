<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains information about the cost of each payment.
 * **Note:** Send this object only if the value for **type** is `automatic`.
 */
class PaymentPlanRecurringOrderBase extends JsonSerializableType
{
    /**
     * @var ?int $amount Total amount before surcharges. The value is in the currency's lowest denomination, for example, cents.
     */
    #[JsonProperty('amount')]
    public ?int $amount;

    /**
     * @var ?string $description Description of the transaction.
     */
    #[JsonProperty('description')]
    public ?string $description;

    /**
     * @param array{
     *   amount?: ?int,
     *   description?: ?string,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->amount = $values['amount'] ?? null;
        $this->description = $values['description'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
