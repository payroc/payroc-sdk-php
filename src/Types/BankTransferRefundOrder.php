<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;
use DateTime;
use Payroc\Core\Types\Date;

/**
 * Object that contains information about the order.
 */
class BankTransferRefundOrder extends JsonSerializableType
{
    /**
     * @var ?string $orderId Unique identifier that the merchant assigned to the transaction.
     */
    #[JsonProperty('orderId')]
    public ?string $orderId;

    /**
     * @var ?DateTime $dateTime Date and time that we processed the transaction. We return this value in the ISO 8601 format.
     */
    #[JsonProperty('dateTime'), Date(Date::TYPE_DATETIME)]
    public ?DateTime $dateTime;

    /**
     * @var ?string $description Description of the refund.
     */
    #[JsonProperty('description')]
    public ?string $description;

    /**
     * @var ?int $amount Total amount of the transaction. The value is in the currency's lowest denomination, for example, cents.
     */
    #[JsonProperty('amount')]
    public ?int $amount;

    /**
     * @var ?value-of<Currency> $currency
     */
    #[JsonProperty('currency')]
    public ?string $currency;

    /**
     * @param array{
     *   orderId?: ?string,
     *   dateTime?: ?DateTime,
     *   description?: ?string,
     *   amount?: ?int,
     *   currency?: ?value-of<Currency>,
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
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
