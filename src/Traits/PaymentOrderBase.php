<?php

namespace Payroc\Traits;

use DateTime;
use Payroc\Types\Currency;
use Payroc\Types\DccOffer;
use Payroc\Types\StandingInstructions;
use Payroc\Core\Json\JsonProperty;
use Payroc\Core\Types\Date;

/**
 * Object that contains information about the payment.
 *
 * @property ?string $orderId
 * @property ?DateTime $dateTime
 * @property ?string $description
 * @property ?int $amount
 * @property ?value-of<Currency> $currency
 * @property ?DccOffer $dccOffer
 * @property ?StandingInstructions $standingInstructions
 */
trait PaymentOrderBase
{
    /**
     * @var ?string $orderId A unique identifier assigned by the merchant.
     */
    #[JsonProperty('orderId')]
    public ?string $orderId;

    /**
     * @var ?DateTime $dateTime Date and time that the processor processed the transaction. Our gateway returns this value in the ISO 8601 format.
     */
    #[JsonProperty('dateTime'), Date(Date::TYPE_DATETIME)]
    public ?DateTime $dateTime;

    /**
     * @var ?string $description Description of the transaction.
     */
    #[JsonProperty('description')]
    public ?string $description;

    /**
     * @var ?int $amount Total amount of the transaction. The value is in the currency’s lowest denomination, for example, cents.
     */
    #[JsonProperty('amount')]
    public ?int $amount;

    /**
     * @var ?value-of<Currency> $currency
     */
    #[JsonProperty('currency')]
    public ?string $currency;

    /**
     * @var ?DccOffer $dccOffer
     */
    #[JsonProperty('dccOffer')]
    public ?DccOffer $dccOffer;

    /**
     * @var ?StandingInstructions $standingInstructions
     */
    #[JsonProperty('standingInstructions')]
    public ?StandingInstructions $standingInstructions;
}
