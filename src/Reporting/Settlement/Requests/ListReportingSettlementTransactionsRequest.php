<?php

namespace Payroc\Reporting\Settlement\Requests;

use Payroc\Core\Json\JsonSerializableType;
use DateTime;
use Payroc\Reporting\Settlement\Types\ListTransactionsSettlementRequestTransactionType;

class ListReportingSettlementTransactionsRequest extends JsonSerializableType
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
     * Filter transactions by the date that the merchant submitted the batch that contains the transaction. The format of this value is **YYYY-MM-DD**.
     *
     * You must provide either the batchId or the date.
     *
     * @var ?DateTime $date
     */
    public ?DateTime $date;

    /**
     * Filter transactions by the unique identifier of the batch that contains the transaction.
     *
     * You must provide either the batchId or the date.
     *
     * @var ?int $batchId
     */
    public ?int $batchId;

    /**
     * @var ?string $merchantId Filter results by the unique identifier that the processor assigned to the merchant.
     */
    public ?string $merchantId;

    /**
     * @var ?value-of<ListTransactionsSettlementRequestTransactionType> $transactionType Filter transactions by transaction type.
     */
    public ?string $transactionType;

    /**
     * @param array{
     *   before?: ?string,
     *   after?: ?string,
     *   limit?: ?int,
     *   date?: ?DateTime,
     *   batchId?: ?int,
     *   merchantId?: ?string,
     *   transactionType?: ?value-of<ListTransactionsSettlementRequestTransactionType>,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->before = $values['before'] ?? null;
        $this->after = $values['after'] ?? null;
        $this->limit = $values['limit'] ?? null;
        $this->date = $values['date'] ?? null;
        $this->batchId = $values['batchId'] ?? null;
        $this->merchantId = $values['merchantId'] ?? null;
        $this->transactionType = $values['transactionType'] ?? null;
    }
}
