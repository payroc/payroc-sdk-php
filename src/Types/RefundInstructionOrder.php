<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Traits\Order;
use DateTime;

/**
 * Object that contains information about the refund.
 */
class RefundInstructionOrder extends JsonSerializableType
{
    use Order;


    /**
     * @param array{
     *   orderId: string,
     *   amount: int,
     *   currency: value-of<Currency>,
     *   dateTime?: ?DateTime,
     *   description?: ?string,
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
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
