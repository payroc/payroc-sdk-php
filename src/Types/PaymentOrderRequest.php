<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Traits\PaymentOrderBase;
use Payroc\Core\Json\JsonProperty;
use DateTime;

/**
 * Object that contains information about the payment.
 */
class PaymentOrderRequest extends JsonSerializableType
{
    use PaymentOrderBase;

    /**
     * @var ?ItemizedBreakdownRequest $breakdown
     */
    #[JsonProperty('breakdown')]
    public ?ItemizedBreakdownRequest $breakdown;

    /**
     * @param array{
     *   orderId?: ?string,
     *   dateTime?: ?DateTime,
     *   description?: ?string,
     *   amount?: ?int,
     *   currency?: ?value-of<Currency>,
     *   dccOffer?: ?DccOffer,
     *   standingInstructions?: ?StandingInstructions,
     *   breakdown?: ?ItemizedBreakdownRequest,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->orderId = $values['orderId'] ?? null;
        $this->dateTime = $values['dateTime'] ?? null;
        $this->description = $values['description'] ?? null;
        $this->amount = $values['amount'] ?? null;
        $this->currency = $values['currency'] ?? null;
        $this->dccOffer = $values['dccOffer'] ?? null;
        $this->standingInstructions = $values['standingInstructions'] ?? null;
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
