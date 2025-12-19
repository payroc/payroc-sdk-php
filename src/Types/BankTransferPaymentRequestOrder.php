<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Traits\BankTransferPaymentOrderBase;
use Payroc\Core\Json\JsonProperty;
use DateTime;

/**
 * Object that contains information about the transaction.
 */
class BankTransferPaymentRequestOrder extends JsonSerializableType
{
    use BankTransferPaymentOrderBase;

    /**
     * @var ?BankTransferRequestBreakdown $breakdown
     */
    #[JsonProperty('breakdown')]
    public ?BankTransferRequestBreakdown $breakdown;

    /**
     * @param array{
     *   orderId?: ?string,
     *   dateTime?: ?DateTime,
     *   description?: ?string,
     *   amount?: ?int,
     *   currency?: ?value-of<Currency>,
     *   breakdown?: ?BankTransferRequestBreakdown,
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
