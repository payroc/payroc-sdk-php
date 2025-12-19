<?php

namespace Payroc\CardPayments\Refunds\Requests;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\CardPayments\Refunds\Types\ListRefundsRequestTender;
use Payroc\CardPayments\Refunds\Types\ListRefundsRequestStatusItem;
use DateTime;
use Payroc\CardPayments\Refunds\Types\ListRefundsRequestSettlementState;

class ListRefundsRequest extends JsonSerializableType
{
    /**
     * @var ?string $processingTerminalId Filter by terminal ID.
     */
    public ?string $processingTerminalId;

    /**
     * @var ?string $orderId Filter refunds by the unique identifier that the merchant assigned to the order.
     */
    public ?string $orderId;

    /**
     * @var ?string $operator Filter refunds by the operator who initiated the request.
     */
    public ?string $operator;

    /**
     * @var ?string $cardholderName Filter refunds by cardholder name.
     */
    public ?string $cardholderName;

    /**
     * @var ?string $first6 Filter refunds by the first six digits of the card number.
     */
    public ?string $first6;

    /**
     * @var ?string $last4 Filter refunds by the last four digits of the card number.
     */
    public ?string $last4;

    /**
     * @var ?value-of<ListRefundsRequestTender> $tender Filter by tender type.
     */
    public ?string $tender;

    /**
     * @var ?array<value-of<ListRefundsRequestStatusItem>> $status Filter refunds by the current status of the refund.
     */
    public ?array $status;

    /**
     * @var ?DateTime $dateFrom Filter by refunds processed after a specific date. The date format follows the ISO 8601 standard.
     */
    public ?DateTime $dateFrom;

    /**
     * @var ?DateTime $dateTo Filter by refunds processed before a specific date. The date format follows the ISO 8601 standard.
     */
    public ?DateTime $dateTo;

    /**
     * @var ?value-of<ListRefundsRequestSettlementState> $settlementState Status of the settlement.
     */
    public ?string $settlementState;

    /**
     * @var ?DateTime $settlementDate Date the transaction was settled.
     */
    public ?DateTime $settlementDate;

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
     * @param array{
     *   processingTerminalId?: ?string,
     *   orderId?: ?string,
     *   operator?: ?string,
     *   cardholderName?: ?string,
     *   first6?: ?string,
     *   last4?: ?string,
     *   tender?: ?value-of<ListRefundsRequestTender>,
     *   status?: ?array<value-of<ListRefundsRequestStatusItem>>,
     *   dateFrom?: ?DateTime,
     *   dateTo?: ?DateTime,
     *   settlementState?: ?value-of<ListRefundsRequestSettlementState>,
     *   settlementDate?: ?DateTime,
     *   before?: ?string,
     *   after?: ?string,
     *   limit?: ?int,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->processingTerminalId = $values['processingTerminalId'] ?? null;
        $this->orderId = $values['orderId'] ?? null;
        $this->operator = $values['operator'] ?? null;
        $this->cardholderName = $values['cardholderName'] ?? null;
        $this->first6 = $values['first6'] ?? null;
        $this->last4 = $values['last4'] ?? null;
        $this->tender = $values['tender'] ?? null;
        $this->status = $values['status'] ?? null;
        $this->dateFrom = $values['dateFrom'] ?? null;
        $this->dateTo = $values['dateTo'] ?? null;
        $this->settlementState = $values['settlementState'] ?? null;
        $this->settlementDate = $values['settlementDate'] ?? null;
        $this->before = $values['before'] ?? null;
        $this->after = $values['after'] ?? null;
        $this->limit = $values['limit'] ?? null;
    }
}
