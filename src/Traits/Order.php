<?php

namespace Payroc\Traits;

use DateTime;
use Payroc\Types\Currency;
use Payroc\Core\Json\JsonProperty;
use Payroc\Core\Types\Date;

/**
 * Object that contains details about the transaction.
 *
 * @property string $orderId
 * @property ?DateTime $dateTime
 * @property ?string $description
 * @property int $amount
 * @property value-of<Currency> $currency
 */
trait Order
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
}
