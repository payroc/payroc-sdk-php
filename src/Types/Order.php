<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;
use DateTime;
use Payroc\Core\Types\Date;

/**
 * Object that contains details about the transaction.
 */
class Order extends JsonSerializableType
{
    /**
     * @var string $orderId Unique identifier that the merchant assigns to the transaction.
     */
    #[JsonProperty('orderId')]
    public string $orderId;

    /**
     * @var ?DateTime $dateTime Date and time that the processor processed the transaction. Our gateway returns this value in the [ISO 8601](https://www.iso.org/iso-8601-date-and-time-format.html) format.
     */
    #[JsonProperty('dateTime'), Date(Date::TYPE_DATETIME)]
    public ?DateTime $dateTime;

    /**
     * @var ?string $description Description of the transaction.
     */
    #[JsonProperty('description')]
    public ?string $description;

    /**
     * @var int $amount Total amount of the transaction. The value is in the currency’s lowest denomination, for example, cents.
     */
    #[JsonProperty('amount')]
    public int $amount;

    /**
     * @var value-of<Currency> $currency
     */
    #[JsonProperty('currency')]
    public string $currency;

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
