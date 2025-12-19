<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;
use DateTime;
use Payroc\Core\Types\Date;

/**
 * Object that contains summary information about the transaction that the dispute is linked to.
 */
class TransactionSummary extends JsonSerializableType
{
    /**
     * @var ?int $transactionId Unique identifier of the transaction. If we can't match a dispute to a transaction, we don't return the transactionId or link object.
     */
    #[JsonProperty('transactionId')]
    public ?int $transactionId;

    /**
     * @var ?value-of<TransactionSummaryType> $type Indicates the type of transaction.
     */
    #[JsonProperty('type')]
    public ?string $type;

    /**
     * @var ?DateTime $date Date of the transaction. The format of this value is **YYYY-MM-DD**.
     */
    #[JsonProperty('date'), Date(Date::TYPE_DATE)]
    public ?DateTime $date;

    /**
     * @var ?value-of<TransactionSummaryEntryMethod> $entryMethod Describes how the merchant received the payment details. If we can't match a dispute to a transaction, we don't return an entryMethod object.
     */
    #[JsonProperty('entryMethod')]
    public ?string $entryMethod;

    /**
     * @var ?int $amount Total amount of the transaction. The value is in the currency's lowest denomination, for example, cents.
     */
    #[JsonProperty('amount')]
    public ?int $amount;

    /**
     * @var ?Link $link
     */
    #[JsonProperty('link')]
    public ?Link $link;

    /**
     * @param array{
     *   transactionId?: ?int,
     *   type?: ?value-of<TransactionSummaryType>,
     *   date?: ?DateTime,
     *   entryMethod?: ?value-of<TransactionSummaryEntryMethod>,
     *   amount?: ?int,
     *   link?: ?Link,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->transactionId = $values['transactionId'] ?? null;
        $this->type = $values['type'] ?? null;
        $this->date = $values['date'] ?? null;
        $this->entryMethod = $values['entryMethod'] ?? null;
        $this->amount = $values['amount'] ?? null;
        $this->link = $values['link'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
