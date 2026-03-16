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
     *   orderId: string,
     *   amount: int,
     *   currency: value-of<Currency>,
     *   dateTime?: ?DateTime,
     *   description?: ?string,
     *   breakdown?: ?BankTransferRequestBreakdown,
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
