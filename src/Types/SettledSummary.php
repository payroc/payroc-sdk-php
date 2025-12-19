<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;
use DateTime;
use Payroc\Core\Types\Date;

/**
 * Object that contains information about the settlement.
 */
class SettledSummary extends JsonSerializableType
{
    /**
     * @var ?string $settledBy Processor that settled the transaction.
     */
    #[JsonProperty('settledBy')]
    public ?string $settledBy;

    /**
     * @var ?DateTime $achDate Date that the processor settled the transaction. The format of this value is **YYYY-MM-DD**.
     */
    #[JsonProperty('achDate'), Date(Date::TYPE_DATE)]
    public ?DateTime $achDate;

    /**
     * @var ?int $achDepositId Unique identifier of the ACH deposit.
     */
    #[JsonProperty('achDepositId')]
    public ?int $achDepositId;

    /**
     * @var ?Link $link
     */
    #[JsonProperty('link')]
    public ?Link $link;

    /**
     * @param array{
     *   settledBy?: ?string,
     *   achDate?: ?DateTime,
     *   achDepositId?: ?int,
     *   link?: ?Link,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->settledBy = $values['settledBy'] ?? null;
        $this->achDate = $values['achDate'] ?? null;
        $this->achDepositId = $values['achDepositId'] ?? null;
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
