<?php

namespace Payroc\Traits;

use Payroc\Types\DisputeStatusStatus;
use DateTime;
use Payroc\Core\Json\JsonProperty;
use Payroc\Core\Types\Date;

/**
 * Object that contains information about the current status of the dispute.
 *
 * @property ?int $disputeStatusId
 * @property ?value-of<DisputeStatusStatus> $status
 * @property ?DateTime $statusDate
 */
trait DisputeStatus
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
}
