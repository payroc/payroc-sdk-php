<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Traits\DisputeStatus;
use Payroc\Core\Json\JsonProperty;
use DateTime;

/**
 * Object that contains information about the current status of the dispute.
 */
class DisputeCurrentStatus extends JsonSerializableType
{
    use DisputeStatus;

    /**
     * @var ?Link $link
     */
    #[JsonProperty('link')]
    public ?Link $link;

    /**
     * @param array{
     *   disputeStatusId?: ?int,
     *   status?: ?value-of<DisputeStatusStatus>,
     *   statusDate?: ?DateTime,
     *   link?: ?Link,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->disputeStatusId = $values['disputeStatusId'] ?? null;
        $this->status = $values['status'] ?? null;
        $this->statusDate = $values['statusDate'] ?? null;
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
