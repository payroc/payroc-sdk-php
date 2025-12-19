<?php

namespace Payroc\Boarding\ProcessingAccounts\Requests;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Boarding\ProcessingAccounts\Types\ListTerminalOrdersProcessingAccountsRequestStatus;
use DateTime;

class ListTerminalOrdersProcessingAccountsRequest extends JsonSerializableType
{
    /**
     * @var ?value-of<ListTerminalOrdersProcessingAccountsRequestStatus> $status
     */
    public ?string $status;

    /**
     * @var ?DateTime $fromDateTime
     */
    public ?DateTime $fromDateTime;

    /**
     * @var ?DateTime $toDateTime
     */
    public ?DateTime $toDateTime;

    /**
     * @param array{
     *   status?: ?value-of<ListTerminalOrdersProcessingAccountsRequestStatus>,
     *   fromDateTime?: ?DateTime,
     *   toDateTime?: ?DateTime,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->status = $values['status'] ?? null;
        $this->fromDateTime = $values['fromDateTime'] ?? null;
        $this->toDateTime = $values['toDateTime'] ?? null;
    }
}
