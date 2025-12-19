<?php

namespace Payroc\CardPayments\Payments\Requests;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\CardPayments\Payments\Types\ListPaymentsRequestTender;
use Payroc\CardPayments\Payments\Types\ListPaymentsRequestTipModeItem;
use Payroc\CardPayments\Payments\Types\ListPaymentsRequestTypeItem;
use Payroc\CardPayments\Payments\Types\ListPaymentsRequestStatusItem;
use DateTime;
use Payroc\CardPayments\Payments\Types\ListPaymentsRequestSettlementState;

class ListPaymentsRequest extends JsonSerializableType
{
    /**
     * @var ?string $processingTerminalId Filter by terminal ID.
     */
    public ?string $processingTerminalId;

    /**
     * @var ?string $orderId Filter payments by order ID.
     */
    public ?string $orderId;

    /**
     * @var ?string $operator Filter payments by operator.
     */
    public ?string $operator;

    /**
     * @var ?string $cardholderName Filter payments by the cardholder’s name.
     */
    public ?string $cardholderName;

    /**
     * @var ?string $first6 Filter payments by the first six digits of the card number that the customer used in the transaction.
     */
    public ?string $first6;

    /**
     * @var ?string $last4 Filter payments by the last four digits of the card number that the customer used in the transaction.
     */
    public ?string $last4;

    /**
     * @var ?value-of<ListPaymentsRequestTender> $tender Filter by tender type.
     */
    public ?string $tender;

    /**
     * @var ?array<value-of<ListPaymentsRequestTipModeItem>> $tipMode Filter payments by tip.
     */
    public ?array $tipMode;

    /**
     * @var ?array<value-of<ListPaymentsRequestTypeItem>> $type Filter payments by transaction type.
     */
    public ?array $type;

    /**
     * @var ?array<value-of<ListPaymentsRequestStatusItem>> $status Filter payments by the status of the transaction.
     */
    public ?array $status;

    /**
     * @var ?DateTime $dateFrom Filter by payments that the processor processed after a specific date. The date format follows the ISO 8601 standard.
     */
    public ?DateTime $dateFrom;

    /**
     * @var ?DateTime $dateTo Filter by payments that the processer processed before a specific date. The date format follows the ISO 8601 standard.
     */
    public ?DateTime $dateTo;

    /**
     * @var ?value-of<ListPaymentsRequestSettlementState> $settlementState Filter payments by the settlement status of the transaction.
     */
    public ?string $settlementState;

    /**
     * @var ?DateTime $settlementDate Filter by payments that the processor settled on a specific date in the format **YYYY-MM-DD**.
     */
    public ?DateTime $settlementDate;

    /**
     * @var ?string $paymentLinkId Unique identifier that our gateway assigned to the payment link.
     */
    public ?string $paymentLinkId;

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
     *   tender?: ?value-of<ListPaymentsRequestTender>,
     *   tipMode?: ?array<value-of<ListPaymentsRequestTipModeItem>>,
     *   type?: ?array<value-of<ListPaymentsRequestTypeItem>>,
     *   status?: ?array<value-of<ListPaymentsRequestStatusItem>>,
     *   dateFrom?: ?DateTime,
     *   dateTo?: ?DateTime,
     *   settlementState?: ?value-of<ListPaymentsRequestSettlementState>,
     *   settlementDate?: ?DateTime,
     *   paymentLinkId?: ?string,
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
        $this->tipMode = $values['tipMode'] ?? null;
        $this->type = $values['type'] ?? null;
        $this->status = $values['status'] ?? null;
        $this->dateFrom = $values['dateFrom'] ?? null;
        $this->dateTo = $values['dateTo'] ?? null;
        $this->settlementState = $values['settlementState'] ?? null;
        $this->settlementDate = $values['settlementDate'] ?? null;
        $this->paymentLinkId = $values['paymentLinkId'] ?? null;
        $this->before = $values['before'] ?? null;
        $this->after = $values['after'] ?? null;
        $this->limit = $values['limit'] ?? null;
    }
}
