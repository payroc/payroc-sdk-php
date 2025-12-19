<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;
use DateTime;
use Payroc\Core\Types\Date;

/**
 * Object that contains information about the current status of the dispute.
 */
class DisputeStatus extends JsonSerializableType
{
    /**
     * @var ?int $disputeStatusId Unique identifier that we assigned to the status of the dispute.
     */
    #[JsonProperty('disputeStatusId')]
    public ?int $disputeStatusId;

    /**
     * Status of the dispute.
     *
     * **Note:** If you want to view the status history of the dispute, use our [List Dispute Statuses](https://docs.payroc.com/api/schema/reporting/settlement/list-disputes-statuses) method.
     *
     * @var ?value-of<DisputeStatusStatus> $status
     */
    #[JsonProperty('status')]
    public ?string $status;

    /**
     * @var ?DateTime $statusDate Date that the status of the dispute was last changed. The format of this value is **YYYY-MM-DD**.
     */
    #[JsonProperty('statusDate'), Date(Date::TYPE_DATE)]
    public ?DateTime $statusDate;

    /**
     * @param array{
     *   disputeStatusId?: ?int,
     *   status?: ?value-of<DisputeStatusStatus>,
     *   statusDate?: ?DateTime,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->disputeStatusId = $values['disputeStatusId'] ?? null;
        $this->status = $values['status'] ?? null;
        $this->statusDate = $values['statusDate'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
