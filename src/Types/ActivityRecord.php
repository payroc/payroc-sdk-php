<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Array of activityRecord objects.
 */
class ActivityRecord extends JsonSerializableType
{
    /**
     * @var int $id Unique identifier that we assigned to the activity.
     */
    #[JsonProperty('id')]
    public int $id;

    /**
     * @var string $date Date that we moved the funds.
     */
    #[JsonProperty('date')]
    public string $date;

    /**
     * @var string $merchant Doing business as (DBA) name of the merchant that owns the funding balance.
     */
    #[JsonProperty('merchant')]
    public string $merchant;

    /**
     * Name of the account holder who owns the funding account that received funds.
     *
     * **Note:** We return a value for recipient only if the value for type is `debit`.
     *
     * @var ?string $recipient
     */
    #[JsonProperty('recipient')]
    public ?string $recipient;

    /**
     * @var string $description Description of the activity.
     */
    #[JsonProperty('description')]
    public string $description;

    /**
     * @var float $amount Total amount that we removed or added to the merchant's funding balance. The value is in the currency’s lowest denomination, for example, cents.
     */
    #[JsonProperty('amount')]
    public float $amount;

    /**
     * Indicates if we moved funds into or out of the funding balance. Our gateway returns one of the following values:
     * -	`credit` - We moved funds into the funding balance.
     * -	`debit` - We moved funds out of the funding balance.
     *
     * @var value-of<ActivityRecordType> $type
     */
    #[JsonProperty('type')]
    public string $type;

    /**
     * @var string $currency Currency of the funds. We return a value of `USD`.
     */
    #[JsonProperty('currency')]
    public string $currency;

    /**
     * @param array{
     *   id: int,
     *   date: string,
     *   merchant: string,
     *   description: string,
     *   amount: float,
     *   type: value-of<ActivityRecordType>,
     *   currency: string,
     *   recipient?: ?string,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->id = $values['id'];
        $this->date = $values['date'];
        $this->merchant = $values['merchant'];
        $this->recipient = $values['recipient'] ?? null;
        $this->description = $values['description'];
        $this->amount = $values['amount'];
        $this->type = $values['type'];
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
