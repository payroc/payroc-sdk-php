<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Traits\SubscriptionRecurringOrderBase;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains information about the cost of each payment.
 * **Note:** Send this object only if the value for **type** is `automatic`.
 */
class SubscriptionRecurringOrderRequest extends JsonSerializableType
{
    use SubscriptionRecurringOrderBase;

    /**
     * @var ?SubscriptionOrderBreakdownRequest $breakdown
     */
    #[JsonProperty('breakdown')]
    public ?SubscriptionOrderBreakdownRequest $breakdown;

    /**
     * @param array{
     *   amount?: ?int,
     *   description?: ?string,
     *   breakdown?: ?SubscriptionOrderBreakdownRequest,
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
