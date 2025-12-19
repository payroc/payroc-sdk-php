<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Traits\Order;
use Payroc\Core\Json\JsonProperty;
use DateTime;

/**
 * Object that contains information about the payment.
 */
class PaymentInstructionOrder extends JsonSerializableType
{
    use Order;

    /**
     * @var ?BreakdownForPaymentInstructions $breakdown
     */
    #[JsonProperty('breakdown')]
    public ?BreakdownForPaymentInstructions $breakdown;

    /**
     * @param array{
     *   orderId: string,
     *   amount: int,
     *   currency: value-of<Currency>,
     *   dateTime?: ?DateTime,
     *   description?: ?string,
     *   breakdown?: ?BreakdownForPaymentInstructions,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->orderId = $values['orderId'];
        $this->dateTime = $values['dateTime'] ?? null;
        $this->description = $values['description'] ?? null;
        $this->amount = $values['amount'];
        $this->currency = $values['currency'];
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
