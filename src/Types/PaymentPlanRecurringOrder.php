<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Traits\PaymentPlanRecurringOrderBase;
use Payroc\Core\Json\JsonProperty;

class PaymentPlanRecurringOrder extends JsonSerializableType
{
    use PaymentPlanRecurringOrderBase;

    /**
     * @var ?PaymentPlanOrderBreakdown $breakdown
     */
    #[JsonProperty('breakdown')]
    public ?PaymentPlanOrderBreakdown $breakdown;

    /**
     * @param array{
     *   amount?: ?int,
     *   description?: ?string,
     *   breakdown?: ?PaymentPlanOrderBreakdown,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->amount = $values['amount'] ?? null;
        $this->description = $values['description'] ?? null;
        $this->breakdown = $values['breakdown'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
