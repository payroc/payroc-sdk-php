<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Traits\SubscriptionPaymentOrderBase;
use Payroc\Core\Json\JsonProperty;

class SubscriptionPaymentOrderRequest extends JsonSerializableType
{
    use SubscriptionPaymentOrderBase;

    /**
     * @var ?SubscriptionOrderBreakdownRequest $breakdown
     */
    #[JsonProperty('breakdown')]
    public ?SubscriptionOrderBreakdownRequest $breakdown;

    /**
     * @param array{
     *   orderId?: ?string,
     *   amount?: ?int,
     *   description?: ?string,
     *   breakdown?: ?SubscriptionOrderBreakdownRequest,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->orderId = $values['orderId'] ?? null;
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
