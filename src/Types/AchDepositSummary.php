<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains information about the ACH deposit.
 */
class AchDepositSummary extends JsonSerializableType
{
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
     *   achDepositId?: ?int,
     *   link?: ?Link,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
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
