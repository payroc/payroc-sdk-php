<?php

namespace Payroc\Reporting\Settlement\Requests;

use Payroc\Core\Json\JsonSerializableType;
use DateTime;

class ListReportingSettlementAchDepositsRequest extends JsonSerializableType
{
    /**
     * Return the previous page of results before the value that you specify.
     *
     * You can’t send the before parameter in the same request as the after parameter.
     *
     * @var ?string $before
     */
    public ?string $before;

    /**
     * Return the next page of results after the value that you specify.
     *
     * You can’t send the after parameter in the same request as the before parameter.
     *
     * @var ?string $after
     */
    public ?string $after;

    /**
     * @var ?int $limit Limit the maximum number of results that we return for each page.
     */
    public ?int $limit;

    /**
     * @var DateTime $date Filter results by the date that the merchant received the ACH deposit.
     */
    public DateTime $date;

    /**
     * @var ?string $merchantId Filter results by the unique identifier that the processor assigned to the merchant.
     */
    public ?string $merchantId;

    /**
     * @param array{
     *   date: DateTime,
     *   before?: ?string,
     *   after?: ?string,
     *   limit?: ?int,
     *   merchantId?: ?string,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->before = $values['before'] ?? null;
        $this->after = $values['after'] ?? null;
        $this->limit = $values['limit'] ?? null;
        $this->date = $values['date'];
        $this->merchantId = $values['merchantId'] ?? null;
    }
}
