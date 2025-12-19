<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;
use DateTime;
use Payroc\Core\Types\Date;

/**
 * Object that contains information about the batch. If we can't match a dispute to a batch, we don't return 'batch' object.
 */
class BatchSummary extends JsonSerializableType
{
    /**
     * @var ?int $batchId Unique identifier of the batch.
     */
    #[JsonProperty('batchId')]
    public ?int $batchId;

    /**
     * @var ?DateTime $date Date that the merchant submitted the batch.
     */
    #[JsonProperty('date'), Date(Date::TYPE_DATE)]
    public ?DateTime $date;

    /**
     * @var ?string $cycle Indicates the cycle that contains the batch.
     */
    #[JsonProperty('cycle')]
    public ?string $cycle;

    /**
     * @var ?Link $link
     */
    #[JsonProperty('link')]
    public ?Link $link;

    /**
     * @param array{
     *   batchId?: ?int,
     *   date?: ?DateTime,
     *   cycle?: ?string,
     *   link?: ?Link,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->batchId = $values['batchId'] ?? null;
        $this->date = $values['date'] ?? null;
        $this->cycle = $values['cycle'] ?? null;
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
