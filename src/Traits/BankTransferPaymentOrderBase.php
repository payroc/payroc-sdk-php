<?php

namespace Payroc\Traits;

use DateTime;
use Payroc\Types\Currency;
use Payroc\Core\Json\JsonProperty;
use Payroc\Core\Types\Date;

/**
 * Object that contains information about the transaction.
 *
 * @property ?string $orderId
 * @property ?DateTime $dateTime
 * @property ?string $description
 * @property ?int $amount
 * @property ?value-of<Currency> $currency
 */
trait BankTransferPaymentOrderBase
{
    /**
     * @var ?string $orderId A unique identifier assigned by the merchant.
     */
    #[JsonProperty('orderId')]
    public ?string $orderId;

    /**
     * @var ?DateTime $dateTime The processing date and time of the transaction represented as per [ISO 8601](https://en.wikipedia.org/wiki/ISO_8601) standard.
     */
    #[JsonProperty('dateTime'), Date(Date::TYPE_DATETIME)]
    public ?DateTime $dateTime;

    /**
     * @var ?string $description A brief description of the transaction.
     */
    #[JsonProperty('description')]
    public ?string $description;

    /**
     * @var ?int $amount The total amount in the currency's lowest denomination. For example, cents.
     */
    #[JsonProperty('amount')]
    public ?int $amount;

    /**
     * @var ?value-of<Currency> $currency
     */
    #[JsonProperty('currency')]
    public ?string $currency;
}
