<?php

namespace Payroc\Funding\FundingActivity\Requests;

use Payroc\Core\Json\JsonSerializableType;
use DateTime;

class ListFundingActivityRequest extends JsonSerializableType
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
     * @var DateTime $dateFrom Filter by activity after a specific date. Send a value in **YYYY-MM-DD** format.
     */
    public DateTime $dateFrom;

    /**
     * @var DateTime $dateTo Filter by activity before a specific date. Send a value in **YYYY-MM-DD** format.
     */
    public DateTime $dateTo;

    /**
     * @var ?string $merchantId Filter results by the unique identifier that the processor assigned to the merchant.
     */
    public ?string $merchantId;

    /**
     * @param array{
     *   dateFrom: DateTime,
     *   dateTo: DateTime,
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
        $this->dateFrom = $values['dateFrom'];
        $this->dateTo = $values['dateTo'];
        $this->merchantId = $values['merchantId'] ?? null;
    }
}
